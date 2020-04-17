<?php
namespace controllers;

use \core\Controller;
use models\Users;


/**
 * It will be responsible for site's page not found behavior.
 */
class NotFoundController extends Controller 
{
    //-----------------------------------------------------------------------
    //        Methods
    //-----------------------------------------------------------------------
    /*
      @Override
    */
	public function index()
	{
        if (!Users::isLogged()) {
            $this->loadView('404_noLogged', $params);
        } else {
            $users = new Users($_SESSION['sn_login']);
            
            $params = array(
                'name' => $users->getName()
            );
            
            $this->loadTemplate('404', $params);
        }
	    
        
        
	}
}
