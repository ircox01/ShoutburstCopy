<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Service_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Transcriptions_model');
	}
	
	public function checkAgent( $user_pin='' )
	{
		$user = $this->db->query("SELECT DISTINCT u.user_id, uc.comp_id FROM
										  users u LEFT JOIN user_companies uc ON u.user_id=uc.user_id
										  WHERE uc.user_pin='".$user_pin."'")->row_array();
		return $user;
	}
	
	public function getCampID( $campName = '' )
	{
		
		$campID = $this->db->query("SELECT camp_id FROM campaigns WHERE camp_name='".$campName."'")->row();
		if(!empty($campID))				
			return $campID->camp_id;
		else 
			return 0;
	}
	
	public function insertSurvey($insert_survey=array())
	{
		$this->db->insert('surveys', $insert_survey);
		$callid = $this->db->insert_id();
		return $callid;
	}
	
	public function checkCallerID($callid='')
	{
		$count = $this->db->query("SELECT COUNT(sur_id) AS count FROM surveys WHERE sur_id=".$callid)->row();
		return $count;
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	get_routing_plan
	 */
	public function get_routing_plan($callid)
	{
		$sql = "SELECT plan FROM surveys WHERE sur_id = {$callid}";
		$row = $this->db->query($sql)->row_array();
		return $row;
	}
	
	public function getQuestions($callid='')
	{
		$sql = "SELECT q1 , q2 , q3 , q4 , q5 FROM surveys WHERE sur_id=" . $callid;
		$row = $this->db->query($sql)->row_array();
		return $row;
	}
	
	public function updateSurveyScore($questions='', $total_score='' , $average_score='' , $action='' , $callid='', $max_q = '')
	{
		$query = "UPDATE surveys SET $questions, total_score=$total_score, average_score=$average_score , action='".$action."', processed=1 $max_q WHERE sur_id=".$callid;
		$result =  $this->db->query($query);
		return $result;
	}
	
	public function updateSurveyRecording($filename='', $filepath='' ,$action='', $callid='')
	{
		$query = "UPDATE surveys SET recording='{$filename}' , ftp_path='{$filepath}' , action='".$action."' ,  recorded=1  WHERE sur_id=".$callid;
		$result =  $this->db->query($query);
		$trans=$this->Transcriptions_model->insert_transcription($callid);
		return $result; 
	}
	
}
?>
