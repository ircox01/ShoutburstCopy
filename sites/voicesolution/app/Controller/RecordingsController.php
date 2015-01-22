<?php
App::uses('AppController', 'Controller');
/**
 * Recordings Controller
 *
 * @property Recording $Recording
 * @property PaginatorComponent $Paginator
 */
class RecordingsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		/*$this->Recording->recursive = 0;
		$this->set('recordings', $this->Paginator->paginate());*/
		
		$this->Paginator->settings = array(
			'conditions' => array('Recording.company_id ' => $this->Auth->user('id')),
			'limit' => 10
		);
		$recordings = $this->Paginator->paginate('Recording');
		$this->set(compact('recordings'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Recording->exists($id)) {
			throw new NotFoundException(__('Invalid recording'));
		}
		$options = array('conditions' => array('Recording.' . $this->Recording->primaryKey => $id));
		$this->set('recording', $this->Recording->find('first', $options));
	}
	
	public function save() {
		
		$company = $this->Recording->Company->findByName($this->params['url']['company']);
		$companyId = $company['Company']['id'];
		
		$this->Recording->create();
		$this->Recording->set('cli',$this->params['url']['cli']);
		$this->Recording->set('name',$this->params['url']['name']);
		$this->Recording->set('routing_plan',$this->params['url']['plan']);
		$this->Recording->set('company_id',$companyId);
		$this->Recording->set('status',1);
		$this->Recording->save();
		
		exit;
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Recording->create();
			if ($this->Recording->save($this->request->data)) {
				$this->Session->setFlash(__('The recording has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The recording could not be saved. Please, try again.'));
			}
		}
		$companies = $this->Recording->Company->find('list');
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
		if (!$this->Recording->exists($id)) {
			throw new NotFoundException(__('Invalid recording'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Recording->save($this->request->data)) {
				$this->Session->setFlash(__('The recording has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The recording could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Recording.' . $this->Recording->primaryKey => $id));
			$this->request->data = $this->Recording->find('first', $options);
		}
		$companies = $this->Recording->Company->find('list');
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
		$this->Recording->id = $id;
		if (!$this->Recording->exists()) {
			throw new NotFoundException(__('Invalid recording'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Recording->delete()) {
			$this->Session->setFlash(__('The recording has been deleted.'));
		} else {
			$this->Session->setFlash(__('The recording could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Recording->recursive = 0;
		$this->set('recordings', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Recording->exists($id)) {
			throw new NotFoundException(__('Invalid recording'));
		}
		$options = array('conditions' => array('Recording.' . $this->Recording->primaryKey => $id));
		$this->set('recording', $this->Recording->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Recording->create();
			if ($this->Recording->save($this->request->data)) {
				$this->Session->setFlash(__('The recording has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The recording could not be saved. Please, try again.'));
			}
		}
		$companies = $this->Recording->Company->find('list');
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
		if (!$this->Recording->exists($id)) {
			throw new NotFoundException(__('Invalid recording'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Recording->save($this->request->data)) {
				$this->Session->setFlash(__('The recording has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The recording could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Recording.' . $this->Recording->primaryKey => $id));
			$this->request->data = $this->Recording->find('first', $options);
		}
		$companies = $this->Recording->Company->find('list');
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
		$this->Recording->id = $id;
		if (!$this->Recording->exists()) {
			throw new NotFoundException(__('Invalid recording'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Recording->delete()) {
			$this->Session->setFlash(__('The recording has been deleted.'));
		} else {
			$this->Session->setFlash(__('The recording could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
