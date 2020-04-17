<?php
namespace models;

use core\Model;
use models\Relationships;
use models\Groups;


/**

 */
class Posts extends Model
{
    //-----------------------------------------------------------------------
    //        Attributes
    //-----------------------------------------------------------------------
    private $id;
    
    
    //-----------------------------------------------------------------------
    //        Constructor
    //-----------------------------------------------------------------------
    public function __construct($id)
    {
        parent::__construct();
        $this->id = $id;
    }
    
    
    //-----------------------------------------------------------------------
    //        Methods
    //-----------------------------------------------------------------------
    public function add($msg, $photo, $id_group = 0)
    {
        //if (empty($msg)) { return; }
        
        if (!empty($photo) && $this->isPhoto($photo)) {
            // Saves photos
            $filename = md5(time().rand(0,999));
            $extension = explode("/", $photo['type']);
            $extension = ".".$extension[1];
            $url = $filename.$extension;
            
            move_uploaded_file($photo['tmp_name'], "assets/images/posts/".$url);
            
            // Saves on database
            $sql = "INSERT INTO posts (id_user,date_creation,type,text,url,id_group) VALUES ($this->id,NOW(),'photo',?,'$url',?)";
            //die($sql);
        } else {
            $sql = "INSERT INTO posts (id_user,date_creation,type,text,id_group) VALUES ($this->id,NOW(),'text',?,?)";
        }
        $sql = $this->db->prepare($sql);
        $sql->execute(array($msg, $id_group));
    }
    
    public function getPosts($page, $usersPerPage, $id_group = 0)
    {
        $response = array();
        
        $users = new Relationships($_SESSION['sn_login']);
        $friendsIds = $users->getFriendsIds();
        $groups = new Groups($_SESSION['sn_login']);
        $myGroupsIds = $groups->getMyAds();
        
        $where = $id_group == 0 ? "id_user IN (".implode(",",$friendsIds).") OR id_group IN (".implode(",",$myGroupsIds).")" : "id_group = ".intval($id_group);
        $offset = ($page-1) * $usersPerPage;
        
        $sql = $this->db->query("
            SELECT 
                *,
                (select users.name from users where users.id = posts.id_user) as name,
                (select count(*) from posts_likes where posts_likes.id_user = $this->id and posts_likes.id_post = posts.id) as liked,
                (select count(*) from posts_likes where posts_likes.id_post = posts.id) as totalLikes,
                (select groups.title from groups where groups.id = posts.id_group) as groupName
            FROM posts 
            WHERE ".$where."
            ORDER BY date_creation DESC 
            LIMIT $offset,$usersPerPage
        ");
        
        if ($sql->rowCount() > 0) {
            $response = $sql->fetchAll();
            
            // Gets comments from each post
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
    
    public function countPosts($id_group = 0)
    {        
        $users = new Relationships($_SESSION['sn_login']);
        $friendsIds = $users->getFriendsIds();
        $groups = new Groups($_SESSION['sn_login']);
        $myGroupsIds = $groups->getMyAds();
        
        $where = $id_group == 0 ? "id_user IN (".implode(",",$friendsIds).") OR id_group IN (".implode(",",$myGroupsIds).")" : "id_group = ".intval($id_group);
        
        $sql = $this->db->query("
            SELECT
                COUNT(*) as count
            FROM posts
            WHERE ".$where."
        ");
        
        return $sql->fetch()['count'];
    }
    
    public function remove($id)
    {
        if (empty($id)) { return; }
        
        $sql = $this->db->prepare("DELETE FROM posts WHERE id = ? AND id_user = $this->id");
        $sql->execute(array($id));
        
        // Necessary for protection
        if ($sql->rowCount() > 0) {
            $sql = $this->db->prepare("DELETE FROM posts_comments WHERE id_post = ?");
            $sql->execute(array($id));
            
            $sql = $this->db->prepare("DELETE FROM posts_likes WHERE id_post = ?");
            $sql->execute(array($id));
        }
    }
    
    public function like($id)
    {
        if (empty($id))                 { return; }
        if ($this->alreadyLiked($id))   { return; }
        
        $sql = $this->db->prepare("INSERT INTO posts_likes (id_user,id_post) VALUES ($this->id,?)");
        $sql->execute(array($id));
        
    }
    
    public function unlike($id)
    {
        if (empty($id)) { return; }
        
        $sql = $this->db->prepare("DELETE FROM posts_likes WHERE id_user = $this->id AND id_post = ?");
        $sql->execute(array($id));
    }
        
    public function addComment($id, $text)
    {
        if (empty($id) || empty($text)) { return; }
        
        $sql = $this->db->prepare("INSERT INTO posts_comments (id_user,id_post,date_creation,text) VALUES ($this->id,?,NOW(),?)");
        $sql->execute(array($id,$text));
        
        if ($sql->rowCount() > 0)
            return $this->db->lastInsertId();
        
        return -1;
    }
    
    public function deleteComment($id)
    {
        if (empty($id)) { return; }
        
        $sql = $this->db->prepare("DELETE FROM posts_comments WHERE id = ? AND id_user = $this->id");
        $sql->execute(array($id));
    }
    
    public function getPostsInGroup($id_group, $limit = 10)
    {
        if (empty($id_group)) { return; }
        
        $response = array();
        
        $sql = $this->db->prepare("SELECT * FROM posts WHERE id_group = ? LIMIT $limit");
        $sql->execute(array($id_group));
        
        if ($sql->rowCount() > 0) {
            $response = $sql->fetchAll();
        }
        
        return $response;
    }
    
    private function alreadyLiked($id)
    {
        $sql = $this->db->prepare("SELECT COUNT(*) AS count FROM posts_likes WHERE id_user = $this->id AND id_post = ?");
        $sql->execute(array($id));
        
        return $sql->fetch()['count'] > 0;
    }
    
    private function isPhoto($photo)
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $photo['tmp_name']);
        finfo_close($finfo);
        
        return explode("/", $mime)[0] == "image";
    }
}