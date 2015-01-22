<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alerts extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$data['title'] = TITLE.' | Alerts';
		$this->load->vars($data);
		$this->load->model('users_model', 'usres');
		
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
		$this->load->template('alerts/index');
	}	
}