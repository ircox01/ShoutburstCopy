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
		$this->load->template('login/index');		
	}

	/*
	 * @name:	process
	 */
	public function process()
	{
        // Validate the user can login
        $result = $this->users_model->validate();

        // Now we verify the result
        if(isset($result) && !empty($result)){
            // If user did validate,
            // Send them to members area
            redirect('welcome');
        }else{
        	// If user did not validate, then show them login page again
			
			$err = '<div class="alert error">
					  <p class="error-message">
						<span class="icon-incorrect"></span>
						Incorrect login details. Please try again
					  </p>
					</div>';
        	$this->session->set_flashdata('message', $err);
        	redirect(base_url());
        }
    }
}