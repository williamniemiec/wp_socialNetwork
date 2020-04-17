<?php
namespace models;

use core\Model;


/**

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
    public function __construct($id_user)
    {
        parent::__construct();
        $this->id_user = $id_user;    
    }
    
    
    //-----------------------------------------------------------------------
    //        Methods
    //-----------------------------------------------------------------------
    public function getGroups($limit=10)
    {
        $response = array();
        
        //$sql = $this->db->query("SELECT * FROM groups WHERE id_user = $this->id ORDER BY RAND() LIMIT $limit");
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
    
    public function delete($id)
    {
        if (empty($id)) { return false; }
        if (!$this->isOwner($id)) { return false; }
        
        $sql = $this->db->prepare("DELETE FROM groups WHERE id = ?");
        $sql->execute(array($id));
        
        return $sql && $sql->rowCount() > 0;
    }
    
    public function exit($id) 
    {
        if (empty($id)) { return false; }
        
        $sql = $this->db->prepare("DELETE FROM groups_members WHERE id_group = ? AND id_user = $this->id_user");
        $sql->execute(array($id));
        
        return $sql && $sql->rowCount() > 0;
    }
    
    public function enter($id)
    {
        if (empty($id)) { return false; }
        
        $sql = $this->db->prepare("INSERT INTO groups_members (id_group,id_user) VALUES (?,$this->id_user)");
        $sql->execute(array($id));
        
        return $sql && $sql->rowCount() > 0;
    }
    
    public function isMember($id_group)
    {
        $sql = $this->db->prepare("SELECT COUNT(*) AS count FROM groups_members WHERE id_group = ? AND id_user = $this->id_user");
        $sql->execute(array($id_group));
        
        return $sql->fetch()['count'] > 0;
    }
    
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
    
    public function getMyAds()
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
    
    public function totalMembers($id_group)
    {
        if (empty($id_group)) { return 0; }
        
        $sql = $this->db->prepare("SELECT COUNT(*) AS count FROM groups WHERE id = ?");
        $sql->execute(array($id_group));
        
        return $sql->fetch()['count'];
    }
    
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
    
    private function isOwner($id)
    {
        if (empty($id)) { return false; }
        
        $sql = $this->db->prepare("SELECT COUNT(*) AS count FROM groups WHERE id = ? AND id_user = $this->id_user");
        $sql->execute(array($id));
        
        return $sql->fetch()['count'] > 0;
    }
}