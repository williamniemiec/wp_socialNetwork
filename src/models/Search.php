<?php
namespace models;

use core\Model;


/**

*/
class Search extends Model
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
    public function totalResults($name)
    {
        if (empty($name)) { return 0; }
        
        $sql = $this->db->prepare("
            SELECT COUNT(*) as count
            FROM users
            WHERE
                name LIKE ? AND
                id != $this->id
        ");
        
        $sql->execute(array("%".$name."%"));
        
        return $sql->fetch()['count'];
    }
    
    public function searchUsers($name, $page=1, $usersPerPage=10)
    {
        if (empty($name)) { return array(); }
        
        $response = array();
        
        $offset = ($page-1) * $usersPerPage;
        $sql = $this->db->prepare("
            SELECT
                *,
                (select count(*) 
                from relationships 
                where 
                    relationships.user_from = $this->id and relationships.user_to = users.id and status = 1 OR
                    relationships.user_to = $this->id and relationships.user_from = users.id and status = 1) as isFriend
            FROM users
            WHERE
                name LIKE ? AND
                id != $this->id
            LIMIT $offset,$usersPerPage
        ");
        
        $sql->execute(array($name."%"));
        
        if ($sql->rowCount() > 0) {
            $response = $sql->fetchAll();
        }
        
        return $response;
    }
}