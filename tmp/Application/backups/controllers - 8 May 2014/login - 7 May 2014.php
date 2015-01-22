<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @author: Muhammad Sajid
 * @name: Login
 */
class Login extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		// user validation
		if(isset($this->session->userdata['user_id']))
			redirect('welcome');
		
		$data['title'] = TITLE;
		$data['message'] = '';
		$this->load->vars($data);
	}

	/*
	 * @name:	index
	 * User Login screen
	 */
	public function index()
	{		
		if (isset($_COOKIE['autologin']))
		 {   //Checks for cookie
			$cookie = stripslashes($_COOKIE['autologin']);
			$cookie = json_decode($cookie, true);
	
			$result = $this->users_model->validate($cookie,true);
		
			// Now we verify the result
			if(isset($result) && !empty($result))
			{
				
				redirect('welcome');
			}
			
		}
			$this->load->template('login/index');	
			
	}

	/*
	 * @name:	process
	 */
	public function process()
	{
		
		$post=$_POST;
        // Validate the user can login
        $result = $this->users_model->validate($post,false);
        $rememberme = $this->input->post('rem_me');
        // Now we verify the result
        if(isset($result) && !empty($result)){
            // If user did validate,
            // Send them to members area
        	if( isset($rememberme) || ($rememberme == "on")){
        		$cookie = array(
							    'name'   => 'remember_me_token',
							    'username'  => $this->input->post('username'),
        						'password'	=> md5($this->input->post('password')),
							    'expire' => '1209600',  // Two weeks							   
								);
        		$jsonCookie=json_encode($cookie, true);
        	
				setcookie("autologin",$jsonCookie);
				
            redirect('welcome');
        }
        }else{
        	// If user did not validate, then show them login page again
			
			$err = '<div class="alert error">
					  <p class="error-message">
						<span class="icon-incorrect"></span>
						Incorrect login details.<br>
						Please try again
					  </p>
					</div>';
        	$this->session->set_flashdata('message', $err);
        	redirect(base_url());
        }
    }
}