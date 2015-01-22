<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alerts extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$data['title'] = TITLE.' | Alerts';
		$this->load->vars($data);
		$this->load->model('Alert_model', 'alert_model');
		
		if( ! isset($this->session->userdata['user_id']) )
			redirect('login/index');
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	index
	 *
	 */
	public function index()
	{	
		
		# get session variable
		$comp_id = $this->session->userdata['comp_id'];
		$data['data'] = $this->alert_model->getAlerts($comp_id);
		
		$this->load->template('alerts/index' , $data);
	}
	
	public function add()
	{	
		if(!empty($_POST)|| !empty($_POST['alert_name']))
		{
			$post = $_POST;
			$comp_id = $this->session->userdata['comp_id'];
			$result = $this->alert_model->addAlert( $post , $this->session->userdata['user_id'], $comp_id );			
			$this->session->set_flashdata('message', '<div id="message" class="update">Alert added successfully.</div>');
			redirect('alerts');
		}
		$this->load->view('alerts/add');
	}
	
	public function edit()
	{
		$alert_id = $this->uri->segment(3);
		if(!empty($_POST)|| !empty($_POST['alert_name']))
		{
			$post = $_POST;	
		
			$result = $this->alert_model->updateAlert($post , $this->session->userdata['user_id']);			
			$this->session->set_flashdata('message', '<div id="message" class="update">Alert updated successfully.</div>');
			redirect('alerts');
		}
		$data['alert'] = $this->alert_model->getAlertDetails($alert_id);
		//$filters = explode(" ", $data['alert'][0]->filter_conditions);
	
	//	$filters = explode(" ", $filterArray);
		//$data['alert'][0]->score_type = $filters[0]; 
		//$data['alert'][0]->operator = $filters[1];
		//$data['alert'][0]->score = $filters[2];
		//$data['alert'][0]->period = $filters[4];
		$this->load->view('alerts/edit' , $data);
	}
	
	public function delete()
	{
		$alert_id = $this->uri->segment(3);
		$action = $this->uri->segment(4);
				
		if ( is_numeric($alert_id) )
		{
		
			$statusUpdate	=	0;
			$msg			= 'Alert Disable';
			//if status is enable
			if($action=='enable')
			{
				$statusUpdate = 1;
				$msg			= 'Alert Enable';
			}
		
			$this->alert_model->delete($alert_id);
			#$this->session->set_flashdata('message', "$msg successfully.");
			$this->session->set_flashdata('message', '<div id="message" class="update">Alert deleted successfully.</div>');
			
		}
		else
		{
			$this->session->set_flashdata('message', '<div id="message" class="error">Error while deleting.</div>');
		}	
	}
}