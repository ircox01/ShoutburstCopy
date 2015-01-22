<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tags_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	/*
	 * @author:	Muhammad Sajid
	 * @name:	get_tags
	 */
	function get_tags($comp_id)
	{
		$this->db->where('comp_id', $comp_id);
		$this->db->where('status', 1);
		$tags = $this->db->get('tags')->result();
		return $tags;
	}

	function get_group_tags($comp_id)
	{
		$this->db->where('comp_id', $comp_id);
		$this->db->where('status', 1);
		$tags = $this->db->get('tags_group')->result();
		return $tags;
	}

}

?>
