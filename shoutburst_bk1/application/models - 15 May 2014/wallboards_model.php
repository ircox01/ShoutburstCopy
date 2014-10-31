<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wallboards_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	/*
	 * @author:	Muhammad Sajid
	 * @name:	get_wallboards
	 */
	public function get_wallboards()
	{
		$this->db->where('comp_id', $this->comp_id);
		$this->db->where('created_by', $this->user_id);
		#$this->db->where('status', 1);
		$wallboards = $this->db->get('wallboards')->result_array();
		return $wallboards;
	}
	
	/*
	 * @author:	Muhamamd Sajid
	 * @name:	exist
	 */
	public function exist($post)
	{
		$this->db->where('comp_id', $this->comp_id);
		$this->db->where('title', $post['title']);
		$this->db->where('wb_id !=', $post['wb_id']);
		$row = $this->db->get('wallboards')->row_array();
		if (!empty($row)){
			return true;
		} else {
			return false;
		}
	}

	/*
	 * @author:	Muhammad Sajid
	 * @name:	delete
	 */
	public function delete($wb_id)
	{
		$this->db->where('wb_id', $wb_id);
		$this->db->where('comp_id', $this->comp_id);
		if ( $this->db->delete('wallboards') ){
			return 1;
		} else {
			return 0;
		}
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	wallboard_by_slug
	 */
	public function wallboard_by_slug($slug)
	{
		$this->db->where('slug', $slug);
		$this->db->where('comp_id', $this->comp_id);
		$row = $this->db->get('wallboards')->row_array();
		return $row;
	}

	/*
	 * @author:	Muhammad Sajid
	 * @name:	get_wallboard_reports
	 */
	public function get_wallboard_reports()
	{
		$this->db->where('comp_id', $this->comp_id);
		$this->db->where('wallboard', 1);
		$this->db->where('report_type !=', 'data');
		$result = $this->db->get('reports')->result_array();
	
		return $result;
	}
}
?>