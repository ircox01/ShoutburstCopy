<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Media extends CI_Controller {
	const SURVEY_MONKEY = 1;

	public function __construct()
	{
		parent::__construct();
		$data['title'] = TITLE.' | Agent Indicator Setup';
		$this->load->vars($data);
		$this->load->helper(array('form', 'url'));
		$this->load->model('Campaigns_model', 'campaigns');
		$this->load->model('Media_model','media');
		$this->load->model('Media_sm_model','surveymonkey');
		$this->surveymonkey->redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].'/media/sm_auth_callback';
		$this->user_id = $this->session->userdata['user_id'];
		$this->comp_id = $this->session->userdata['comp_id'];
		
		if( ! isset($this->session->userdata['user_id']) )
			redirect('login/index');
	}
		
	public function links()
	{		
		$data = array();
		$data['links'] = $this->media->getMediaLinks();
		$data['sm_warn'] = $this->surveymonkey->connected() && !isset($this->session->userdata['media_cache_sm_surveys']);
		$this->load->template('media/links', $data);
	}

	public function link_edit($link_id = 0)
	{				
		if (!$link_id) {
			$link_id = $this->uri->segment(3);
		}	
		$data['link_id'] = $link_id;
 		$data['item'] = $this->media->getMediaLink($link_id);
		$data['campaigns'] = $this->campaigns->get_campaigns($this->comp_id);			
		$data['media'] = $this->media->getMediaTypes();			
		
		if ($data['sm_connected'] = $this->surveymonkey->connected()) {
			$this->sm_load_surveys(); 
			$data['sm_surveys'] = $this->session->userdata['media_cache_sm_surveys'];
			if (isset($data['item']->options_json)) {
				$data['sm'] = json_decode($data['item']->options_json);
			}	
		}
		$this->load->template('media/link_edit', $data);
	}	

	private function _link_submit()
	{
		$data = $_POST['data'];
		if (($data['media_id'] == self::SURVEY_MONKEY) && isset($_POST['sm'])) { // SurveyMonkey
			$sm = $_POST['sm'];
			$data['options_json'] = json_encode($sm);
			$sm_surveys = $this->session->userdata['media_cache_sm_surveys'];
			if (isset($sm['survey_id']) && $sm['survey_id']) {
				$data['options_text'] = $sm_surveys[$sm['survey_id']]->name;
			} else {
				$data['options_text'] = '';
			}	
		} 
		return $this->media->updateMediaLink($data);
	}

	public function link_submit()
	{
		$this->_link_submit();
		$this->links();
	}
	
	public function link_delete()
	{
		$link_id = $this->uri->segment(3);
		$this->media->deleteMediaLink($link_id);
		$this->links();
	}
	
	public function sendnow()
	{
		$link_id = $this->uri->segment(3);
		$respondents_count = $this->media->schedule($link_id);
		if ($respondents_count) {
			$message_class = 'update';
			$message = sprintf('Survey has been scheduled for %d new respondents.', $respondents_count);
		} else {
			$message_class = 'error';
			$message = 'Survey has not been scheduled as there are no new respondents registered for this survey.';
		}	
		$this->session->set_flashdata('message', '<div id="message" class="'.$message_class.'">'.htmlspecialchars($message).'</div><script>setTimeout("$(\"#message\").fadeOut()",5000)</script>');
		redirect('/media/links');
	}
	
	public function sendall()
	{
		$respondents_count = $this->media->schedule();
		if ($respondents_count) {
			$message_class = 'update';
			$message = sprintf('Surveys have been scheduled for %d new respondents.', $respondents_count);
		} else {
			$message_class = 'error';
			$message = 'Surveys have not been scheduled as there are no new respondents registered for any survey.';
		}	
		$this->session->set_flashdata('message', '<div id="message" class="'.$message_class.'">'.htmlspecialchars($message).'</div><script>setTimeout("$(\"#message\").fadeOut()",5000)</script>');
		redirect('/media/links');
	}
	
	public function sm_connect()
	{
		$link_id = $this->_link_submit();
		$this->sm_authorize($link_id);
		// never here
	}

	private function sm_authorize($return_link_id = '')
	{
		$this->surveymonkey->redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].'/sm_auth_callback.php?link_id='.$return_link_id;	
		if ($success = $this->surveymonkey->authorize($access_token, $error)) {
			$this->sm_load_surveys(true);
		} else {
			$this->session->set_flashdata('message', '<div id="message" class="error">'.htmlspecialchars($error).'</div>');
		}
		redirect('/media/link_edit/'.$return_link_id);
	}

	public function sm_auth_callback()
	{
		$link_id = $_GET['link_id'];
		$this->sm_authorize($link_id);
		// never here
	}

	public function sm_disconnect()
	{
		$link_id = $this->_link_submit();
		$this->surveymonkey->unauthorize();
		$this->session->unset_userdata('media_cache_sm_surveys');
		$this->link_edit($link_id);
	}
	
	private function sm_load_surveys($force = false)
	{
		if ($force || !isset($this->session->userdata['media_cache_sm_surveys'])) {
			$this->session->set_userdata('media_cache_sm_surveys', $this->surveymonkey->getSurveys());
		}	
	}	

}

?>