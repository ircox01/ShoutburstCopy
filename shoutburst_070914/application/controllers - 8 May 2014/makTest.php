<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class makTest extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$data['title'] = TITLE.' | Mak Test';
		$data['msg'] = '';
		$this->load->vars($data);
		
		if( ! isset($this->session->userdata['user_id']) )
			redirect('login/index');
	}
	

	public function index()
	{
		# Get all Campaigns
		$query = "SELECT * FROM campaigns";
		$data['campaigns'] = $this->db->query($query)->result();
		
		$this->load->template('makTest/index',$data);
	}
	
	public function jqueryTag()
	{
		# Get all Campaigns
		$query = "SELECT * FROM campaigns";
		$data['campaigns'] = $this->db->query($query)->result();
		
		$this->load->template('makTest/jqueryTag',$data);
	}
	
	
	function formSubmit(){
		echo "<pre>";print_r($_POST);
		exit();
	}
	
}