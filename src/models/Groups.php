<?php
namespace models;

use core\Model;


/**
 * Responsible for groups management.
 */
class Groups extends Model
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
     * Register a new group in database.
     *
     * @param string $title Title of the group
     * @return int Id of the new group or -1 if an error occurred
     */
    public function create($title)
    {
        if (empty($title)) { return -1; }
        
        $response = -1;
        
        $sql = $this->db->prepare("INSERT INTO groups (id_user,title) VALUES ($this->id_user,?)");
        $sql->execute(array($title));
        
        if ($sql->rowCount() > 0) {
            $response = $this->db->lastInsertId();
            $sql = $this->db->query("INSERT INTO groups_members (id_group,id_user) VALUES ($response,$this->id_user)");
        }
        
        return $response;
    }
    
    /**
     * Deletes a group.
     *
     * @param int $id_group Id of the group
     * @return boolean If the group was successfully removed
     */
    public function delete($id_group)
    {
        if (empty($id_group))           { return false; }
        if (!$this->isOwner($id_group)) { return false; }
        
        $sql = $this->db->prepare("DELETE FROM groups WHERE id = ?");
        $sql->execute(array($id_group));
        
        return $sql && $sql->rowCount() > 0;
    }
    
    /**
     * Removes current user from a group.
     *
     * @param int $id_group Id of the group
     * @return boolean If the user was successfully removed from the group
     */
    public function exit($id_group)
    {
        if (empty($id_group)) { return false; }
        
        $sql = $this->db->prepare("DELETE FROM groups_members WHERE id_group = ? AND id_user = $this->id_user");
        $sql->execute(array($id_group));
        
        return $sql && $sql->rowCount() > 0;
    }
    
    /**
     * Adds current user in a group.
     *
     * @param int $id_group Id of the group
     * @return boolean If the user was successfully added in the group
     */
    public function join($id_group)
    {
        if (empty($id_group)) { return false; }
        
        $sql = $this->db->prepare("INSERT INTO groups_members (id_group,id_user) VALUES (?,$this->id_user)");
        $sql->execute(array($id_group));
        
        return $sql && $sql->rowCount() > 0;
    }
    
    /**
     * Returns all registered groups (respecting the maximum value).
     * 
     * @param number $limit [optional] Maximum number of groups that will be returned.
     * @return array All registered groups
     */
    public function getGroups($limit=10)
    {
        $response = array();
        
        $sql = $this->db->query("SELECT * FROM groups ORDER BY RAND() LIMIT $limit");
        
        if ($sql->rowCount() > 0) {
            $groups = $sql->fetchAll();
            for ($i=0; $i<count($groups); $i++) {
                $response[$i] = $groups[$i];
                $response[$i]['isOwner'] = ($groups[$i]['id_user'] == $this->id_user) ? 1 : 0;
                
                $members = $this->getMembersId($groups[$i]['id']);
                $response[$i]['isMember'] = in_array($this->id_user, $members) != false;
            }
        }
        
        return $response;
    }
    
    /**
     * Gets all members of a group.
     * 
     * @param int $id_group Id of the group
     * @return array All members of the group
     */
    public function getMembers($id_group)
    {
        if (empty($id_group)) { return array(); }
        
        $response = array();
        
        $sql = $this->db->prepare("
            SELECT
                *,
                (select users.name from users where users.id = groups_members.id_user) as name,
                (select users.id from users where users.id = groups_members.id_user) as id_member
            FROM groups_members
            WHERE id_group = ?
        ");
        
        $sql->execute(array($id_group));
        
        if ($sql->rowCount() > 0) {
            $response = $sql->fetchAll();
        }
        
        return $response;
    }
    
    /**
     * Gets all ids of the members of a group.
     * 
     * @param int $id_group Id of the group
     * @return array Ids of the members of the group
     */
    public function getMembersId($id_group)
    {
        if (empty($id_group)) { return array(); }
        
        $response = array();
        
        $sql = $this->db->prepare("
            SELECT * FROM groups_members WHERE id_group = ?");
        $sql->execute(array($id_group));
        
        if ($sql->rowCount() > 0) {
            $members = $sql->fetchAll();
            
            foreach ($members as $member) {
                $response[] = $member['id_user'];
            }
        }
        
        return $response;
    }
    
    /**
     * Gets all names of the members of a group.
     *
     * @param int $id_group Id of the group
     * @return array Names of the members of the group
     */
    public function getMembersName($id_group)
    {
        if (empty($id_group)) { return array(); }
        
        $response = array();
        
        $sql = $this->db->prepare("
            SELECT
                *,
                (select users.name from users where users.id = groups_members.id_user) as name
            FROM groups_members
            WHERE id_group = ?
        ");
        
        $sql->execute(array($id_group));
        
        if ($sql->rowCount() > 0) {
            $members = $sql->fetchAll();
            
            foreach ($members as $member) {
                $response[] = $member['name'];
            }
        }
        
        return $response;
    }
    
    /**
     * Gets the name of a group.
     * 
     * @param int $id_group Id of the group
     * @return string Name of the group
     */
    public function getName($id_group)
    {
        $response = "";
        
        $sql = $this->db->prepare("SELECT title FROM groups WHERE id = ?");
        $sql->execute(array($id_group));
        
        if ($sql && $sql->rowCount() > 0) {
            $response = $sql->fetch()['title'];    
        }
        
        return $response;
    }
    
    /**
     * Gets the id of of all groups created by the current user.
     * 
     * @return array Ids of all groups created by the current user. 
     */
    public function getMyGroups()
    {
        $response = array();
        
        $sql = $this->db->query("SELECT id_group FROM groups_members WHERE id_user = $this->id_user");
        
        if ($sql && $sql->rowCount() > 0) {
            foreach ($sql->fetchAll() as $group) {
                $response[] = $group['id_group'];
            }
        }
        
        return $response;
    }
    
    /**
     * Gets number of members of a group.
     * 
     * @param int $id_group Id of the group
     * @return int Number of members
     */
    public function totalMembers($id_group)
    {
        if (empty($id_group)) { return 0; }
        
        $sql = $this->db->prepare("SELECT COUNT(*) AS count FROM groups WHERE id = ?");
        $sql->execute(array($id_group));
        
        return $sql->fetch()['count'];
    }
    
    /**
     * Checks if current user is member of a group.
     *
     * @param int $id_group Id of the group
     * @return boolean If current user is a member of the group.
     */
    public function isMember($id_group)
    {
        $sql = $this->db->prepare("SELECT COUNT(*) AS count FROM groups_members WHERE id_group = ? AND id_user = $this->id_user");
        $sql->execute(array($id_group));
        
        return $sql->fetch()['count'] > 0;
    }
    
    /**
     * Checks if a group was created by the current user.
     * 
     * @param int $id_group Id of the group
     * @return boolean If the group was created by the current user
     */
    private function isOwner($id_group)
    {
        if (empty($id_group)) { return false; }
        
        $sql = $this->db->prepare("SELECT COUNT(*) AS count FROM groups WHERE id = ? AND id_user = $this->id_user");
        $sql->execute(array($id_group));
        
        return $sql->fetch()['count'] > 0;
    }
}