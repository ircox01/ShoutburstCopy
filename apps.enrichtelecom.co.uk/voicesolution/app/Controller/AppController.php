<?php

App::uses('Controller', 'Controller');

class AppController extends Controller {
	
	public $components = array(
		'DebugKit.Toolbar',
		'Auth' => array(
			'authenticate' => array(
				'Form' => array( 
					'userModel' => 'User',
                    'fields' => array(
						'username' => 'username',
						'password' => 'password'
					)
				)
			),
			'authorize' => array('Controller') // Added this line
		),
		'Session'
	);
	
	public $helpers = array('Html', 'Form', 'Session');
	
	public function beforeFilter() {
		
		//Configure AuthComponent
		$this->Auth->allow('login','admin_login','record_save');
		//$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
		//$this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
		//$this->Auth->adminLoginRedirect = array('controller' => 'users', 'action' => 'index','admin' => true);//list of users
		//$this->Auth->loginRedirect = array('controller' => 'users', 'action' => 'index');//dashboard
		//$this->Auth->allow('index','view','add','edit','admin_add','admin_index');
	}
	
	public function isAuthorized($user) {
		return true;
		// Only admins can access admin functions
        /*if (isset($this->request->params['admin']) && $user['is_admin'] === '1') {
			return (bool)($user['is_admin'] === '1');
        } else {
			echo "sad";exit;
		}
		*/
		// Any registered user can access public functions
        if (empty($this->request->params['admin'])) {
            return false;
        }
		
        // Only admins can access admin functions
        if (isset($this->request->params['admin'])) {
            return (bool)($user['is_admin'] === '1');
			
        }

        // Default deny
        return false;
		
		//return true;//parent::isAuthorized($user);
	}

	
}
