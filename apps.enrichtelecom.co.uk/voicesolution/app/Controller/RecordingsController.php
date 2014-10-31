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
		$this->Recording->recursive = 0;
		$this->set('recordings', $this->Paginator->paginate());
		/*echo $this->Auth->user('id');exit;
		$this->Paginator->settings = array(
			'conditions' => array('Recording.company_id ' => $this->Auth->user('id')),
			'limit' => 10
		);
		$recordings = $this->Paginator->paginate('Recording');
		$this->set(compact('recordings'));*/
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
	
	protected function getUserByCompany($companyId)
	{
		Controller::loadModel('Users');
		$user = $this->User->findByCompanyId($companyId);
		
		return $user;		
	}
	
	public function record_save() {
		
		//http send phone number, CLI, date/time, plan name
		//variables need :phone,date_time,plan,cli
		$this->loadModel('ContactDetail');
		$this->loadModel('Company');
		$this->loadModel('ScrapedRecording');
		
		//determined company_id when matched phone number in on database
		$contactDetails = $this->ContactDetail->findByNumber($this->params['url']['phone']);
		
		if($contactDetails) {
			$companyId = $contactDetails['User']['company_id'];
			
			//determine filename using date/time
			$scrapedRecording = $this->ScrapedRecording->findByRecordTime($this->params['url']['record_time']);
			//var_dump($scrapedRecording);exit;
			if($scrapedRecording) {
				$this->Recording->create();		
				$this->Recording->set('name',$scrapedRecording['ScrapedRecording']['name']);
				$this->Recording->set('routing_plan',$this->params['url']['plan']);
				$this->Recording->set('cli',$this->params['url']['cli']);
				$this->Recording->set('company_id',$companyId);
				$this->Recording->set('record_time',$this->params['url']['record_time']);
				$this->Recording->set('status',1);
				$this->Recording->save();
			}
		} 
		
		/*if($contactDetails['ContactDetail']['model'] == 1) {//company, 2user
			
			//get company
			$company = $this->Company->findById($contactDetails['ContactDetail']['id']);
			
			//determine filename using date/time
			$scrapedRecording = $this->ScrapedRecording->findByRecordTime($this->params['url']['date_time']);
			if($scrapedRecording) {
				$this->Recording->create();		
				$this->Recording->set('name',$scrapedRecording['ScrapedRecording']['name']);
				$this->Recording->set('routing_plan',$this->params['url']['plan']);
				$this->Recording->set('cli',$this->params['url']['cli']);
				$this->Recording->set('company_id',$company['Company']['id']);
				$this->Recording->set('record_time',$this->params['url']['date_time']);
				$this->Recording->set('status',1);
				$this->Recording->save();
			}
		} else {
			//user			
		}*/
		
		
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
		$this->layout = 'admin';
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
		$this->layout = 'admin';
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
		$this->layout = 'admin';
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
		$this->layout = 'admin';
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
		$this->layout = 'admin';
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
