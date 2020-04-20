<?php
namespace models;

use core\Model;


/**
 * Responsible for managing relationships between users.
 */
class Relationships extends Model
{
    //-----------------------------------------------------------------------
    //        Attributes
    //-----------------------------------------------------------------------
    private $id_user;
    
    
    //-----------------------------------------------------------------------
    //        Constructor
    //-----------------------------------------------------------------------
    /**
     * Creates relationship manager between users.
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
     * Creates a friend request between the current user and another user.
     * 
     * @param int $id_user Id of the user that will be requested
     * @return boolean If the request was successfully registered
     */
    public function addFriend($id_user)
    {
        if (!$this->existUser($id_user)) { return false; }
        
        $sql = $this->db->prepare("INSERT INTO relationships (user_from,user_to) VALUES ($this->id_user,?)");
        $sql->execute(array($id_user));
        
        
        return $sql && $sql->rowCount() > 0;
    }
    
    /**
     * Accepts a user who has requested a friendship with the current user.
     * 
     * @param int $id_user Id of the accepted user
     * @return boolean If the friendship request was successfully accepted 
     */
    public function acceptFriend($id_user)
    {
        $sql = $this->db->prepare("UPDATE relationships SET status = 1 WHERE user_from = ? AND user_to = $this->id_user");
        $sql->execute(array($id_user));
        
        return $sql && $sql->rowCount() > 0;
    }
    
    /**
     * Removes a user from friends of the current user. It is also used to
     * reject a friendship request.
     *
     * @param int $id_user Id of the user to be removed / rejected
     */
    public function removeFriend($id_user)
    {
        $sql = $this->db->prepare("
            DELETE FROM
                relationships
            WHERE
                (user_from = $this->id_user AND user_to = ?) OR
                (user_to = $this->id_user AND user_from = ?)
        ");
        
        $sql->execute(array($id_user, $id_user));
    }
    
    /**
     * Gets friend suggestions to the current user.
     *
     * @param int $limit Maximum of friend suggestions
     * @return array Suggested users
     */
    public function getSuggestions($limit = 5)
    {
        $response = array();
        
        $sql = "
            SELECT
            	*
            FROM
                users
            WHERE
                users.id != $this->id_user AND
            	users.id NOT IN(select relationships.user_from from relationships WHERE relationships.user_from = $this->id_user OR relationships.user_to = $this->id_user) AND
                users.id NOT IN(select relationships.user_to from relationships WHERE relationships.user_from = $this->id_user OR relationships.user_to = $this->id_user)
            ORDER BY RAND()
        ";
        
        $sql .= " LIMIT ".intval($limit);
        
        $sql = $this->db->query($sql);
        
        if ($sql->rowCount() > 0) {
            $response = $sql->fetchAll();
        }
        
        return $response;
    }
    
    /**
     * Gets all friendship requests for the current user.
     *
     * @return array Users who requested friendship with the current user
     */
    public function getFriendshipRequests()
    {
        $response = array();
        
        $sql = "
            SELECT
                relationships.user_from AS id,
                (select users.name from users where users.id = relationships.user_from) AS name
            FROM
            	relationships
            WHERE
                relationships.user_to = $this->id_user AND
                relationships.status = 0
        ";
        
        $sql = $this->db->query($sql);
        
        if ($sql && $sql->rowCount() > 0) {
            $response = $sql->fetchAll();
        }
        
        return $response;
    }
    
    /**
     * Gets all friends of the current user (respecting the limit value).
     * 
     * @param int $limit Maximum of friends that will be returned
     * @return array Friends of the current user
     */
    public function getFriends($limit = 10)
    {
        $response = array();
        $friendIds = $this->getFriendsIds();
        
        $sql = "
            SELECT
                id,
                name
            FROM
                users
            WHERE
                id != $this->id_user AND
                id IN (".implode(",", $friendIds).")
        ";
        
        $sql = $this->db->query($sql);
        if ($sql->rowCount() > 0) {
            $response = $sql->fetchAll();
        }
        
        return $response;
    }
    
    /**
     * Gets the id of all friends of the current user.
     *
     * @return array Id of all friends of the current user
     */
    public function getFriendsIds()
    {
        $response = array();
        
        $sql = "SELECT * FROM relationships WHERE (user_from = $this->id_user OR user_to = $this->id_user) AND status = 1";
        $sql = $this->db->query($sql);
        
        if ($sql->rowCount() > 0) {
            foreach ($sql->fetchAll() as $item) {
                $response[] = $item['user_from'];
                $response[] = $item['user_to'];
            }
        }
        
        return $response;
    }
    
    /**
     * Checks if a user exist.
     * 
     * @param int $id_user Id of the user
     * @return boolean If the user exists
     */
    private function existUser($id_user)
    {
        if (empty($id_user)) { return false; }
        
        $sql = $this->db->prepare("SELECT COUNT(*) AS count FROM users WHERE id = ?");
        $sql->execute(array($id_user));
        
        return $sql && $sql->rowCount() > 0;
    }
}