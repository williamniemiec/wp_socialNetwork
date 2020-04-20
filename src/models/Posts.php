<?php
namespace models;

use core\Model;


/**
 * Responsible for posts management.
 */
class Posts extends Model
{
    //-----------------------------------------------------------------------
    //        Attributes
    //-----------------------------------------------------------------------
    private $id_user;
    
    
    //-----------------------------------------------------------------------
    //        Constructor
    //-----------------------------------------------------------------------
    /**
     * Creates groups manager.
     *
     * @param int $id_user Id of the current user
     */
    public function __construct($id_user)
    {
        parent::__construct();
        $this->id_user = $id_user;
    }
    
    
    //-----------------------------------------------------------------------
    //        Methods
    //-----------------------------------------------------------------------
    /**
     * Adds a new post. The content of the post can have:
     * <ul>
     *      <li>Message</li>
     *      <li>Photo</li>
     *      <li>Message and photo</li>
     * </ul>
     * 
     * @param string $msg Message of the post
     * @param array $photo Photo that will be displayed in the post
     * @param number $id_group [optional] Id of the group that the post belongs
     */
    public function add($msg, $photo, $id_group = 0)
    {
        // Checks if a photo was submitted
        if (!empty($photo) && $this->isPhoto($photo)) {
            // Saves the photo
            $filename = md5(time().rand(0,999));
            $extension = explode("/", $photo['type']);
            $extension = ".".$extension[1];
            $url = $filename.$extension;
            
            move_uploaded_file($photo['tmp_name'], "assets/images/posts/".$url);
            
            // Saves on database
            $sql = "INSERT INTO posts (id_user,date_creation,type,text,url,id_group) VALUES ($this->id_user,NOW(),'photo',?,'$url',?)";
        } else {
            $sql = "INSERT INTO posts (id_user,date_creation,type,text,id_group) VALUES ($this->id_user,NOW(),'text',?,?)";
        }
        
        $sql = $this->db->prepare($sql);
        $sql->execute(array($msg, $id_group));
    }
    
    /**
     * Gets all posts that can be displayed to the current user in its feed. If is
     * passed the id of a group, it will display all posts that can be displayed 
     * to the current user in this group. 
     * 
     * @param int $id_group [optional] Id of the group
     * @return int Number of posts that can be displayed to the current user
     */
    public function countPosts($id_group = 0)
    {        
        $users = new Relationships($_SESSION['sn_login']);
        $friendsIds = $users->getFriendsIds();
        $groups = new Groups($_SESSION['sn_login']);
        $myGroupsIds = $groups->getMyGroups();
        
        $where = $id_group == 0 ? "id_user IN (".implode(",",$friendsIds).") OR id_group IN (".implode(",",$myGroupsIds).")" : "id_group = ".intval($id_group);
        
        $sql = $this->db->query("
            SELECT
                COUNT(*) as count
            FROM posts
            WHERE ".$where."
        ");
        
        return $sql->fetch()['count'];
    }
    
    /**
     * Removes a post.
     * 
     * @param int $id_post Id of the post
     */
    public function remove($id_post)
    {
        if (empty($id_post)) { return; }
        
        $sql = $this->db->prepare("DELETE FROM posts WHERE id = ? AND id_user = $this->id_user");
        $sql->execute(array($id_post));
        
        if ($sql->rowCount() > 0) {
            $sql = $this->db->prepare("DELETE FROM posts_comments WHERE id_post = ?");
            $sql->execute(array($id_post));
            
            $sql = $this->db->prepare("DELETE FROM posts_likes WHERE id_post = ?");
            $sql->execute(array($id_post));
        }
    }
    
    /**
     * Adds a like in a post made by the current user.
     * 
     * @param int $id_post Id of the post
     */
    public function like($id_post)
    {
        if (empty($id_post))                 { return; }
        if ($this->alreadyLiked($id_post))   { return; }
        
        $sql = $this->db->prepare("INSERT INTO posts_likes (id_user,id_post) VALUES ($this->id_user,?)");
        $sql->execute(array($id_post));
        
    }
    
    /**
     * Removes a like from a post that was made by the current user.
     *
     * @param int $id_post Id of the post
     */
    public function unlike($id_post)
    {
        if (empty($id_post)) { return; }
        
        $sql = $this->db->prepare("DELETE FROM posts_likes WHERE id_user = $this->id_user AND id_post = ?");
        $sql->execute(array($id_post));
    }
    
    /**
     * Adds a new comment in a post made by the current user.
     * 
     * @param int $id_post Id of the post
     * @param string $text Content of the comment
     * @return int Id of the added comment or -1 if an error occurred
     */
    public function addComment($id_post, $text)
    {
        if (empty($id_post) || empty($text)) { return -1; }
        
        $response = -1;
        
        $sql = $this->db->prepare("INSERT INTO posts_comments (id_user,id_post,date_creation,text) VALUES ($this->id_user,?,NOW(),?)");
        $sql->execute(array($id_post,$text));
        
        if ($sql->rowCount() > 0)
            $response = $this->db->lastInsertId();
        
        return $response;
    }
    
    /**
     * Deletes a comment from a post made by the current user.
     *
     * @param int $id_post_comment Id of the comment of this post
     */
    public function deleteComment($id_post_comment)
    {
        if (empty($id_post_comment)) { return; }
        
        $sql = $this->db->prepare("DELETE FROM posts_comments WHERE id = ? AND id_user = $this->id_user");
        $sql->execute(array($id_post_comment));
    }
    
    /**
     * Gets posts from current user, its friends and its groups. If is passed 
     * the id of a group, it will be got posts from this group.
     *
     * @param int $page Current page
     * @param int $resultsPerPage Number of results displayed in a page
     * @param int $id_group [optional] Id of the group
     * @return array Posts
     */
    public function getPosts($page, $resultsPerPage, $id_group = 0)
    {
        $response = array();
        
        // Gets all ids of the friends of the current user
        $users = new Relationships($this->id_user);
        $friendsIds = $users->getFriendsIds();
        
        // Gets all ids of the groups of the current user
        $groups = new Groups($_SESSION['sn_login']);
        $myGroupsIds = $groups->getMyGroups();
        
        $where = $id_group == 0 ?   "id_user IN (".implode(",",$friendsIds).") OR id_group IN (".implode(",",$myGroupsIds).")" : 
                                    "id_group = ".intval($id_group);
        
        $offset = ($page-1) * $resultsPerPage;
        
        $sql = $this->db->query("
            SELECT
                *,
                (select users.name from users where users.id = posts.id_user) as name,
                (select count(*) from posts_likes where posts_likes.id_user = $this->id_user and posts_likes.id_post = posts.id) as liked,
                (select count(*) from posts_likes where posts_likes.id_post = posts.id) as totalLikes,
                (select groups.title from groups where groups.id = posts.id_group) as groupName
            FROM posts
            WHERE ".$where."
            ORDER BY date_creation DESC
            LIMIT $offset,$resultsPerPage
        ");
        
        if ($sql->rowCount() > 0) {
            $response = $sql->fetchAll();
            
            // Gets all comments from each post
            for ($i=0; $i<count($response); $i++) {
                $sql = $this->db->query("
                    SELECT
                        *,
                        (select users.name from users where users.id = posts_comments.id_user) as name
                    FROM posts_comments
                    WHERE id_post = ".$response[$i]['id']."
                    ORDER BY date_creation DESC
                ");
                
                if ($sql->rowCount() > 0)
                    $response[$i]['comments'] = $sql->fetchAll();
                    else
                        $response[$i]['comments'] = array();
            }
        }
        
        return $response;
    }
    
    /**
     * Gets posts from a group respecting the limit value.
     * 
     * @param int $id_group Id of the group
     * @param int $limit [optional] Maximum of groups that will be returned
     * @return array Posts
     */
    public function getPostsInGroup($id_group, $limit = 10)
    {
        if (empty($id_group)) { return array(); }
        
        $response = array();
        
        $sql = $this->db->prepare("SELECT * FROM posts WHERE id_group = ? LIMIT $limit");
        $sql->execute(array($id_group));
        
        if ($sql->rowCount() > 0) {
            $response = $sql->fetchAll();
        }
        
        return $response;
    }
    
    /**
     * Checks if a post has already been liked by the current user.
     * 
     * @param int $id_post Id of the post
     * @return boolean If the post has already been liked by the current user
     */
    private function alreadyLiked($id_post)
    {
        $sql = $this->db->prepare("SELECT COUNT(*) AS count FROM posts_likes WHERE id_user = $this->id_user AND id_post = ?");
        $sql->execute(array($id_post));
        
        return $sql->fetch()['count'] > 0;
    }
    
    /**
     * Checks if a submitted photo is really a photo.
     * 
     * @param array $photo Submitted photo
     * @return boolean If the photo is really a photo
     */
    private function isPhoto($photo)
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $photo['tmp_name']);
        finfo_close($finfo);
        
        return explode("/", $mime)[0] == "image";
    }
}