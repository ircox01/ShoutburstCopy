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
		//var_dump($this->Auth)
		//parent::beforeFilter();
		//$this->Auth->allow('index','view','add','edit','admin_add','admin_index'); // Letting users register themselves
		$this->_setupAuth();
	}
	
	protected function _setupAuth() {
		//$this->Auth->allow('add', 'logout', 'view', 'login');
		
		$this->Auth->authenticate = array(
			'Form' => array(
				'fields' => array(
					'username' => 'username',
					'password' => 'password'),
				'userModel' => $this->modelClass,
				'scope' => array(
					$this->modelClass . '.status' => 1,
					//$this->modelClass . '.email_verified' => 1
					)
				));

		//$this->Auth->loginRedirect = array('plugin' =>'dashboard', 'controller' => 'dashboards', 'action' => 'index');
		//$this->Auth->logoutRedirect = array('plugin' => Inflector::underscore($this->plugin), 'controller' => 'users', 'action' => 'login');
		//$this->Auth->loginAction = array('admin' => false, 'plugin' => Inflector::underscore($this->plugin), 'controller' => 'users', 'action' => 'login');
	}
	
	public function login() {
		$this->layout = 'login';
		if ($this->request->is('post')) {
			$user = $this->request->data;
			
			if ($this->Auth->login()) {
				$this->Session->setFlash(sprintf(__d('users', '%s you have successfully logged in'), $this->Auth->user('username')),'Flash/success');
				$this->Auth->allow('add');
				$this->redirect(array('controller' => 'recordingemails', 'action' => 'add'));
			} else {
				 echo $this->Auth->authError;exit;
				$this->Session->setFlash(__('Invalid username or password, try again'));
			}
		}
	}
	
	public function logout()
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
		
		$this->layout = 'login';
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				
				$this->Session->setFlash(sprintf(__d('users', '%s you have successfully logged in'), $this->Auth->user('first_name')),'Flash/success');
				$this->redirect(array('controller' => 'users', 'action' => 'index','admin' => true));
			} else {
				$this->Session->setFlash(__('Invalid username or password, try again'));
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
	public function admin_add() {
		$this->layout = 'admin';
		if ($this->request->is('post')) {
			$this->User->create();
			$this->request->data['User']['status'] = 1;
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
