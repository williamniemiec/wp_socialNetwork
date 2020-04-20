<?php
namespace controllers;

use core\Controller;
use models\Users;
use models\Search;


/**
 * Responsible for search view behavior.
 */
class SearchController extends Controller
{
    //-----------------------------------------------------------------------
    //        Methods
    //-----------------------------------------------------------------------
    /**
     * @Override
     */
    public function index ()
    {
        $users = new Users($_SESSION['sn_login']);
        $search = new Search($_SESSION['sn_login']);
        
        // Checks if a query was submitted.
        if (empty($_GET['q'])) {
            header("Location: ".BASE_URL);
        }
        
        // Gets current page
        $page = empty($_GET['p']) ? 1 : $_GET['p'];
        $resultsPerPage = 2;
        
        // Gets posts of this page
        $searchResult = $search->searchUsers($_GET['q'], $page, $resultsPerPage);
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
