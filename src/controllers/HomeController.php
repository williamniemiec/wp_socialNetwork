<?php
namespace controllers;

use core\Controller;
use models\Users;
use models\Relationships;
use models\Posts;
use models\Groups;


/**
 * Main controller. It will be responsible for site's main page behavior.
 */
class HomeController extends Controller 
{
    public function __construct()
    {
        if (!Users::isLogged()) {
            header("Location: ".BASE_URL."login");
        }
    }
    
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
        
	    // User posted something
        if (!empty($_POST['message']) || (!empty($_FILES['image']) && !empty($_FILES['image']['tmp_name']))) {
	        $photo = array();

	        if (!empty($_FILES['image']) && !empty($_FILES['image']['tmp_name'])) {
	            $photo = $_FILES['image'];
	        }
	        
	        $posts->add($_POST['message'], $photo);
	    }
	    
	    $page = empty($_GET['p']) ? 1 : $_GET['p'];
	    $resultsPerPage = 10;
	    $response = $posts->getPosts($page, $resultsPerPage);
	    
	    $totalResults = $posts->countPosts();
	    $totalPages = $totalResults < $resultsPerPage ? 1 : ceil($totalResults / $resultsPerPage);
	    
		$params = array(
			'title' => 'Home',
		    'name' => $users->getName(),
		    'friendSuggestions' => $relationships->getSuggestions(3),
		    'friendshipRequests' => $relationships->getFriendshipRequests(),
		    'friends' => $relationships->getFriends(),
		    'posts' => $response,
		    'groups' => $groups->getGroups(10),
		    'noMember' => !empty($_GET['noMember']) ? "You are not a member of this group" : "",
		    'totalPages' => $totalPages,
		    'page' => $page
		);


		$this->loadTemplate("home", $params);
	}
}
