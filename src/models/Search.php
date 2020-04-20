<?php
namespace models;

use core\Model;


/**
 * Responsible for managing search.
 */
class Search extends Model
{
    //-----------------------------------------------------------------------
    //        Attributes
    //-----------------------------------------------------------------------
    private $id_user;
    
    
    //-----------------------------------------------------------------------
    //        Constructor
    //-----------------------------------------------------------------------
    /**
     * Creates search manager.
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
     * Gets registered users with the specified name.
     * 
     * @param string $name Name of the user
     * @param number $page [optional] Current page
     * @param number $resultsPerPage [optional] Number of results displayed in a page
     * @return array Registered users with the specified name
     */
    public function searchUsers($name, $page=1, $resultsPerPage=10)
    {
        if (empty($name)) { return array(); }
        
        $response = array();
        
        $offset = ($page-1) * $resultsPerPage;
        $sql = $this->db->prepare("
            SELECT
                *,
                (select count(*) 
                from relationships 
                where 
                    relationships.user_from = $this->id_user and relationships.user_to = users.id and status = 1 OR
                    relationships.user_to = $this->id_user and relationships.user_from = users.id and status = 1) as isFriend
            FROM users
            WHERE
                name LIKE ? AND
                id != $this->id_user
            LIMIT $offset,$resultsPerPage
        ");
        
        $sql->execute(array($name."%"));
        
        if ($sql->rowCount() > 0) {
            $response = $sql->fetchAll();
        }
        
        return $response;
    }
    
    /**
     * Gets the total results obtained by a search term.
     *
     * @param string $name Term that will be searched (name of a user)
     * @return int Total of results
     */
    public function totalResults($name)
    {
        if (empty($name)) { return 0; }
        
        $sql = $this->db->prepare("
            SELECT COUNT(*) as count
            FROM users
            WHERE
                name LIKE ? AND
                id != $this->id_user
        ");
        
        $sql->execute(array("%".$name."%"));
        
        return $sql->fetch()['count'];
    }
}