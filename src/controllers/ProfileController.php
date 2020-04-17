<?php
namespace controllers;

use core\Controller;
use models\Users;

/**

*/
class ProfileController extends Controller
{
    //-----------------------------------------------------------------------
    //        Methods
    //-----------------------------------------------------------------------
    /*
     @Override
     */
    public function index ()
    {
        if (!Users::isLogged()) { header("Location: ".BASE_URL); }
        
        $users = new Users($_SESSION['sn_login']);
        
        $params = array(
            'title' => 'Home',
            'name' => $users->getName(),
            'data' => $users->getData(),
            'isOwner' => true
        );
        
        $this->loadTemplate("profile", $params);
    }
    
    public function open($id_user)
    {
        if (!Users::isLogged()) { header("Location: ".BASE_URL); }
        
        $users = new Users($_SESSION['sn_login']);
        
        if (empty($id_user)) {
            header("Location: ".BASE_URL."profile");
        }
        
        $params = array(
            'title' => 'Home',
            'name' => $users->getName($id_user),
            'data' => $users->getData($id_user),
            'isOwner' => $id_user == $_SESSION['sn_login']
        );
        
        $this->loadTemplate("profile", $params);
    }
    
    public function edit()
    {
        if (!Users::isLogged()) { header("Location: ".BASE_URL); }
        
        $users = new Users($_SESSION['sn_login']);
        $error = false;
        
        // Form was sent
        if (!empty($_POST['name'])) {
            if($users->edit($_POST['name'], $_POST['bio'], $_POST['genre'], $_POST['password'])) {
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
        
        $params['notice'] = "";
        
        $this->loadTemplate("profile_edit", $params);
    }
}
