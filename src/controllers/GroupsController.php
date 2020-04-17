<?php
namespace controllers;

use core\Controller;
use models\Users;
use models\Relationships;
use models\Posts;
use models\Groups;
/**

*/
class GroupsController extends Controller
{
    //-----------------------------------------------------------------------
    //        Methods
    //-----------------------------------------------------------------------
    /*
      @Override
    */
    public function index ()
    {}
    
    public function open($group_id)
    {
        $users = new Users($_SESSION['sn_login']);
        $relationships = new Relationships($_SESSION['sn_login']);
        $posts = new Posts($_SESSION['sn_login']);
        $groups = new Groups($_SESSION['sn_login']);
        
        // Checks if user is a member of the group
        if (!$groups->isMember($group_id)) {
            header("Location: ".BASE_URL."?noMember=true");
        }
        
        
        if (!empty($_POST['message']) || (!empty($_FILES['image']) && !empty($_FILES['image']['tmp_name']))) {
            $photo = array();
            
            if (!empty($_FILES['image']) && !empty($_FILES['image']['tmp_name'])) {
                $photo = $_FILES['image'];
            }
            
            $posts->add($_POST['message'], $photo, $group_id);
        }
        
        $page = empty($_GET['p']) ? 1 : $_GET['p'];
        $resultsPerPage = 10;
        $response = $posts->getPosts($page,$resultsPerPage,$group_id);
        
        $totalResults = $posts->countPosts();
        $totalPages = $totalResults < $resultsPerPage ? 1 : ceil($totalResults / $resultsPerPage);
        
        $params = array(
            'title' => 'Group - '.$groups->getName($group_id),
            'name' => $users->getName(),
            'groupName' => $groups->getName($group_id),
            'friendSuggestions' => $relationships->getSuggestions(3),
            'friendshipRequests' => $relationships->getFriendshipRequests(),
            'friends' => $relationships->getFriends(),
            'posts' => $response,
            'groups' => $groups->getGroups(15),
            'totalMembers' => $groups->totalMembers($group_id),
            'members' => $groups->getMembers($group_id),
            'totalPages' => $totalPages,
            'page' => $page,
            'currentURL' => BASE_URL."groups/open/".$group_id
        );
        
        
        $this->loadTemplate("group", $params);
    }
}
