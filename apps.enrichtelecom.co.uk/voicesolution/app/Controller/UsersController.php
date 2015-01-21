<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator',	'Auth',	'Session',
		'Cookie',);

	public function beforeFilter() {
		parent::beforeFilter();
		$this->_setupAuth();
	}
	
	protected function _setupAuth() {
		$this->Auth->allow('login','admin_login','record_save','logout','index');
		
		$this->Auth->authenticate = array(
			'Form' => array(
				'fields' => array(
					'username' => 'username',
					'password' => 'password'),
				'userModel' => $this->modelClass,
				'scope' => array(
					$this->modelClass . '.status' => 1
				)
			)
		);
	}
	
	public function login() {
		$this->layout = 'login';
		if ($this->request->is('post')) {
			$user = $this->request->data;
			
			if ($this->Auth->login()) {
				if ($this->Auth->user('is_admin') != '1') {					
					$this->Session->setFlash(sprintf(__d('users', '%s you have successfully logged in'), $this->Auth->user('username')),'Flash/success');
					$this->Auth->allow('index');
					$this->redirect(array('controller' => 'recordings', 'action' => 'index'));
				}else {					
					$this->Auth->logout();
					$this->Session->setFlash(__('You are not authorize this location!'),'Flash/error');					
				}
			} else {				 
				$this->Session->setFlash(__('Invalid username or password, try again'));
			}
		} else {
			if($this->Auth->login()) {
				$this->redirect(array('controller' => 'recordings', 'action' => 'index'));
			}
		}	
	}
	
	/*public function login() {
		
		$this->layout = 'main';
		if ($this->request->is('post')) {			
			if ($this->Auth->login()) {				
				$isAdmin = parent::isAuthorized($this->Auth->user());
				if(!$isAdmin) {
					$this->Session->setFlash(sprintf(__d('users', '%s you have successfully logged in'), $this->Auth->user('username')),'Flash/success');
					$this->Auth->allow('index');
					var_dump($this->Auth);exit;
					$this->redirect(array('controller' => 'recordings', 'action' => 'index'));					
				} else {
					$this->Auth->logout();
					$this->Session->setFlash(__('You are not authorize this location!'),'Flash/error');
				}
			} else {				 
				
				$this->Session->setFlash('Invalid username or password, try again','Flash/error');
			}
		}
	}*/
	
	public function logout()
	{$this->Auth->logout();
		$this->redirect($this->Auth->logout());
		
		$user = $this->Auth->user();
		$this->Session->destroy();
		$this->Cookie->destroy();
		$this->RememberMe->destroyCookie();
		$this->Session->setFlash(sprintf(__d('users', '%s you have successfully logged out'), $user[$this->{$this->modelClass}->displayField]));
		$this->redirect($this->Auth->logout());
	}
/**
 * index method
 *
 * @return void
 */
	public function index() {
		
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
		
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		$companies = $this->User->Company->find('list');
		$this->set(compact('companies'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
		$companies = $this->User->Company->find('list');
		$this->set(compact('companies'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('The user has been deleted.'));
		} else {
			$this->Session->setFlash(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	/**
	 * admin_login method
	 *
	 * @return void
	 */
	public function admin_login() {
		
		$this->layout = 'main';
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				
				if ($this->Auth->user('is_admin') == '1') {				
					$this->Session->setFlash(sprintf(__d('users', '%s you have successfully logged in'), $this->Auth->user('username')),'Flash/success');
					$this->redirect(array('controller' => 'companies', 'action' => 'index','admin' => true));
				} else {
					$this->Session->setFlash(__('You are not authorize this location!'),'Flash/error');
				}
				
			} else {				
				$this->Session->setFlash(__('Invalid username or password, try again'),'Flash/error');
			}
		}
	}
	
	/*
	*admin logout
	*/
	public function admin_logout()
	{
		$this->redirect($this->Auth->logout());
		
		$user = $this->Auth->user();
		$this->Session->destroy();
		$this->Cookie->destroy();
		$this->RememberMe->destroyCookie();
		$this->Session->setFlash(sprintf(__d('users', '%s you have successfully logged out'), $user[$this->{$this->modelClass}->displayField]));
		$this->redirect($this->Auth->logout());
	}
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->layout = 'admin';
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->layout = 'admin';
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add($companyId = null) {
		
		
		$this->layout = 'admin';
		if ($this->request->is('post')) {
			$this->User->create();			
			//create user first before adding contact details to it
			
			$this->request->data['User']['status'] = 1;
			$this->request->data['User']['call_login_pw'] = $this->request->data['User']['password'];
			if($companyId == "") {				
				$companyId = $this->request->data['User']['company_id'] = '1';
			}
			$this->request->data['User']['company_id'] = $companyId;
			$contacts = $this->request->data['User']['contact_number'];
			$this->request->data['User']['contact_number'] = '';
			if ($this->User->save($this->request->data)) {
				//after user created, add contact details assign to it
				$this->loadModel('ContactDetail');
				$i = 0;
				
				while($i < count($contacts)) {					
					$this->ContactDetail->create();
					$this->ContactDetail->set('number',$contacts[$i]);
					$this->ContactDetail->set('user_id',$this->User->getInsertId());
					$this->ContactDetail->save();
					$i++;
				}
				
				//add each data to contact_details
				$this->Session->setFlash(__('The user has been saved.'), 'Flash/success');		
				return $this->redirect(array('controller'=> 'companies','action' => 'index'));
			} else {				
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'Flash/error');
			}
		}
		$companies = $this->User->Company->find('list');
		$this->set(compact('companies'));
	}
	
/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->layout = 'admin';
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['User']['status'] = 1;
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
				$this->Session->setFlash(__d('users', 'The user could not be saved. Please, try again'),'Flash/error');
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
		$companies = $this->User->Company->find('list');
		$this->set(compact('companies'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->layout = 'admin';
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('The user has been deleted.'));
		} else {
			$this->Session->setFlash(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
