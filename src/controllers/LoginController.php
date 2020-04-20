<?php
namespace controllers;

use core\Controller;
use models\Users;


/**
 * Responsible for the behavior of the social network when the user is not logged.
 */
class LoginController extends Controller
{
    //-----------------------------------------------------------------------
    //        Methods
    //-----------------------------------------------------------------------
    /**
     * @Override
     */
    public function index ()
    {
        $params = array(
            'title' => 'Social Network'
        );
        
        $this->loadView("home_noLogged", $params);
    }
    
    /**
     * Loads login view.
     */
    public function login()
    {
        $params = array(
            'title' => 'Social Network - Login'
        );
        
        // Checks if the form was submitted
        if (!empty($_POST['email']) || !empty($_POST['password'])) {
            $users = new Users();
            $params['notice'] = $users->login($_POST['email'], $_POST['password']);
            header("Location: ".BASE_URL);
            exit;
        }
        
        $this->loadView("login", $params);
    }
    
    /**
     * Loads register view.
     */
    public function register()
    {
        $params = array(
            'title' => 'Social Network - Register'
        );
        
        // Checks if the form was submitted
        if (!empty($_POST['email']) || !empty($_POST['password'])) {
            $users = new Users();
            $params['notice'] = $users->register($_POST['name'], $_POST['genre'], $_POST['email'], $_POST['password']);
            
            if (!empty($_SESSION['sn_login'])) {
                header("Location: ".BASE_URL);
                exit;
            }
        }
        
        $this->loadView("register", $params);
    }
    
    /**
     * Performs user logout.
     */
    public function logout()
    {
        unset($_SESSION['sn_login']);
        header("Location: ".BASE_URL);
    }
}
