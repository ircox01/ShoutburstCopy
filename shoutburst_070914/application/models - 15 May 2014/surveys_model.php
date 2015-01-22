<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Surveys_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	get_survey
	 */
	public function get_survey($sur_id)
	{
		$result = $this->db->get_where('surveys', array('sur_id'=>$sur_id, 'processed'=>1))->result_array();
		return $result;
	}
}
?>