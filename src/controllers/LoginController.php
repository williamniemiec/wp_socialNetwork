<?php
namespace controllers;

use core\Controller;
use models\Users;

/**
 
 */
class LoginController extends Controller
{
    //-----------------------------------------------------------------------
    //        Methods
    //-----------------------------------------------------------------------
    /*
     @Override
     */
    public function index ()
    {
        $params = array(
            'title' => 'Login'
        );
        
        $this->loadView("login", $params);
    }
    
    public function login()
    {
        $params = array(
            'title' => 'Login'
        );
        
        // Form was sent
        if (!empty($_POST['email']) || !empty($_POST['password'])) {
            $users = new Users();
            $params['notice'] = $users->login($_POST['email'], $_POST['password']);
            header("Location: ".BASE_URL);
            exit;
        }
        
        $this->loadView("login_login", $params);
    }
    
    
    public function register()
    {
        $params = array(
            'title' => 'Login'
        );
        
        // Form was sent
        if (!empty($_POST['email']) || !empty($_POST['password'])) {
            $users = new Users();
            $params['notice'] = $users->register($_POST['name'], $_POST['genre'], $_POST['email'], $_POST['password']);
            
            if (!empty($_SESSION['sn_login'])) {
                header("Location: ".BASE_URL);
                exit;
            }
        }
        
        $this->loadView("login_register", $params);
    }
    
    public function logout()
    {
        unset($_SESSION['sn_login']);
        header("Location: ".BASE_URL);
    }
}
