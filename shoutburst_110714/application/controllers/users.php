<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author:	Muhammad Sajid
 * @desc:	This is only allowed for company admin
 */
class Users extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$data['title'] = TITLE.' | Users';
		$this->load->vars($data);
		$this->load->model('users_model');
		$this->load->model('tags_model', 'tags');
		$this->user_id = $this->session->userdata['user_id'];
		$this->comp_id = $this->session->userdata['comp_id'];
		
		if( ! isset($this->session->userdata['user_id']) ) {
			redirect('login');
		}
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	index
	 *
	 */
	public function index()
	{
		# get session variable
		$comp_id = $this->session->userdata['comp_id'];	
		# Get all users	
		$data['users'] = $this->users_model->getUsers($comp_id);	
		$data['tagmap'] = array();
		foreach ($data['users'] as $u) {
			$user_id = $u->user_id;
			$tags_list = $this->users_model->my_tags_list($user_id);
			$tags_list = implode(",",$tags_list);
			$data['tagmap'][$user_id] = $tags_list;
		}		


		$this->load->template('users/index', $data);
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	add
	 * 
	 */
	public function add()
	{
		# get session variable
		$user_id = $this->session->userdata['user_id'];
		$comp_id = $this->session->userdata['comp_id'];
		
		# Get all Tags
		$data['tags'] = $this->tags->get_tags($comp_id);
		
		# Get all Access Levels
		$data['access_levels'] = $this->users_model->getAccessList();
		
		# save posted varaibles in array variable
		$post = $this->input->post();	
		
		if (isset($post) && !empty($post))
		{
				
			$user_name	=	rtrim($post['user_name']);
			$user_login	=	rtrim($post['user_login']);
			$accessArr	= 	$post['accessArr'];
			$tags		= 	$post['tags'];
			$user_pin	=	rtrim($post['user_pin']);
			$user_email	=	rtrim($post['user_email']);
			$user_photo = "";
						
			if ($accessArr != COMP_AGENT){
				$user_pin = 0;
			}
			
			//if field is not empty
			if( $user_name!='' && $user_login!=''  && $user_email!='' && !empty($accessArr) )
			{
				# if PIN already exist
				if ( !$this->users_model->check_pin($user_pin, $accessArr) ){
							
					# if already exists for current compnay
					$return = $this->users_model->checkUser( $comp_id , $user_email );
		
					if ( empty($return) )
					{
						//check if email address already exists
						$ret = $this->users_model->checkemail($user_email);
						
						if( empty ( $ret ) )
						{
							//check if user name is unique or not
							$checkusername = $this->users_model->checkusername($user_login);
						
							//check if user name already exists
							if( empty ( $checkusername ) )
							{							
								// Agent photo					
								if( ($_FILES['user_photo']['error'] == 0) && sizeof($_FILES['user_photo']) > 0 )
								{
									
									$extentions = array('png','jpg','jpeg','gif');
									
									$dir = USER_PHOTO;							
										
									$name = $_FILES['user_photo']['name'];
									$tmp_name = $_FILES['user_photo']['tmp_name'];
									$size = $_FILES['user_photo']['size'];
									
									$explode = explode('.', $name);
									if( in_array($explode[1], $extentions) )
									{
										$user_photo = $this->utility_model->upload_file($explode[1], $tmp_name, $dir);
									}							
								}
		
								# insert into users
								$insert_agent['full_name'] = $user_name;
								$insert_agent['user_name'] = $user_login;
								$insert_agent['email'] = $user_email;
								$insert_agent['security_code'] = self::_getsecurityCode();
								$insert_agent['photo'] = $user_photo;
								$insert_agent['created'] = date('Y-m-d');
								
								$insert_id = $this->users_model->addUser($insert_agent);
								
								if( $insert_id > 0 )
								{
									# add user_tags
									$this->users_model->add_tags($comp_id, $insert_id, $tags);
									
									$this->users_model->addUserComp( $insert_id , $accessArr , $comp_id , $user_pin , 0 );
									
									if ( $this->send_email($user_name,$user_email,$insert_agent['security_code']) )
									{
										$this->session->set_flashdata('message', '<div id="message" class="update">User added and emailed successfully</div>');
									}
									else
									{
										$this->session->set_flashdata('message', '<div id="message" class="error">Email sending fail.</div>');						
									}
								}
								else
								{
									$this->session->set_flashdata('message', '<div id="message" class="error">Adding new user failed.</div>');
								}
							}
							else
							{
								$this->session->set_flashdata('message', '<div id="message" class="error">User login name already exists.</div>');
							}				
						}
						else
						{//assign existing user to different company
							$this->users_model->add( $ret['user_id'] , $comp_id , $accessArr , $user_pin );
							$this->session->set_flashdata('message', '<div id="message" class="update">Added successfully.</div>');						
						}
					}//end if(empty($return))
					else
					{
						$this->session->set_flashdata('message', '<div id="message" class="error">Email address already exists.</div>');
					}
				} else {
					$this->session->set_flashdata('message', '<div id="message" class="error">PIN already exists.</div>');
				}
			}
			else
			{
				$this->session->set_flashdata('message', '<div id="message" class="error">Some required fields are missing.</div>');
			}
			redirect('users');
		}
		$this->load->view('users/add', $data);
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	edit
	 */
	public function edit()
	{
		# get session variable
		$comp_id = $this->session->userdata['comp_id'];		
		$user_id = $this->uri->segment(3);
		
		# save posted varaibles in array variable
		$post = $this->input->post();
		
		if (isset($post) && !empty($post))
		{
			$post = $this->input->post();
		
			$user_name	=	rtrim($post['user_name']);
			$user_login	=	rtrim($post['user_login']);
			$accessArr	= $post['accessArr'];
			$tags		= 	$post['tags'];
			$user_pin	=	rtrim($post['user_pin']);
			$user_email	=	rtrim($post['user_email']);
			$old_photo	=	rtrim($post['old_photo']);
			
			if ($accessArr != COMP_AGENT){
				$user_pin = 0;
			}
			
			//if field is not empty
			if( $user_name!='' && $user_login!=''  &&  $user_email!='' && !empty($accessArr))
			{
				# if PIN already exist
				if ($accessArr == COMP_AGENT){
					$this->db->where('user_id !=', $user_id);
					$this->db->where('comp_id', $this->comp_id);
			    	$this->db->where('user_pin', $user_pin);
			    	$row = $this->db->get('user_companies')->row_array();
					if (!empty($row)){
			    		$result = true;
			    	} else {
			    		$result = false;
			    	}
				}else{
					$result = false;
				}
	    	
				if ( !$result ){
					
					# if already exists
					$this->db->from('users u');
					$this->db->where('u.user_id ',$user_id);
					$return = $this->db->get('users')->row_array();

					if ( !empty($return) )
					{
						// Agent photo
						if( ($_FILES['user_photo']['error'] == 0) && sizeof($_FILES['user_photo']) > 0 )
						{						
							$extentions = array('png','jpg','jpeg','gif');
							
							$dir = USER_PHOTO;							
								
							$name = $_FILES['user_photo']['name'];
							$tmp_name = $_FILES['user_photo']['tmp_name'];
							$size = $_FILES['user_photo']['size'];
							
							$explode = explode('.', $name);
							if( in_array($explode[1], $extentions) )
							{								
								$user_photo = $this->utility_model->upload_file($explode[1], $tmp_name, $dir);							
								//unlink old photo						
								if($old_photo!=''){
									//check old file exsist
										if (file_exists(PUBPATH.$old_photo)){
											unlink(PUBPATH.$old_photo);
										}
								}
							}						
							$update_agent['photo'] = $user_photo;
						}
						
						if (!empty($post['password']))
						{
							$update_agent['password'] = md5($post['password']);
						}					
	
						# update users
						$update_agent['full_name'] 		= $user_name;
						$update_agent['user_name'] 		= $user_login;
						$update_agent['email'] 			= $user_email;
						$this->db->where('user_id', $user_id);
						$this->db->update('users', $update_agent);
	
						$update_uc['comp_id'] = $comp_id;
						$update_uc['acc_id'] = $accessArr;
						$update_uc['user_pin'] = $user_pin;
						$update_uc["transcriber"]=$transcribe;
						$this->db->where('user_id', $user_id);
						$this->db->update('user_companies', $update_uc);
						
						
						# remove existing tags
						$this->users_model->remove_tags($comp_id, $user_id);
						
						# add user_tags
						$this->users_model->add_tags($comp_id, $user_id, $tags);
						
						$this->session->set_flashdata('message', '<div id="message" class="update">Update successfully.</div>');
					} 
					else
					{
						$this->session->set_flashdata('message', '<div id="message" class="error">Already exists.</div>');
					}
					
				} else {
					$this->session->set_flashdata('message', '<div id="message" class="error">PIN already exists.</div>');
				}
			}
			else
			{
				$this->session->set_flashdata('message', '<div id="message" class="error">Some required fields are missing.</div>');
			}			
			redirect('users');
		}
		
		if ( is_numeric($user_id) ) 
		{
			$user = $this->db->query("SELECT u.user_id,u.full_name,u.user_name,u.email, uc.user_pin,u.status, u.photo, 
									GROUP_CONCAT(uc.acc_id) AS acc_id
									FROM users u LEFT JOIN user_companies uc ON u.user_id=uc.user_id
									WHERE uc.comp_id={$comp_id} AND u.user_id=".$user_id)->result();

			if (!empty($user))
			{
				$data['user'] = $user;				
			}
			else
			{
				redirect('users');
			}
			
			# Get user assigned tags
			$data['user_tags'] = $this->users_model->my_tags($user_id);
			
			# Get all Tags
			$data['tags'] = $this->tags->get_tags($comp_id);
		
			# Get all Access Levels
			$data['access_levels'] = $this->users_model->getAccessList();		
			
			$this->load->view('users/edit', $data);
		}
		else
		{
			redirect('users');
		}
	}

	/*
	 * @author:	Muhammad Sajid
	 * @name:	delete
	 */
	public function delete()
	{
		# get session variable
		//$comp_id = $this->session->userdata['comp_id'];
		
		$agent_id = $this->uri->segment(3);
		$action = $this->uri->segment(4);	
		
		if ( is_numeric($agent_id) )
		{
		
			$statusUpdate	=	0;
			$msg			= 'User Disable';
			//if status is enable 
			if($action=='enable')
			{
				$statusUpdate = 1;
				$msg			= 'User Enable';
			}
		
			$this->users_model->delete($agent_id,$statusUpdate);
			#$this->session->set_flashdata('message', "$msg successfully.");			
		} else {
			$this->session->set_flashdata('message', '<div id="message" class="error">Error while deleting.</div>');
		}
		//redirect('users');
	}

	/**
	 * @author:	Shumaila.S
	 * @modifier:	Muhammad Sajid
	 * @name:	send_email
	 */	
	public function send_email( $name='sajid', $to='sajid@nextgeni.com', $security_code='786' )
	{
		#var_debug($name .' - '. $to .' - '. $security_code);exit;
		
		$subject = 'Shoutburst - Set Password';
		$headers  = "From: Shoutburst webspot17530@gmail.com \r\n";
		//$headers .= "Bcc: sajid@nextgeni.com \r\n";
		$headers .= "Content-type: text/html\r\n";		
	
		$link = base_url().'setpassword/index/'.$security_code;
		$message = "Hi ".ucwords($name).", Your account has been created. Please set your password by clicking the following link <br /><br />".$link;
		
		if(mail($to, $subject, $message, $headers)){
			return true;
			#$this->session->set_flashdata('message', '<div style="color:green">User Added successfully<br />Send successfully.</div>');					
		}else{
			return false;
			#$this->session->set_flashdata('message', '<div style="color:red">Email sending fail.</div>');			
		}
		#redirect('users');
	}
	
	/**
	 * set password first time for user
	 */
	public function setPassword()
	{
		$post = $this->input->post();
		if(isset($post))
		{			
			$post['security_code'] = $post['code'];
			if(!empty($post['password']))
			{
				$result = $this->users_model->setPassword($post);
			
				if($result <= 0 )
				{
					$this->session->set_flashdata('message', '<div id="message" class="error below-h2"><p>Password already updated.</p></div>');
				}else 
				{
					$this->session->set_flashdata('message', '<div id="message" class="updated below-h2"><p>Password updated successfully.</p></div>');
				}
			}				
		}
		$this->load->template('users/set_password');
	}

	/**
	 * if user want to change password 
	 */
	public function settings()
	{
#		if ( isset($_POST['password']) && isset($_POST['confpassword']) && isset($this->user_id) )
		if ( isset($_POST['password']) && isset($_POST['confpassword']) && isset($_POST['epassword']) )
		{
			$post = $_POST;
			if( $post['password'] == $post['confpassword'] )
			{
				$post['user_id'] = $this->user_id;
				$result = $this->users_model->resetPassword($post);
				if($result <= 0 )
				{
					$this->session->set_flashdata('message', '<div id="message" class="error">Your existing password is incorrect</div>');
				}else
				{
					$this->session->set_flashdata('message', '<div id="message" class="update">Password updated successfully</div>');
				}				
			} else {
				$this->session->set_flashdata('message', '<div id="message" class="error">Password mismatch</div>');
			}
			redirect('users/settings');
		}
		$this->load->template('users/reset_password');
	}
	
	
	private function _getsecurityCode()
	{
		$securitycode= "";
		$length = SECURITYCODE_LENGTH;
	
		srand((double)microtime()*1000000);
	
		$data = "AbcDE123IJKLMN67QRSTUVWXYZ";
		$data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
		$data .= "0FGH45OP89";
	
		for($i = 0; $i < $length; $i++)
		{
			$securitycode .= substr($data, (rand()%(strlen($data))), 1);
		}	
	
		return md5(SALT.$securitycode);
	}
}
