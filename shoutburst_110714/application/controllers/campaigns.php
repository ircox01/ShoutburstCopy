<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Campaigns extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$data['title'] = TITLE.' | Campaigns';
		$this->load->vars($data);
		$this->load->model('Campaigns_model');
		
		if( ! isset($this->session->userdata['user_id']) )
			redirect('login/index');
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	index
	 */
	public function index()
	{
		$comp_id = $this->session->userdata['comp_id'];
		
		# Get all Campaigns
		$data['campaigns'] = $this->Campaigns_model->get_campaigns($comp_id);
		$this->load->template('campaigns/index', $data);
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	add
	 */
	public function add($ajaxRequested = null)
	{
		# get session variable
		$user_id = $this->session->userdata['user_id'];
		$comp_id = $this->session->userdata['comp_id'];
		
		# save posted varaibles in array variable
		$post = $this->input->post();
		#var_debug($post);
		
		if (isset($post) && !empty($post))
		{
			$camp_name = $post['camp_name'];
			$routing_plan = $post['routingPlan'];
			# if already exists
			$this->db->where('camp_name', $camp_name);
			$return = $this->db->get('campaigns')->row_array();
			/*$this->db->from('campaigns c');
			$this->db->join('company_campaings cc', 'cc.camp_id = c.camp_id');
			$this->db->where('c.camp_name', $camp_name);
			$this->db->where('cc.comp_id', $comp_id);
			$return = $this->db->get('campaigns')->row_array();*/

			if ( empty($return) )
			{
				# insert into campaigns
				$this->db->insert('campaigns', array('camp_name'=>$camp_name,'routing_plan'=>$routing_plan, 'created'=>date('Y-m-d')));
				$camp_id = $this->db->insert_id();

				# insert into company_campaings
				$this->db->insert('company_campaings', array('comp_id'=>$comp_id, 'camp_id'=>$camp_id));
				
				//if campaign is added from ajax request
				if($ajaxRequested){
					echo $camp_id;
					exit();
				}else{
					$this->session->set_flashdata('message', 'Add successfully.');
				}
				
			} else {
				
				//if campaign is added from ajax request
				if($ajaxRequested){
					echo false;
					exit();
				}else{
					$this->session->set_flashdata('message', 'Already exists.');
				}
			}
			redirect('campaigns/add');
		}		
		$this->load->template('campaigns/add');
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	edit
	 */
	public function edit()
	{
		$camp_id = $this->uri->segment(3);
		
		# save posted varaibles in array variable
		$post = $this->input->post();
		#var_debug($post);
		
		if (isset($post) && !empty($post))
		{
			$camp_name = $post['camp_name'];
			
			# if already exists
			$this->db->where('camp_name', $camp_name);
			$this->db->where('camp_id !=', $camp_id);
			$return = $this->db->get('campaigns')->row_array();
			
			if ( empty($return) )
			{
				$update_camp['camp_name'] = $camp_name;
				$update_camp['last_change'] = date('Y-m-d');
				$this->db->where('camp_id', $camp_id);
				$this->db->update('campaigns', $update_camp);
				$this->session->set_flashdata('message', 'Edit successfully.');
			} else {
				$this->session->set_flashdata('message', 'Already exists.');
			}
			redirect('campaigns/edit/'.$camp_id);
		}
		
		if ( is_numeric($camp_id) ) {
			
			$campaign = $this->db->get_where('campaigns', array('camp_id'=>$camp_id))->result();
		
			if (!empty($campaign))
			{
				$data['campaign'] = $campaign;				
			} else {
				redirect('campaigns');
			}
			
			$this->load->template('campaigns/edit', $data);
		
		} else {
			redirect('campaigns');
		}
	}
}