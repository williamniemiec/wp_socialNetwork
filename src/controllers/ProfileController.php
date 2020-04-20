<?php
namespace controllers;

use core\Controller;
use models\Users;


/**
 * Responsible for profile view behavior.
 */
class ProfileController extends Controller
{
    //-----------------------------------------------------------------------
    //        Methods
    //-----------------------------------------------------------------------
    /**
     * @Override
     */
    public function index ()
    {
        if (!Users::isLogged()) { 
            header("Location: ".BASE_URL);
            exit;
        }
        
        $users = new Users($_SESSION['sn_login']);
        
        $params = array(
            'title' => 'Social Network - Profile',
            'name' => $users->getName(),
            'data' => $users->getData(),
            'isOwner' => true
        );
        
        $this->loadTemplate("profile", $params);
    }
    
    /**
     * Displays an user profile.
     *
     * @param int $id_user Id of the user to be displayed
     */
    public function open($id_user)
    {
        if (empty($id_user)) {
            header("Location: ".BASE_URL."profile");
            exit;
        }
        
        if (!Users::isLogged()) { 
            header("Location: ".BASE_URL);
            exit;
        }
        
        $users = new Users($_SESSION['sn_login']);
        
        $params = array(
            'title' => 'Home',
            'name' => $users->getName($id_user),
            'data' => $users->getData($id_user),
            'isOwner' => $id_user == $_SESSION['sn_login']
        );
        
        $this->loadTemplate("profile", $params);
    }
    
    /**
     * Edits current user profile.
     */
    public function edit()
    {
        if (!Users::isLogged()) { 
            header("Location: ".BASE_URL); 
            exit; 
        }
        
        $users = new Users($_SESSION['sn_login']);
        $error = false;
        
        // Checks if the form was sent
        if (!empty($_POST['name'])) {
            if ($users->edit($_POST['name'], $_POST['bio'], $_POST['genre'], $_POST['password'])) {
                header("Location: ".BASE_URL."profile");
                exit;
            }
            
            $error = true;
        }
        
        $params = array(
            'title' => 'Home',
            'name' => $users->getName(),
            'data' => $users->getData(),
            'error' => $error
        );
        
        $this->loadTemplate("profile_edit", $params);
    }
}
