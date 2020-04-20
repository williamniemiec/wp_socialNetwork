<?php
namespace controllers;

use core\Controller;
use models\Users;
use models\Posts;
use models\Groups;


/**
 * Responsible for groups view behavior.
 */
class GroupsController extends Controller
{
    //-----------------------------------------------------------------------
    //        Methods
    //-----------------------------------------------------------------------
    /**
     * @Override
     */
    public function index ()
    {}
    
    /**
     * Displays a group.
     * 
     * @param int $id_group Id of the group to be displayed
     */
    public function open($id_group)
    {
        $users = new Users($_SESSION['sn_login']);
        $posts = new Posts($_SESSION['sn_login']);
        $groups = new Groups($_SESSION['sn_login']);
        
        // Checks if user is a member of the group
        if (!$groups->isMember($id_group)) {
            header("Location: ".BASE_URL."?noMember=true");
            exit;
        }
        
        // Checks if a post was made
        if (!empty($_POST['message']) || (!empty($_FILES['image']) && !empty($_FILES['image']['tmp_name']))) {
            $photo = array();
            
            if (!empty($_FILES['image']) && !empty($_FILES['image']['tmp_name'])) {
                $photo = $_FILES['image'];
            }
            
            $posts->add($_POST['message'], $photo, $id_group);
        }
        
        // Gets current page
        $page = empty($_GET['p']) ? 1 : $_GET['p'];
        $resultsPerPage = 10;
        
        // Gets posts of this page
        $response = $posts->getPosts($page,$resultsPerPage,$id_group);
        $totalResults = $posts->countPosts();
        $totalPages = $totalResults < $resultsPerPage ? 1 : ceil($totalResults / $resultsPerPage);
        
        $params = array(
            'title' => 'Social Network - Group - '.$groups->getName($id_group),
            'name' => $users->getName(),
            'groupName' => $groups->getName($id_group),
            'totalMembers' => $groups->totalMembers($id_group),
            'members' => $groups->getMembers($id_group),
            'posts' => $response,
            'page' => $page,
            'totalPages' => $totalPages,
            'currentURL' => BASE_URL."groups/open/".$id_group
        );
        
        $this->loadTemplate("group", $params);
    }
}
