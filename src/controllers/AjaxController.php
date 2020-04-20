<?php
namespace controllers;

use core\Controller;
use models\Users;
use models\Relationships;
use models\Posts;
use models\Groups;


/**
 * Responsible for managing ajax requests.
 */
class AjaxController extends Controller
{
    //-----------------------------------------------------------------------
    //        Constructor
    //-----------------------------------------------------------------------
    public function __construct()
    {
        if (!Users::isLogged()) {
            header("Location: ".BASE_URL."login");
        }
    }
    
    //-----------------------------------------------------------------------
    //        Methods
    //-----------------------------------------------------------------------
    /**
     * @Override
     */
    public function index ()
    {}
    
    /**
     * Called when a user requests a new friendship with another user.
     */
    public function add_friend()
    {
        if (empty($_POST['id'])) { return; }
        
        $relationships = new Relationships($_SESSION['sn_login']);
        
        $relationships->addFriend($_POST['id']);
    }
    
    /**
     * Called when a user requests a removal friendship with another user.
     */
    public function remove_friend()
    {
        if (empty($_POST['id'])) { return; }
        
        $relationships = new Relationships($_SESSION['sn_login']);
        
        $relationships->removeFriend($_POST['id']);
    }
    
    /**
     * Called when a user accepts a new friendship with another user.
     */
    public function accept_friend()
    {
        if (empty($_POST['id'])) { return; }
        
        $relationships = new Relationships($_SESSION['sn_login']);
        
        $relationships->acceptFriend($_POST['id']);
    }
    
    /**
     * Called when a user removes a post.
     */
    public function remove_post()
    {
        if (empty($_POST['id'])) { return; }
        
        $posts = new Posts($_SESSION['sn_login']);
        $posts->remove($_POST['id']);
    }
    
    /**
     * Called when a user likes a post.
     */
    public function like_post()
    {
        if (empty($_POST['id'])) { return; }
        
        $posts = new Posts($_SESSION['sn_login']);
        $posts->like($_POST['id']);
    }
    
    /**
     * Called when a user unlikes a post.
     */
    public function unlike_post()
    {
        if (empty($_POST['id'])) { return; }
        
        $posts = new Posts($_SESSION['sn_login']);
        $posts->unlike($_POST['id']);
    }
    
    /**
     * Called when a user comments a post.
     */
    public function add_comment_post()
    {
        if (empty($_POST['id_post']) || empty($_POST['text'])) { return; }
        
        $posts = new Posts($_SESSION['sn_login']);
        echo $posts->addComment($_POST['id_post'], $_POST['text']);
    }
    
    /**
     * Called when a user removes a comment from a post.
     */
    public function delete_comment_post()
    {
        if (empty($_POST['id_comment'])) { return; }
        
        $posts = new Posts($_SESSION['sn_login']);
        $posts->deleteComment($_POST['id_comment']);
    }
    
    /**
     * Called when a user creates a group.
     */
    public function create_group()
    {
        if (empty($_POST['title'])) { return; }
        
        $groups = new Groups($_SESSION['sn_login']);
        echo $groups->create($_POST['title']);
    }
    
    /**
     * Called when a user deletes a group.
     */
    public function delete_group()
    {
        if (empty($_POST['id_group'])) { return; }
        
        $groups = new Groups($_SESSION['sn_login']);
        echo $groups->delete($_POST['id_group']);
    }
    
    /**
     * Called when a user exits a group.
     */
    public function exit_group()
    {
        if (empty($_POST['id_group'])) { return; }
        
        $groups = new Groups($_SESSION['sn_login']);
        echo $groups->exit($_POST['id_group']);
    }
    
    /**
     * Called when a user joins a group.
     */
    public function join_group()
    {
        if (empty($_POST['id_group'])) { return; }
        
        $groups = new Groups($_SESSION['sn_login']);
        echo $groups->join($_POST['id_group']);
    }
}