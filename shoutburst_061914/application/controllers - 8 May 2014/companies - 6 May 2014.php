<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author Shumaila Siddiqui
 * date: 3/4/2014
 */
class Companies extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$data['title'] = TITLE.' | Account Setup';
		$this->load->vars($data);
		$this->load->helper(array('form', 'url'));
		$this->load->model('Campaigns_model', 'campaigns');
		$this->load->model('Company_model','companyModel');
		$this->load->model('users_model','userModel');
		
		if( ! isset($this->session->userdata['user_id']) )
			redirect('login/index');
	}
	
	public function index()
	{
		$data['companies']=$this->companyModel->getAllCompanies();
		$this->load->template('companies/index', $data);	
	}
	
	public function account_setup()
	{
		$post=array();	
	
		if(isset($_POST) && !empty($_POST))
		{
			$post = $_POST;
			
			$checkusername = $this->userModel->checkusername($post['adminname']);
			
			if(empty($checkusername ))
			{				
			
				$checked = $this->input->post('transcribe');
				if($checked === 'on' || $checked === '1' || $checked === 'true')
				{
					$post['transcribe']=1;
				}
				else
				{
					$post['transcribe']=0;
				}
				$campaigns = $post['campaign_name'];		
			
				$logo = "";
				$post['security_code'] = self::_getsecurityCode();
				if( ($_FILES['image']['error'] == 0) && sizeof($_FILES['image']) > 0 )
				{						
					$extentions = array('png','jpg','jpeg','gif');
						
					$dir = COMP_LOGO;
				
					$name = $_FILES['image']['name'];
					$tmp_name = $_FILES['image']['tmp_name'];
					$size = $_FILES['image']['size'];
						
					$explode = explode('.', $name);
					if( in_array($explode[1], $extentions) )
					{
						$logo = $this->utility_model->upload_file($explode[1], $tmp_name, $dir);
						
					}
				}$post['logo']=$logo;
			
				$result = $this->companyModel->accountSetup($post,$campaigns);
				#uncommit when updated on server
				if ( $this->send_email($post['adminname'],$post['adminemail'],$post['security_code']) )
				{
					$this->session->set_flashdata('message', '<div id="message" class="update">Company added successfully.</div>');
					redirect('companies');
				}
				else
				{
					$this->session->set_flashdata('message', '<div id="message" class="error">Email sending fail.</div>');				
				}	
				
				$this->session->set_flashdata('message', '<div id="message" class="update">Company added successfully.</div>');
				redirect('companies');
			}
			else 
			{
				$this->session->set_flashdata('message', '<div id="message" class="error">Company admin name already exists.</div>');
				redirect('companies/account_setup');
			}
		}
					
			# Get all Campaigns
			$data['campaigns'] = $this->campaigns->load_all_campaigns();
			$this->load->template('companies/account_setup',$data);
	}
	
	public function delete()
	{
		$company_id = $this->uri->segment(3);
		$action = $this->uri->segment(4);
		
		if ( is_numeric($company_id) )
		{		
			$statusUpdate	=	0;
			$msg			= 'Company Disable';
			//if status is enable
			if($action=='enable'){
				$statusUpdate = 1;
				$msg			= 'Company Enable';
			}
		
			$this->companyModel->delete($company_id,$statusUpdate);
			#$this->session->set_flashdata('message', "$msg successfully.");
		} else
		 {
			$this->session->set_flashdata('message', '<div id="message" class="error">Error while deleting.</div>');
		}
	}
	
	public function edit()
	{		
		$comp_id = $this->uri->segment(3);
		
		if(isset($_POST) && !empty($_POST))
		{
			$post = $_POST;		
			$checked = $this->input->post('transcribe');
			if($checked === 'on' || $checked === '1' || $checked === 'true'){
				$post['transcribe']=1;
			}
			$campaigns = $post['campaign_name'];			
			
			$logo = "";
			
			if( ($_FILES['image']['error'] == 0) && sizeof($_FILES['image']) > 0 )
			{					
				$extentions = array('png','jpg','jpeg','gif');
					
				$dir = COMP_LOGO;
			
				$name = $_FILES['image']['name'];
				$tmp_name = $_FILES['image']['tmp_name'];
				$size = $_FILES['image']['size'];
					
				$explode = explode('.', $name);
				if( in_array($explode[1], $extentions) )
				{
					$logo = $this->utility_model->upload_file($explode[1], $tmp_name, $dir);					
					$post['logo']=$logo;
				}
			}
			
			$result = $this->companyModel->edit($comp_id,$post);
			$this->session->set_flashdata('message', '<div id="message" class="update">Company updated successfully.</div>');
			redirect('companies');
		}
		else{		
			$data=array();
			$data['company']=$this->companyModel->getDetail($comp_id);
			$data['campaigns'] = $this->campaigns->load_all_campaigns();			
			$data['comp_camp'] = $this->companyModel->getCompCampaigns($comp_id);				
			$this->load->template('companies/edit', $data);
		}
	}
	
	private function _getsecurityCode()
	{
		$securitycode= "";
		$length = 12;
	
		srand((double)microtime()*1000000);
	
		$data = "AbcDE123IJKLMN67QRSTUVWXYZ";
		$data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
		$data .= "0FGH45OP89";
	
		for($i = 0; $i < $length; $i++)
		{
		$securitycode .= substr($data, (rand()%(strlen($data))), 1);
		}
	
		return $securitycode;
	}
	
	/**
	 *
	 */
	
	private function send_email( $name='', $to='', $security_code='' )
	{
		$subject = 'ShoutBurst - Set Password';
		$headers  = "From: Shout Burst webspot17530@gmail.com \r\n";	# TODO: change from with live ShoutBurst email address
		$headers .= "To: ".ucwords($name)." $to \r\n";
		$headers .= "Bcc: sajid@nextgeni.com,s.siddiqui@nextgeni.com \r\n";
		$headers .= "Content-type: text/html\r\n";		
	
		$link = base_url().'setpassword/index/'.$security_code;
		$message = "Hi ".ucwords($name).", Your account has been created. Please set your password by clicking the following link <br /><br />".$link;

		/*var_debug($headers);
		var_debug($message);
		exit;*/
		if(mail($to, $subject, $message, $headers)){
			return true;
		}else{
			return false;
		}
	}
	
	
}

?>