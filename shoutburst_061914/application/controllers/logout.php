<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @author: Muhammad Sajid
 * @name: Logout
 */
class Logout extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$data['title'] = TITLE.'Logout';
		$data['message'] = '';
		$this->load->vars($data);
	}

	/*
	 * @name:	index
	 * User Login screen
	 */
	public function index()
	{
		$this->utility_model->do_logout();
		
	}

	/*
	 * @name:	process
	 */
	public function process()
	{
        // Validate the user can login
        $result = $this->users_model->validate();

        // Now we verify the result
        if(! $result){
            // If user did not validate, then show them login page again
            $this->index('Access denied!<br />Invalid Email Id or Password');
        }else{
            // If user did validate,
            // Send them to members area
            redirect('welcome');
        }
    }
}