<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Media_model extends CI_Model {

	public function __construct()
	{
		$this->comp_id = $this->session->userdata['comp_id'];
		$this->user_id = $this->session->userdata['user_id'];
	}
	
	public function getMediaTypes()
	{
		return $this->db->query('SELECT * FROM media_types')->result();
	}
	
	public function getMediaType($media_id)
	{
		$this->db->where('media_id', $media_id);
		$this->db->from('media_types');
		return $this->db->get()->row();
	}
	
	public function getMediaLinks()
	{
		$this->db->select('cm.*,m.name media_name,c.camp_name');
		$this->db->from('company_media cm');
		$this->db->join('campaigns c', 'c.camp_id=cm.camp_id', 'LEFT');
		$this->db->join('media_types m', 'm.media_id=cm.media_id', 'INNER');
		$this->db->where('comp_id', $this->comp_id);
		return $this->db->get()->result();
	}

	public function getMediaLink($link_id)
	{
		$this->db->where('comp_id', $this->comp_id);
		$this->db->where('link_id', $link_id);
		$this->db->from('company_media');
		return $this->db->get()->row();
	}
	
	
	public function updateMediaLink($data) 
	{
		if (isset($data['link_id']) && $data['link_id']) {
			$this->db->where('comp_id', $this->comp_id);
			$this->db->where('link_id', $data['link_id']);
			$this->db->update('company_media', $data);
			return $data['link_id'];
		} else {
			$data['comp_id'] = $this->comp_id;
			$this->db->insert('company_media', $data);
			return $this->db->insert_id();
		}
	}

	public function deleteMediaLink($link_id) 
	{
		$this->db->where('comp_id', $this->comp_id);
		$this->db->where('link_id', $link_id);
		$this->db->delete('company_media');
	}
	
	public function getMediaOptions($media_id)
	{
		$this->db->from('company_media_options');
		$this->db->where('comp_id', $this->comp_id);
		$this->db->where('media_id', $media_id);
		$data = $this->db->get()->row();
		if (isset($data->options_json) && !empty($data->options_json)) {
			return json_decode($data->options_json, true);
		}	
	}

	public function updateMediaOptions($media_id, $options) 
	{
		$this->db->from('company_media_options');
		$this->db->where('comp_id', $this->comp_id);
		$this->db->where('media_id', $media_id);
		$data = $this->db->get()->row_array();
		$data['options_json'] = json_encode($options);
		if (isset($data['media_id']) && isset($data['comp_id'])) {
			unset($data['comp_id'], $data['media_id']);
			$this->db->where('comp_id', $this->comp_id);
			$this->db->where('media_id', $media_id);
			$this->db->update('company_media_options', $data);
		} else {
			$data['comp_id'] = $this->comp_id;
			$data['media_id'] = $media_id;
			$this->db->insert('company_media_options', $data);
		}
	}
		
	public function schedule($link_id = 0)
	{
		$query = "select distinct link_id,count(*) as count from media_redirects where status='new'";
		if ($link_id) {
			$query .= ' and link_id='.$link_id;
		}	
		$query .= ' group by link_id';
		$total_respondents = 0;
		$links = $this->db->query($query)->result();
		foreach ($links as $link) {
			var_dump($link);
			if ($link->count) {
				$total_respondents += $link->count;
				$this->db->insert('media_process', array(
					'link_id' => $link->link_id,
					'user_id' => $this->user_id
				));
			}
		}
		return $total_respondents;
	}
	
}
