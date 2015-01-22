<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('date');
	}
	
	public function __destruct()
	{
		//db connection close
	}
	
	public function test(){
		return 1;
	}
	
	
	public function accountSetup($data=array() , $campaigns=array())
	{	
		//add account setup details in companies
		$companyData=array(
				"comp_name"=>$data['name'],
				//"transcribe"=>$data['transcribe'],
				"created"=>date("Y-m-d"),
				"logo"=>$data['logo']
		);
		
		$this->db->insert('companies', $companyData);
		
		//get last inserted company id
		$comp_id = $this->db->insert_id();
			
			
		//add company target setup detail in target_setup table
		$targetsetupData=array(
				"comp_id"=>$comp_id,
				"survey_per_day"=>$data['no_survey'],
				"avg_total_score"=>$data['avg_total'],
				"incorrpletes_per_day"=>$data['no_incomplete'],
				"nps_score"=>$data['nps_score'],
				"max_per_day"=>$data['no_max'],
				"day_start_time"=>$data['start_time'],
				"day_end_time"=>$data['end_time']
		);
			
		$this->db->insert('target_setup', $targetsetupData);
			
		//Add user detail in users table
		$userdata=array(
			//	"comp_id"=>$comp_id,
		//		"acc_id"=>COMP_ADMIN,
				"full_name"=>$data['adminname'],
				"user_name"=>$data['adminname'],
				"email"=>$data['adminemail'],
				"security_code"=>$data['security_code'],
				"created"=>date("Y-m-d")
		);
		$this->db->insert('users', $userdata);
		$user_id = $this->db->insert_id();

		$this->db->where('comp_id', $comp_id);
		$this->db->delete('company_campaings');	
		$len = sizeof($campaigns);
		for($index=0; $index<$len;$index++)
		{		
			$cdata = array(
					"comp_id"=>$comp_id,
					"camp_id"=>$campaigns[$index]
			);		
			$this->db->insert('company_campaings', $cdata);
		}
		$this->load->model('users_model');
		///$accessArr=array();
		//$accessArr[0]=COMP_ADMIN;
		$this->users_model->addUserComp( $user_id , COMP_ADMIN , $comp_id , 0 , $data['transcribe'] );
		
		return true;
	}
	
	/**
	 * Get All Companies
	 * */
	function getAllCompanies()
	{
		# Get all Companies
		$this->db->where('comp_id >', 1);
		$data = $this->db->get('companies')->result();
		return $data;
	}
	
	
	function delete($company_id,$statusUpdate)
	{
		$this->db->where('comp_id', $company_id);
		//$this->db->where('comp_id', $comp_id);
		$this->db->update('companies', array('status' => $statusUpdate));
	}
	
	/**
	 * Get company details
	 * @param unknown $comp_id
	 * @return multitype:
	 */
	function getDetail($comp_id)
	{
		
		$this->db->where('comp_id', $comp_id);
		$data['company']=$this->db->get('companies')->result();		
		
		$data['user']= self::getUserDetail($comp_id);
		$data['target_setup']= self::getTargetSetup($comp_id);
		
	
		
		$transcriber=$this->db->query('SELECT transcriber FROM user_companies WHERE comp_id='.$comp_id.' AND acc_id='.COMP_ADMIN)->result();
		
		if(!empty($transcriber)){
			$data['company']['transcriber']=$transcriber[0]->transcriber;
		}else
			 $data['company']['transcriber']=0;
		
		$data = array_merge($data['company'],$data['user'],	$data['target_setup']);
		
		return $data;
	}
	
	private function getUserDetail($comp_id)
	{
		$data= $this->db->query('SELECT full_name, user_name,email FROM users  LEFT JOIN user_companies uc ON users.user_id=uc.user_id
									WHERE uc.comp_id='.$comp_id.' AND acc_id='.COMP_ADMIN.' LIMIT 1')->result();
		
		return $data;
	}
	
	private function getTargetSetup($comp_id)
	{
		$data= $this->db->query('SELECT * FROM target_setup
								WHERE comp_id='.$comp_id)->result();
		return $data;
	}
	
	
	function getCompCampaigns($comp_id)
	{
		$this->db->where('comp_id', $comp_id);
		//$this->db->where('comp_id', $comp_id);
		$data=$this->db->get('company_campaings')->result();
		return $data;
	}
	
	function edit($comp_id,$post)
	{	
		
		$data = array(
				'comp_name' => $post['name'],				
				'platform' => $post['platform'],
				//'transcribe' => $post['transcribe'],
				'last_change'=>now()
		);
		if(isset($post['logo']))
		{
			$data['logo']=$post['logo'];
		}			
					
		$this->db->where('comp_id', $comp_id);
		$this->db->update('companies', $data);
		
		$userid=$this->db->query("SELECT user_id FROM user_companies WHERE comp_id={$comp_id} AND acc_id=".COMP_ADMIN)->result();
	
		$this->db->query("UPDATE users SET full_name='{$post['adminname']}', email='{$post['adminemail']}' 
						 WHERE user_id={$userid[0]->user_id}");
		
		$data = array(
				'survey_per_day'=>$post['no_survey'],
				'avg_total_score'=>$post['avg_total'],
				'incorrpletes_per_day'=>$post['no_incomplete'],
				'nps_score'=>$post['nps_score'],
				'max_per_day'=>$post['no_max'],
				'day_start_time'=>$post['start_time'],
				'day_end_time'=>$post['end_time']
		);
		$this->db->where('comp_id', $comp_id);
		$this->db->update('target_setup', $data);
		
		$this->db->where('comp_id', $comp_id);
		$this->db->delete('company_campaings');
		
		$campaigns=$post['campaign_name'];
		$len = sizeof($campaigns);
		
		for($index=0; $index<$len;$index++)
		{		
			$cdata = array(
					"comp_id"=>$comp_id,
					"camp_id"=>$campaigns[$index]
			);		
			$this->db->insert('company_campaings', $cdata);
		}
		
		$data = array(
				'transcriber' => $post['transcribe']
		);

		$this->db->where('comp_id', $comp_id);
		$this->db->where('acc_id', COMP_ADMIN);
		$this->db->update('user_companies', $data);
		
	}
}



?>