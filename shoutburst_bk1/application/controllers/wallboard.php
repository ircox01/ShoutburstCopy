<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wallboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$data['title'] = TITLE.' | Wallboard';
		$this->load->model('Reports_model', 'reports');
		$this->load->model('Wallboards_model', 'wallboards');
		
		$this->user_id = $this->session->userdata['user_id'];
		$this->comp_id = $this->session->userdata['comp_id'];
		$this->access = $this->session->userdata['access'];
		$this->style = array('slide','dissolve','fade','static');
		sort($this->style);
		
		$this->load->vars($data);
		
		if( ! isset($this->session->userdata['user_id']) )
			redirect('login/index');
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	index
	 */
	public function index()
	{		
		$data['wallboards'] = $this->wallboards->get_wallboards();
		$data['wb_reports'] = $this->wallboards->get_wallboard_reports();
		$data['style'] = $this->style;
		
		$this->load->template('wallboard/index', $data);
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	edit
	 */
	public function edit()
	{
		$data['action'] = 'edit';
		$data['wallboards'] = $this->wallboards->get_wallboards();
		$data['wb_reports'] = $this->wallboards->get_wallboard_reports();
		$data['style'] = $this->style;
		
		$wb_id = $this->uri->segment(3);
		
		# save posted varaibles in array variable
		$post = $this->input->post();		
		
		if (isset($post) && !empty($post))
		{
			# if already exist!
            $return = $this->wallboards->exist($post);
            
			if ( !$return )
			{
				// wallboard logo
				$logo = 'no_image_uploaded.png';
				if( ($_FILES['logo']['error'] == 0) && sizeof($_FILES['logo']) > 0 )
				{						
					$extentions = array('png','jpg','jpeg','gif');
					
					$dir = WB_PHOTO;							
						
					$name = $_FILES['logo']['name'];
					$tmp_name = $_FILES['logo']['tmp_name'];
					$size = $_FILES['logo']['size'];
					
					$explode = explode('.', $name);
					if( in_array($explode[1], $extentions) )
					{								
						$logo = $this->utility_model->upload_file($explode[1], $tmp_name, $dir);							
						//unlink old photo						
						if($old_photo!=''){
							//check old file exsist
							if (file_exists(PUBPATH.$old_photo)){
								unlink(PUBPATH.$old_photo);
							}
						}
					}						
					$update_wb['logo'] = $logo;
				}
				
				$wb_id = $post['wb_id'];
				$update_wb['title'] = $post['title'];
				$update_wb['slug'] = generate_url_slug( $post['title'] );
				$update_wb['type'] = $post['type'];
				$update_wb['screen_delay'] = $post['screen_delay'];
	            $update_wb['effects'] = $post['effects'];
	            $update_wb['ticker_tape'] = $post['ticker_tape'];
	            $update_wb['created_by'] = $this->user_id;
	            if (isset($post['default_logo']) && $post['default_logo']=='on'){
	            	$update_wb['default_logo'] = 1;
	            } else {
	            	$update_wb['default_logo'] = 0;
	            }
				if (isset($post['wb_report']) && ($post['wb_report'] > 0)){
					$update_wb['report_id'] = $post['wb_report'];
				} else {
					$update_wb['report_id'] = 0;
				}
	            
	            $this->db->where('wb_id', $wb_id);
				$this->db->update('wallboards', $update_wb);
						
				$this->session->set_flashdata('message', '<div id="message" class="update">Wallboard saved successfully</div>');
			} else {
				$this->session->set_flashdata('message', '<div id="message" class="error">Wallboard already exists</div>');
			}
			redirect('wallboard');
		}
		
		if ( is_numeric($wb_id) ) {
			
			$wb = $this->db->get_where('wallboards', array('wb_id'=>$wb_id, 'comp_id'=>$this->comp_id))->result();
		
			if (!empty($wb))
			{
				$data['wb_info'] = $wb;				
			} else {
				redirect('wallboard');
			}	
			
			$this->load->template('wallboard/index', $data);
		
		} else {
			redirect('wallboard');
		}
	}

	/*
	 * @author:	Muhammad Sajid
	 * @name:	add
	 */
	public function add()
	{
		# save posted varaibles in array variable
		$post = $this->input->post();
		
		if (isset($post) && !empty($post))
		{
			$title = str_replace("-"," ",$post['title']);
			
			if (isset($post['wb_report']) && ($post['wb_report'] > 0)){
				$insert_wb['report_id'] = $post['wb_report'];
			}
			
			# if already exists
			$this->db->where('comp_id', $this->comp_id);
			$this->db->where('title', $title);
			$return = $this->db->get('wallboards')->row_array();
			
			if ( empty($return) )
			{
				// Wallboard logo
				$logo = 'no_image_uploaded.png';
				if( ($_FILES['logo']['error'] == 0) && sizeof($_FILES['logo']) > 0 )
				{					
					$extentions = array('png','jpg','jpeg','gif');
					
					$dir = WB_PHOTO;							
						
					$name = $_FILES['logo']['name'];
					$tmp_name = $_FILES['logo']['tmp_name'];
					$size = $_FILES['logo']['size'];
					
					$explode = explode('.', $name);
					if( in_array($explode[1], $extentions) )
					{
						$logo = $this->utility_model->upload_file($explode[1], $tmp_name, $dir);
					}
				}
				
				$insert_wb['logo'] = $logo;
				$insert_wb['created_on'] = date('Y-m-d');
				$insert_wb['title'] = $post['title'];
				$insert_wb['slug'] = generate_url_slug( $post['title'] );
				$insert_wb['type'] = $post['type'];
				$insert_wb['screen_delay'] = $post['screen_delay'];
	            $insert_wb['effects'] = $post['effects'];
	            $insert_wb['ticker_tape'] = $post['ticker_tape'];
	            $insert_wb['created_by'] = $this->user_id;
	            $insert_wb['comp_id'] = $this->comp_id;
	            if (isset($post['default_logo']) && $post['default_logo']=='on'){
	            	$insert_wb['default_logo'] = 1;
	            } else {
	            	$insert_wb['default_logo'] = 0;
	            }
	            $insert_id = $this->db->insert('wallboards', $insert_wb);
	            								
				$this->session->set_flashdata('message', '<div id="message" class="update">Wallboard added successfully</div>');
			} else {				
				$this->session->set_flashdata('message', '<div id="message" class="error">Wallboard already exists</div>');				
			}
			redirect('wallboard');
		}
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	delete
	 */
	public function delete()
	{
		$wb_id = $_POST['wb_id'];
		if ($this->wallboards->delete($wb_id) == 1){
			$this->session->set_flashdata('message', '<div id="message" class="update">Wallboard deleted successfully</div>');
		} else {
			$this->session->set_flashdata('message', '<div id="message" class="error">Error occured while deleting Wallboard</div>');
		}
	}

	/*
	 * @author:	Muhammad Sajid
	 * @name:	launch
	 */
	public function launch()
	{
		$wbs = $this->wallboards->get_wallboards();
		$slugs = "";
		$slug = trim($this->uri->segment(3));


		$wbs_count = count($wbs);
		for ($i=0 ; $i < $wbs_count; $i++) {
			if ($wbs[$i]['type']  != 'report') {
				unset($wbs[$i]);
			}
		}
		$wbs = array_values($wbs);
		//print_r($wbs);

		$slug = strtolower($slug);
		if (count($wbs) > 0) {
			$pos = 0;
			foreach ($wbs as $elemwb) {
				if ($slug ==  $elemwb['slug']) {
					 if (($pos + 1) <= count($wbs) - 1) {
						$nextslug = $wbs[$pos+1]['slug'];
					} else {
						 $nextslug = $wbs[0]['slug'];
					}
					break;					
				}
				$pos++;
			}
		}
		//echo $nextslug;
		$data['wb'] = $this->wallboards->wallboard_by_slug($slug);		
		$data['nextslug'] = $nextslug;
		
		if ($slug == 'new-high-score'){
			$this->load->template('wallboard/congrats', $data);
		} else {
			if($data['wb']['type']=='report')
			{
				$this->load->model('Reports_model', 'reports');
				$data['report'] = $this->reports->get_report($data['wb']['report_id']);
			
				$this->load->view('wallboard/launch', $data);
			}
			//$this->load->template('wallboard/launch', $data);
		}		
	}

	/*
	 * @author:	Muhammad Sajid
	 * @name:	wb_reports
	 */
	public function wb_reports()
	{
		var_debug($_POST);exit;
	}
	
	public function  wallboard_launch()
	{
		unset($_COOKIE['data']);
		$comp_id	=	$this->session->userdata['comp_id'];
		$query		=	"SELECT MAX(score) high_score,agent_name ,user_id, logo FROM
						(SELECT SUM(average_score) AS score,u.user_id, u.full_name AS agent_name, u.photo AS logo
						FROM surveys s
						JOIN target_setup ts ON ts.comp_id=s.comp_id
						JOIN users u ON u.user_id=s.user_id
						WHERE s.comp_id=$comp_id			
						AND DATE_FORMAT(date_time,'%d-%m-%Y') = DATE_FORMAT(now(),'%d-%m-%Y')
						AND (average_score)>= ts.highest_score
						GROUP BY s.user_id ORDER BY date_time)
						tbl ";
		$data['wb'] = $this->db->query($query)->row_array();
			
		if(!empty($data['wb']['user_id']))
		{				
			echo $data['wb']['user_id'];
		}
		else 
		{
			echo 0;
		}
	}
	
	public function congrats()
	{
		$id = $this->uri->segment(3);
		$comp_id	=	$this->session->userdata['comp_id'];
		$query		=	"SELECT SUM(average_score) high_score , u.full_name AS agent_name ,u.user_id, u.photo AS logo						
						FROM surveys s
						JOIN target_setup ts ON ts.comp_id=s.comp_id
						JOIN users u ON u.user_id=s.user_id
						WHERE s.comp_id=$comp_id	AND u.user_id=$id		
						AND DATE_FORMAT(date_time,'%d-%m-%Y') = DATE_FORMAT(now(),'%d-%m-%Y')
						AND (average_score)>= ts.highest_score
						GROUP BY s.user_id ORDER BY date_time ";
		$data['wb'] = $this->db->query($query)->row_array();
		$data['wb']['ticker_tape'] = "Well done|".$data['wb']['agent_name']."|You scored|".$data['wb']['high_score']."|Thats awesome!";
		
		$this->load->view("wallboard/congrats",$data);
	}
	
	
}
