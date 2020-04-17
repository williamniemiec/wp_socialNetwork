<?php
namespace models;

use core\Model;


/**

*/
class Relationships extends Model
{
    //-----------------------------------------------------------------------
    //        Constructor
    //-----------------------------------------------------------------------
    public function __construct($id = "")
    {
        parent::__construct();
        $this->id = $id;
    }
    
    
    //-----------------------------------------------------------------------
    //        Methods
    //-----------------------------------------------------------------------
    public function getSuggestions($limit = 5)
    {
        $response = array();
        
        $sql = "
            SELECT
            	*
            FROM
                users
            WHERE
                users.id != $this->id AND
            	users.id NOT IN(select relationships.user_from from relationships WHERE relationships.user_from = $this->id OR relationships.user_to = $this->id) AND
                users.id NOT IN(select relationships.user_to from relationships WHERE relationships.user_from = $this->id OR relationships.user_to = $this->id)
            ORDER BY RAND()
        ";
        
        $sql .= " LIMIT ".intval($limit);
        
        $sql = $this->db->query($sql);
        
        if ($sql->rowCount() > 0) {
            $response = $sql->fetchAll();
        }
        
        return $response;
    }
    
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
                relationships.user_to = $this->id AND
                relationships.status = 0
        ";
        
        $sql = $this->db->query($sql);
        
        if ($sql && $sql->rowCount() > 0) {
            $response = $sql->fetchAll();
        }
        
        return $response;
    }
    
    public function addFriend($id_user)
    {
        if (!$this->existUser($id_user)) { return false; }
        
        $sql = $this->db->prepare("INSERT INTO relationships (user_from,user_to) VALUES ($this->id,?)");
        $sql->execute(array($id_user));
        
        
        return $sql && $sql->rowCount() > 0;
    }
    
    public function acceptFriend($id)
    {
        $sql = $this->db->prepare("UPDATE relationships SET status = 1 WHERE user_from = ? AND user_to = $this->id");
        $sql->execute(array($id));
        
        return $sql && $sql->rowCount() > 0;
    }
    
    public function getFriendsOld($limit = 10)
    {
        $response = array();
        
        $sql_from = ("
            SELECT
            	users.id,
            	users.name
            FROM
            	relationships
            LEFT JOIN
                users
            ON
                users.id = relationships.user_to
            WHERE
            	user_from = $this->id  AND
            	STATUS = 1
        ");
        
        $sql_to = ("
            SELECT
            	users.id,
            	users.name
            FROM
            	relationships
            LEFT JOIN
                users
            ON
                users.id = relationships.user_from
            WHERE
            	user_to = $this->id  AND
            	STATUS = 1
        ");
        
        $sql_from .= " LIMIT ".intval($limit);
        $sql_to .= " LIMIT ".intval($limit);
        
        $sql_from = $this->db->query($sql_from);
        $sql_to = $this->db->query($sql_to);
        
        // If both have results, merge them
        if ($sql_from && $sql_from->rowCount() > 0 && $sql_to && $sql_to->rowCount() > 0) {
            
            $response = $this->merge($sql_from->fetchAll(), $sql_to->fetchAll());
        }
        
        else if ($sql_from && $sql_from->rowCount() > 0) {
            $response = $sql_from->fetchAll();
        }
        
        else if ($sql_to && $sql_to->rowCount() > 0) {
            $response = $sql_to->fetchAll();
        }
        
        return $response;
    }
    
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
                id != $this->id AND
                id IN (".implode(",", $friendIds).")
        ";
        
        $sql = $this->db->query($sql);
        if ($sql->rowCount() > 0) {
            $response = $sql->fetchAll();
        }
        
        return $response;
    }
    
    public function removeFriend($id)
    {
        $sql = $this->db->prepare("
            DELETE FROM
                relationships
            WHERE
                (user_from = $this->id AND user_to = ?) OR
                (user_to = $this->id AND user_from = ?)
        ");
        
        $sql->execute(array($id, $id));
    }
    
    private function merge($array1, $array2)
    {
        $response = array();
        
        // Remove duplicates
        for ($i=0; $i<count($array1); $i++) {
            for ($j=0; $j<count($array2); $j++) {
                if ($array1[$i]['id'] == $array2[$j]['id']) {
                    unset($array2[$j]);
                    $array2 = array_values($array2);
                    $j--;
                }
            }
        }
        
        for ($i=0; $i<count($array2); $i++) {
            for ($j=0; $j<count($array1); $j++) {
                if ($array2[$i]['id'] == $array1[$j]['id']) {
                    unset($array1[$j]);
                    $array1 = array_values($array1);
                }
            }
        }
        
        // Merge them
        foreach ($array1 as $item) {
            $response[] = $item;
        }
        
        foreach ($array2 as $item) {
            $response[] = $item;
        }
        
        return $response;
    }
    
    public function getFriendsIds()
    {
        $response = array();
        
        $sql = "SELECT * FROM relationships WHERE (user_from = $this->id OR user_to = $this->id) AND status = 1";
        $sql = $this->db->query($sql);
        
        if ($sql->rowCount() > 0) {
            foreach ($sql->fetchAll() as $item) {
                $response[] = $item['user_from'];
                $response[] = $item['user_to'];
            }
        }
        
        return $response;
    }
    
    private function existUser($id)
    {
        if (empty($id)) { return false; }
        
        $sql = $this->db->prepare("SELECT COUNT(*) AS count FROM users WHERE id = ?");
        $sql->execute(array($id));
        
        return $sql && $sql->rowCount() > 0;
    }
}