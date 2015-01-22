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

	#to add actual team tags into the database
	#@usamanoman
	function add_actual_tag($data){
		# if already exists
		$this->db->where('actual_tag_name', $data['tg_name']);
		$this->db->where('comp_id', $data['comp_id']);
		$this->db->where('status', 1);
		$tg_return = $this->db->get('actual_tags')->row_array();
		
		if ( empty($tg_return) )
		{
			$tg_insert_data['actual_tag_name'] = $data['tg_name'];
			$tg_insert_data['comp_id'] = $data['comp_id'];
			$tg_insert_data['color'] = $data['tg_color'];
			$tg_insert_data['txt_color'] = $data['tg_txt_color'];
			
			$this->db->insert('actual_tags', $tg_insert_data);
			$this->session->set_flashdata('message', '<div id="message" class="update">Actual Tag added successfully</div>');
		} else {
			$this->session->set_flashdata('message', '<div id="message" class="error">Actual Tag already exists</div>');				
		}
	}
	function update_actual_tags($data){
		if ( empty($data['return']) )
		{
			$update_data['actual_tag_name'] = $data['tag_name'];
			$update_data['comp_id'] = $data['comp_id'];
			$update_data['color'] = $data['tag_color'];
			$update_data['txt_color'] = $data['tag_txt_color'];

			$this->db->where('actual_tag_id', $data['tag_id']);
			$this->db->update('actual_tags', $update_data);
			$this->session->set_flashdata('message', '<div id="message" class="update">Actual Team Tag saved successfully</div>');
		} else {
			$this->session->set_flashdata('message', '<div id="message" class="error">Actual Team Tag already exists</div>');
		}
	}
	function actual_tag_already_exist($tag_name,$comp_id,$tag_id){
		$this->db->where('actual_tag_name', $tag_name);
		$this->db->where('comp_id', $comp_id);
		$this->db->where('actual_tag_id !=', $tag_id);
		$this->db->where('status', 1);
		
		return $this->db->get('actual_tags')->row_array();
	}
	function get_actual_tags_from_id($comp_id,$id){
		return $this->db->get_where('actual_tags', array('actual_tag_id'=>$id, 'comp_id'=>$comp_id))->result();
	}

	function get_actual_tags($comp_id){
		$this->db->where('comp_id', $comp_id);
		$this->db->where('status', 1);
		$tags = $this->db->get('actual_tags')->result();
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
