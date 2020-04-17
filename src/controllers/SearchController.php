<?php
namespace controllers;

use core\Controller;
use models\Users;
use models\Relationships;
use models\Posts;
use models\Groups;
use models\Search;


/**

*/
class SearchController extends Controller
{
    //-----------------------------------------------------------------------
    //        Methods
    //-----------------------------------------------------------------------
    /*
      @Override
    */
    public function index ()
    {
        $users = new Users($_SESSION['sn_login']);
        $relationships = new Relationships($_SESSION['sn_login']);
        $posts = new Posts($_SESSION['sn_login']);
        $groups = new Groups($_SESSION['sn_login']);
        $search = new Search($_SESSION['sn_login']);
        
        if (empty($_GET['q'])) {
            header("Location: ".BASE_URL);
        }
        
        $page = empty($_GET['p']) ? 1 : $_GET['p'];
        $resultsPerPage = 2;
        $searchResult = $search->searchUsers($_GET['q'], $page, $resultsPerPage);
        
        //$totalResults = count($search);
        $totalResults = $search->totalResults($_GET['q']);
        $totalPages = $totalResults < $resultsPerPage ? 1 : ceil($totalResults / $resultsPerPage);
        
        $params = array(
            'title' => "Social network - Search",
            'name' => $users->getName(),
            'response' => $searchResult,
            'search' => str_replace("%20", " ", $_GET['q']),
            'totalPages' => $totalPages,
            'page' => $page,
            'currentURL' => BASE_URL."search/?q=".$_GET['q']
        );
        
        $this->loadTemplate("search", $params);
    }
}
