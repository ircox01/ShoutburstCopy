<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboards_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	my_dashboard
	 */
	public function my_dashboard($user_id, $comp_id)
	{
		$dashboard = $this->db->query("select * from dashboards where user_id = {$user_id} and comp_id = {$comp_id}")->row_array();
		return $dashboard;
	}	
}
?>