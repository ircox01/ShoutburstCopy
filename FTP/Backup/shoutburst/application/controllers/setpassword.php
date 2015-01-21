<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setpassword extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$data['title'] = TITLE;
		$data['message'] = '';
		$this->load->vars($data);
		$this->load->model('users_model');
	}
	
	/**
	 * set password first time for user
	 */
	public function index()
	{
		$post=$this->input->post();
		
		session_start();
		if(isset($post) && $post )
		{
			$post['security_code'] = $post['code'];
			if($post['password']==$post['confpassword'])
			{
				if(!empty($post['password']) && !empty($post['security_code']))
				{
					$result = $this->users_model->setPassword($post);
						
					if($result <= 0 )
					{
						$_SESSION['password_updated']=0;
						//$this->session->set_flashdata('message', '<div id="message" class="updated below-h2"><p>Password already updated.</p></div>');
						
					}else
					{
						$_SESSION['password_updated']=1;
						//$this->session->set_flashdata('message', '<div id="message" class="updated below-h2"><p>Password updated successfully.</p></div>');
					}redirect('setpassword/index');
				}
			}else 
			{
				$this->session->set_flashdata('message', '<div id="message" class="updated below-h2"><p>Password and Confirm password mismatched.</p></div>');
			}
		}
		session_destroy();
		$this->load->template('setpassword/index');
	}
	
	/**
	 * set password first time for user
	 */
	public function forgetPassword()
	{
		$post=$this->input->post();
		session_start();
		if(isset($post))
		{			
			if(!empty($post['email']))
			{
				$result =$this->users_model->verifyemail($post['email']);
				
				if($result!=0)
				{					
					$securityCode = $this->_getsecurityCode();
					if( $this->send_email($result[0]['full_name'], $post['email'] , $securityCode))
					{
						$data['user_id'] = $result[0]['user_id'];
						$data['security_code'] = $securityCode ;
						$this->users_model->resetPassword($data);
						$_SESSION['email_send']=1;
						redirect('setpassword/forgetpassword');
					}
				}
				else
				{
					$_SESSION['error']=1;
				}
			}
		}
		session_destroy();
		$this->load->template('setpassword/forgetpassword');
		
	}
	private function send_email( $name='', $to='' , $securityCode='')
	{
		$subject = 'ShoutBurst - Forget Password';
		$headers  = "From: Shout Burst webspot17530@gmail.com \r\n";	# TODO: change from with live ShoutBurst email address
		$headers .= "To: ".ucwords($name)." $to \r\n";
		//$headers .= "Bcc: sajid@nextgeni.com,s.siddiqui@nextgeni.com \r\n";
		$headers .= "Content-type: text/html\r\n";
		
		
		$link = base_url().'setpassword/index/'.$securityCode;
		$message = "Hi ".ucwords($name).", Please reset your password by clicking on the following link  <br /><br /> ". $link;
	
		/*var_debug($headers);
			var_debug($message);
		exit;*/
		if(mail($to, $subject, $message, $headers)){
			return true;
		}else{
			return false;
		}
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
?>