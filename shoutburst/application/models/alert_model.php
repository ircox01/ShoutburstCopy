<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alert_model extends CI_Model {

	public function __construct()
	{

	}
	
	public function addAlert( $post = array(), $createdBy ='' , $comp_id='' )
	{		
		
		$data = array(
						'alert_name'		=>	$post['alert_name'],
						'send_email'		=>	($post['send_email']=="on")?1:0,
						'send_sms'			=>	($post['send_sms']=="on")?1:0,
						'email_addresses'	=>	$post['email_address'],
						'sms_numbers'		=>	$post['sms'],
						'filter_conditions' =>  $this->resetFilter($post['filters1']),
						'alert_period'		=>  $post['period'],
						'created_on'		=>	date('Y-m-d h:i:s a', time()),
						'created_by'		=>	$createdBy,
						'status'			=>  0,
						'comp_id'			=>  $comp_id
				);
		
		$this->db->insert("alerts",$data);
	}
	
	public function getAlerts($comp_id='')
	{
		$result = $this->db->query("SELECT a.alert_id, a.alert_name, a.status, DATE_FORMAT(a.created_on,'%Y-%m-%d %H:%i') as createdon, u.full_name,a.filter_conditions FROM alerts a JOIN users u ON a.created_by=u.user_id WHERE comp_id=$comp_id ORDER BY createdon DESC ")->result_array();
		return $result;
	}
	
	public function getAlertDetails($alert_id)
	{
		$this->db->where("alert_id", $alert_id);
		$this->db->from("alerts");
		$result = $this->db->get()->result();
		return $result;	
	}
	
	public function updateAlert( $post = array() , $modifiedby='' )
	{	
		$data = array(
					'alert_name'		=>	$post['alert_name'],
					'send_email'		=>	($post['send_email']=="on")?1:0,
					'send_sms'			=>	($post['send_sms']=="on")?1:0,
					'email_addresses'	=>	$post['email_address'],
					'sms_numbers'		=>	$post['sms'],
					'filter_conditions' =>  $this->resetFilter($post['filters1']),
					'alert_period'		=>  $post['period'],
					'modified_on'		=>	date('Y-m-d h:i:s a', time()),
					'modified_by'		=>	$modifiedby				
					);
		
		$this->db->where('alert_id',$post['alert_id']);
		$this->db->update("alerts",$data);
	}
	
	public function delete( $alert_id='')
	{
		$this->db->where('alert_id', $alert_id);		
		$this->db->delete('alerts');
	}
	
	private function resetFilter($filters1)
	{
		$filters1 = implode(", ",array_filter(explode(",",$filters1)));
		$filters1 = explode(",",$filters1);
		$filters1[0] = preg_replace("/\s*(\bOr\b)|(\bAnd\b)\s*/i", "", $filters1[0]);	
		$filters1 = implode(", ",$filters1);
		return $filters1;
	}
}
