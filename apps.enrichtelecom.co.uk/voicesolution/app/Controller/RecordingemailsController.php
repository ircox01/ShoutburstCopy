<?php
App::uses('AppController', 'Controller');
/**
 * RecordingEmails Controller
 *
 * @property RecordingEmail $RecordingEmail
 * @property PaginatorComponent $Paginator
 */
class RecordingEmailsController extends AppController {

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
		$userId = $this->Auth->user('id');
		App::uses('AppModel', 'Model');
		$this->loadModel('Recording');
		
		$this->Paginator->settings = array('conditions' => array("Recording.company_id = $userId"));
		$recordingEmails = $this->Paginator->paginate('RecordingEmail');
		
		
		$this->set(compact('recordingEmails'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->RecordingEmail->exists($id)) {
			throw new NotFoundException(__('Invalid recording email'));
		}
		$options = array('conditions' => array('RecordingEmail.' . $this->RecordingEmail->primaryKey => $id));
		$this->set('recordingEmail', $this->RecordingEmail->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->RecordingEmail->create();
			$emails = json_encode($this->request->data['RecordingEmail']['email_adds']);
			$this->request->data['RecordingEmail']['email_adds'] = $emails;
			$this->request->data['RecordingEmail']['status'] = 0;
			//var_dump($emails) . "\n";
			//var_dump(json_decode($emails));
			//var_dump($this->request->data);
			//exit;
			if ($this->RecordingEmail->save($this->request->data)) {
				$this->Session->setFlash(__('The recording email has been saved.'),'Flash/success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The recording email could not be saved. Please, try again.'));
			}
		}
		$options = array('conditions' => array('Recording.company_id' => $this->Auth->user('id')));
		$recordings = $this->RecordingEmail->Recording->find('all',$options);
		$this->set(compact('recordings'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->RecordingEmail->exists($id)) {
			throw new NotFoundException(__('Invalid recording email'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$emails = json_encode($this->request->data['RecordingEmail']['email_adds']);
			$this->request->data['RecordingEmail']['email_adds'] = $emails;
			if ($this->RecordingEmail->save($this->request->data)) {
				$this->Session->setFlash(__('The recording email has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The recording email could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('RecordingEmail.' . $this->RecordingEmail->primaryKey => $id));
			$this->request->data = $this->RecordingEmail->find('first', $options);
		}
		/*$recordings = $this->RecordingEmail->Recording->find('list');
		$this->set(compact('recordings'));*/
		$options = array('conditions' => array('Recording.company_id' => $this->Auth->user('id')));
		$recordings = $this->RecordingEmail->Recording->find('all',$options);
		$this->set(compact('recordings'));
		
		$options = array('conditions' => array('RecordingEmail.id' => $id));
		$recordingEmail = $this->RecordingEmail->find('first',$options);
		$this->set(compact('recordingEmail'));
		//var_dump(json_decode($recordingEmail['RecordingEmail']['email_adds']));exit;
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->RecordingEmail->id = $id;
		if (!$this->RecordingEmail->exists()) {
			throw new NotFoundException(__('Invalid recording email'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->RecordingEmail->delete()) {
			$this->Session->setFlash(__('The recording email has been deleted.'));
		} else {
			$this->Session->setFlash(__('The recording email could not be deleted. Please, try again.'));
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
		$this->RecordingEmail->recursive = 0;
		$this->set('recordingEmails', $this->Paginator->paginate());
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
		if (!$this->RecordingEmail->exists($id)) {
			throw new NotFoundException(__('Invalid recording email'));
		}
		$options = array('conditions' => array('RecordingEmail.' . $this->RecordingEmail->primaryKey => $id));
		$this->set('recordingEmail', $this->RecordingEmail->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		$this->layout = 'admin';
		if ($this->request->is('post')) {
			$this->RecordingEmail->create();
			if ($this->RecordingEmail->save($this->request->data)) {
				$this->Session->setFlash(__('The recording email has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The recording email could not be saved. Please, try again.'));
			}
		}
		$recordings = $this->RecordingEmail->Recording->find('list');
		$this->set(compact('recordings'));
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
		if (!$this->RecordingEmail->exists($id)) {
			throw new NotFoundException(__('Invalid recording email'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$emails = json_encode($this->request->data['RecordingEmail']['email_adds']);
			$this->request->data['RecordingEmail']['email_adds'] = $emails;
			if ($this->RecordingEmail->save($this->request->data)) {
				$this->Session->setFlash(__('The recording email has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The recording email could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('RecordingEmail.' . $this->RecordingEmail->primaryKey => $id));
			$this->request->data = $this->RecordingEmail->find('first', $options);
		}
		/*$recordings = $this->RecordingEmail->Recording->find('list');
		$this->set(compact('recordings'));*/
		$options = array('conditions' => array('Recording.company_id' => $this->Auth->user('id')));
		$recordings = $this->RecordingEmail->Recording->find('all',$options);
		$this->set(compact('recordings'));
		
		$options = array('conditions' => array('RecordingEmail.id' => $id));
		$recordingEmail = $this->RecordingEmail->find('first',$options);
		$this->set(compact('recordingEmail'));
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
		$this->RecordingEmail->id = $id;
		if (!$this->RecordingEmail->exists()) {
			throw new NotFoundException(__('Invalid recording email'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->RecordingEmail->delete()) {
			$this->Session->setFlash(__('The recording email has been deleted.'));
		} else {
			$this->Session->setFlash(__('The recording email could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
