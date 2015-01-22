<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author:	Muhammad Sajid
 * @desc:	This is only allowed for company admin
 */
class Tags extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$data['title'] = TITLE.' | Tags';
		$this->load->vars($data);
		$this->load->model('Users_model');
		$this->load->model('Company_model');
		$this->load->model('Tags_model','tags_model');
		$this->load->model('Campaigns_model', 'campaigns');
		
		$this->comp_id = $this->session->userdata['comp_id'];
		$this->user_id = $this->session->userdata['user_id'];
		$this->access = $this->session->userdata['access'];
		
		if( ! isset($this->session->userdata['user_id']) ) {
			redirect('login');
		} elseif( $this->session->userdata['access'] != COMP_ADMIN ){
			redirect('dashboard');
		}
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	index
	 */
	public function index()
	{
		# Get all Tags
		$data['tags'] = $this->db->get_where('tags', array('comp_id'=>$this->comp_id, 'status'=>1))->result();
		
		# Get all Tags Group
		$data['tags_group'] = $this->db->get_where('tags_group', array('comp_id'=>$this->comp_id, 'status'=>1))->result();
		
		# Get all actual tags @usamanoman
		$data['actual_tags'] = $this->tags_model->get_actual_tags($this->comp_id);

		$data['action'] = 'new';		
		$this->load->template('tags/index', $data);
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	add
	 */
	public function add()
	{
		# save posted varaibles in array variable
		$post = $this->input->post();
		
		$uri_segment = $this->uri->segment(3);

		if (isset($post) && !empty($post))
		{
			if ($uri_segment == 'tags')
			{
				# user wants to add Tags/Team

				if (isset($post['time_tag_name'])) {
					$tag_name = $post['time_tag_name'];
				} else {
					$tag_name = $post['tag_name'];
				}

				$tag_color = $post['color'];
				$tag_txt_color = $post['txt_color'];
				
				# if already exists
				$this->db->where('tag_name', $tag_name);
				$this->db->where('comp_id', $this->comp_id);
				$return = $this->db->get_where('tags')->row_array();
				
				if ( empty($return) )
				{
					$insert_data['tag_name'] = $tag_name;
					$insert_data['comp_id'] = $this->comp_id;
					$insert_data['color'] = $tag_color;
					$insert_data['txt_color'] = $tag_txt_color;
					
					$this->db->insert('tags', $insert_data);
					$this->session->set_flashdata('message', '<div id="message" class="update">Tag added successfully</div>');
				} else {
					$this->session->set_flashdata('message', '<div id="message" class="error">Tag already exists ('.$tag_name.')</div>');				
				}
				
			} elseif ($uri_segment == 'tags_group') {
				
				# user wants to add Tags/Team Group
				$tg_name = $post['tags_group_name'];
				$tg_color = $post['tg_color'];
				$tg_txt_color = $post['tg_txt_color'];
				$tag_ids = $post['tag_ids'];
				if ($tag_ids != '0'){
					$tag_ids = '['.json_encode($tag_ids).']';
				}
				
				# if already exists
				$this->db->where('tg_name', $tg_name);
				$this->db->where('comp_id', $this->comp_id);
				$tg_return = $this->db->get('tags_group')->row_array();
				
				if ( empty($tg_return) )
				{
					$tg_insert_data['tg_name'] = $tg_name;
					$tg_insert_data['comp_id'] = $this->comp_id;
					$tg_insert_data['tg_color'] = $tg_color;
					$tg_insert_data['tg_txt_color'] = $tg_txt_color;
					$tg_insert_data['tag_ids'] = $tag_ids;
					
					$this->db->insert('tags_group', $tg_insert_data);
					$this->session->set_flashdata('message', '<div id="message" class="update">Tags Group added successfully</div>');
				} else {
					$this->session->set_flashdata('message', '<div id="message" class="error">Tags Group already exists</div>');				
				}
				
			}		
			elseif ($uri_segment == 'actual_tags') {
				
				# user wants to add actual team tags
				$data['tg_name'] = $post['tag_name'];
				$data['tg_color'] = $post['color'];
				$data['tg_txt_color'] = $post['txt_color'];
				$data['comp_id'] = $this->comp_id;
				
				$this->tags_model->add_actual_tag($data);
				
			}		

			

			redirect('tags');
		}
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	edit
	 */
	public function edit()
	{
		$data['action'] = 'edit';
		$data['tags_group'] = $this->db->get_where('tags_group', array('comp_id'=>$this->comp_id, 'status'=>1))->result();
		$id = $this->uri->segment(4);
		
		$uri_segment = $this->uri->segment(3);
		
		# save posted varaibles in array variable
		$post = $this->input->post();		
		
		if (isset($post) && !empty($post))
		{
			if ($uri_segment == 'tags')
			{
				# user wants to edit Tags/Team
				$tag_name = $post['tag_name'];
				$tag_color = $post['color'];
				$tag_txt_color = $post['txt_color'];
				$tag_id = $post['tag_id'];
			
				# if already exists
				$this->db->where('tag_name', $tag_name);
				$this->db->where('comp_id', $this->comp_id);
				$this->db->where('tag_id !=', $tag_id);
				$return = $this->db->get('tags')->row_array();
				
				if ( empty($return) )
				{
					$update_data['tag_name'] = $tag_name;
					$update_data['comp_id'] = $this->comp_id;
					$update_data['color'] = $tag_color;
					$update_data['txt_color'] = $tag_txt_color;
	
					$this->db->where('tag_id', $tag_id);
					$this->db->update('tags', $update_data);
					$this->session->set_flashdata('message', '<div id="message" class="update">Tag saved successfully</div>');
				} else {
					$this->session->set_flashdata('message', '<div id="message" class="error">Tag already exists</div>');
				}
				
			} 
			else if ($uri_segment == 'actual_tags')
			{
				# user wants to edit Tags/Team
				$data['tag_name'] = $post['tag_name'];
				$data['tag_color'] = $post['color'];
				$data['tag_txt_color'] = $post['txt_color'];
				$data['tag_id'] = $post['tag_id'];
				$data['comp_id']=$this->comp_id;
			
				# if already exists
				$data['return']  = $this->tags_model->actual_tag_already_exist($data['tag_name'],$this->comp_id,$data['tag_id']);
									
				$this->tags_model->update_actual_tags($data);
				
			} 

			elseif ($uri_segment == 'tags_group') {
				
				# user wants to edit Tags/Team Group
				$tg_id = $post['tg_id'];
				$tg_name = $post['tags_group_name'];
				$tg_color = $post['tg_color'];
				$tg_txt_color = $post['tg_txt_color'];
				$tag_ids = $post['tag_ids'];
				if ($tag_ids != '0'){
					$tag_ids = '['.json_encode($tag_ids).']';
				}
				
				# if already exists
				$this->db->where('tg_name', $tg_name);
				$this->db->where('comp_id', $this->comp_id);
				$this->db->where('tg_id !=', $tg_id);
				$tg_return = $this->db->get('tags_group')->row_array();
				
				if ( empty($tg_return) )
				{
					$tg_update_data['tg_name'] = $tg_name;
					$tg_update_data['comp_id'] = $this->comp_id;
					$tg_update_data['tg_color'] = $tg_color;
					$tg_update_data['tg_txt_color'] = $tg_txt_color;
					$tg_update_data['tag_ids'] = $tag_ids;
	
					$this->db->where('tg_id', $tg_id);
					$this->db->update('tags_group', $tg_update_data);
					$this->session->set_flashdata('message', '<div id="message" class="update">Tags Group saved successfully</div>');
				} else {
					$this->session->set_flashdata('message', '<div id="message" class="error">Tags Group already exists</div>');
				}
			}
			redirect('tags');
		}
		
		if ( is_numeric($id) )
		{			
			if ($uri_segment == 'tags')
			{
				$tag = $this->db->get_where('tags', array('tag_id'=>$id, 'comp_id'=>$this->comp_id))->result();
				$data['tags'] = $this->db->get_where('tags', array('comp_id'=>$this->comp_id, 'status'=>1))->result();
				$data['actual_tags'] = $this->tags_model->get_actual_tags($this->comp_id);
				
				if (!empty($tag))
				{
					$data['tag_info'] = $tag;				
				} else {
					redirect('tags');
				}
			}
			else if ($uri_segment == 'actual_tags')
			{
				$tag = $this->tags_model->get_actual_tags_from_id($this->comp_id,$id);
				# Get all Tags
				$data['tags'] = $this->db->get_where('tags', array('comp_id'=>$this->comp_id, 'status'=>1))->result();
				
				# Get all Tags Group
				$data['tags_group'] = $this->db->get_where('tags_group', array('comp_id'=>$this->comp_id, 'status'=>1))->result();
				$data['actual_tags'] = $this->tags_model->get_actual_tags($this->comp_id);
				
				if (!empty($tag))
				{
					$data['actual_tag_info'] = $tag;				
				} else {
					redirect('tags');
				}
			} 
			elseif ($uri_segment == 'tags_group'){
				
				$tags_group = $this->db->get_where('tags_group', array('tg_id'=>$id, 'comp_id'=>$this->comp_id))->result();
							
				if (!empty($tags_group))
				{
					$data['team_group_info'] = $tags_group;
					
					if ($data['team_group_info'][0]->tag_ids != '0') 
					{
						$tag_ids = implode(",", json_decode( $data['team_group_info'][0]->tag_ids ) );
						
						# Get Tags/Team
						$data['tg_tags'] = $this->db->query("SELECT * FROM tags WHERE tag_id IN ($tag_ids) AND comp_id = {$this->comp_id} AND status = 1")->result();
						
						# Get remaining Tags/Team
						$data['tags'] = $this->db->query("SELECT * FROM tags WHERE tag_id NOT IN ($tag_ids) AND comp_id = {$this->comp_id} AND status = 1")->result();
					} else {
						$data['tags'] = $this->db->get_where('tags', array('comp_id'=>$this->comp_id, 'status'=>1))->result();
					}
					
				} else {
					redirect('tags');
				}
			}
			$data['uri_segment'] = $uri_segment;
			$this->load->template('tags/index', $data);
		
		} else {
			redirect('tags');
		}
	}

	/*
	 * @author:	Muhammad Sajid
	 * @name:	delete
	 */
	public function delete()
	{
		$uri_segment = $_GET['entity'];
		$id = $_GET['id'];
		
		/*$id = $this->uri->segment(3);
		$uri_segment = $this->uri->segment(4);*/
	
		if ( is_numeric($id) )
		{
			if ($uri_segment == 'tags')
			{
				$this->db->where('tag_id', $id);
				$this->db->where('comp_id', $this->comp_id);
				$this->db->update('tags', array('status' => 0));
				$this->session->set_flashdata('message', '<div id="message" class="update">Tag deleted successfully</div>');
				
			}
			else if ($uri_segment == 'actual_tags')
			{
				$this->db->where('actual_tag_id', $id);
				$this->db->where('comp_id', $this->comp_id);
				$this->db->update('actual_tags', array('status' => 0));
				$this->session->set_flashdata('message', '<div id="message" class="update">Actual Tag deleted successfully</div>');
				
			}
			elseif ($uri_segment == 'tags_group'){
				$this->db->where('tg_id', $id);
				$this->db->where('comp_id', $this->comp_id);
				$this->db->update('tags_group', array('status' => 0));
				$this->session->set_flashdata('message', '<div id="message" class="update">Tag Group deleted successfully</div>');
			}
		} else {
			$this->session->set_flashdata('message', 'Error while deleting.');
		}
	}	
}
