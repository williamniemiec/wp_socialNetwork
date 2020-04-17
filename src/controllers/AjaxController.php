<?php
namespace controllers;

use core\Controller;
use models\Users;
use models\Relationships;
use models\Posts;
use models\Groups;


/**

 */
class AjaxController extends Controller
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
    {}
    
    public function add_friend()
    {
        if (empty($_POST['id'])) { return; }
        
        $relationships = new Relationships($_SESSION['sn_login']);
        
        $relationships->addFriend($_POST['id']);
    }
    
    public function remove_friend()
    {
        if (empty($_POST['id'])) { return; }
        
        $relationships = new Relationships($_SESSION['sn_login']);
        
        $relationships->removeFriend($_POST['id']);
    }
    
    public function accept_friend()
    {
        if (empty($_POST['id'])) { return; }
        
        $relationships = new Relationships($_SESSION['sn_login']);
        
        $relationships->acceptFriend($_POST['id']);
    }
    
    public function remove_post()
    {
        if (empty($_POST['id'])) { return; }
        
        $posts = new Posts($_SESSION['sn_login']);
        $posts->remove($_POST['id']);
    }
    
    public function like_post()
    {
        if (empty($_POST['id'])) { return; }
        
        $posts = new Posts($_SESSION['sn_login']);
        $posts->like($_POST['id']);
    }
    
    public function unlike_post()
    {
        if (empty($_POST['id'])) { return; }
        
        $posts = new Posts($_SESSION['sn_login']);
        $posts->unlike($_POST['id']);
    }
    
    public function add_comment_post()
    {
        if (empty($_POST['id_post']) || empty($_POST['text'])) { return; }
        
        $posts = new Posts($_SESSION['sn_login']);
        echo $posts->addComment($_POST['id_post'], $_POST['text']);
    }
    
    public function delete_comment_post()
    {
        if (empty($_POST['id_comment'])) { return; }
        
        $posts = new Posts($_SESSION['sn_login']);
        $posts->deleteComment($_POST['id_comment']);
    }
    
    public function create_group()
    {
        if (empty($_POST['title'])) { return; }
        
        $groups = new Groups($_SESSION['sn_login']);
        echo $groups->create($_POST['title']);
    }
    
    public function delete_group()
    {
        if (empty($_POST['id_group'])) { return; }
        
        $groups = new Groups($_SESSION['sn_login']);
        echo $groups->delete($_POST['id_group']);
    }
    
    public function exit_group()
    {
        if (empty($_POST['id_group'])) { return; }
        
        $groups = new Groups($_SESSION['sn_login']);
        echo $groups->exit($_POST['id_group']);
    }
    
    public function enter_group()
    {
        if (empty($_POST['id_group'])) { return; }
        
        $groups = new Groups($_SESSION['sn_login']);
        echo $groups->enter($_POST['id_group']);
    }
}