<?php
namespace controllers;

use core\Controller;
use models\Users;


/**
 * It will be responsible for site's page not found behavior.
 */
class NotFoundController extends Controller 
{
    //-----------------------------------------------------------------------
    //        Methods
    //-----------------------------------------------------------------------
    /**
     * @Override
     */
	public function index()
	{
	    $params = array(
	        'title' => "Social Network - 404",
	    );
	    
        if (!Users::isLogged()) {
            $this->loadView('404_noLogged');
            exit;
        }
        
        $users = new Users($_SESSION['sn_login']);
        $params['name'] = $users->getName();
        
        $this->loadTemplate('404', $params);
	}
}
