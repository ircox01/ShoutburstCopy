<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(dirname(__FILE__).'/../third_party/oauth/http.php');
require(dirname(__FILE__).'/../third_party/oauth/oauth_client.php');

class oauth_client extends oauth_client_class {
	public function __construct($db_model)
	{
		$this->db_model = $db_model;
	}
		
	function StoreAccessToken($access_token)
	{
		$this->OutputDebug('StoreAccessToken');
		$sm_options = $this->db_model->getMediaOptions(Media::SURVEY_MONKEY);
		$sm_options['access_token'] = $access_token;
		$this->db_model->updateMediaOptions(Media::SURVEY_MONKEY, $sm_options);
		return true;
	}
	
	function GetAccessToken(&$access_token)
	{
		$this->OutputDebug('GetAccessToken');
		$sm_options = $this->db_model->getMediaOptions(Media::SURVEY_MONKEY);
		if (isset($sm_options['access_token'])) {
			$access_token = $sm_options['access_token'];
		} else {
			$access_token = array();
		}	
		return true;
	}
	
	function ResetAccessToken()
	{
		$this->OutputDebug('ResetAccessToken');
		$sm_options = $this->db_model->getMediaOptions(Media::SURVEY_MONKEY);
		unset($sm_options['access_token']);
		$this->db_model->updateMediaOptions(Media::SURVEY_MONKEY, $sm_options);
		return true;
	}
}

class Media_sm_model extends CI_Model {

	//const CLIENT_ID = 'alex_belonosov';
	//const CLIENT_SECRET = 'EwATT2duP2TbXpqkDkXCdp4urx9JHunj';
	//const API_KEY = 'ky3uzcwvucdpsqhmestarv8a';
	
	const CLIENT_ID = 'iancox01';
	const CLIENT_SECRET = 'p3N3xD6EQ3EsjufFJFBwxNy3QvHActV7';
	const API_KEY = 'pspxjuq6pf69xn3sfxwcmkkn';
	
	public $redirect_uri;

	public function __construct()
	{
		$this->load->model('Media_model','media');

		$this->client = new oauth_client($this->media);
		$this->client->debug = false;
		$this->client->debug_http = false;
		$this->client->server = 'SurveyMonkey';
		$this->client->configuration_file = dirname(__FILE__).'/../third_party/oauth/oauth_configuration.json';

		$this->client->client_id = self::CLIENT_ID;
		$this->client->client_secret = self::CLIENT_SECRET;
		$this->client->api_key = self::API_KEY;
	}

	public function connected() 
	{
		$this->client->GetAccessToken($access_token);
		return (isset($access_token['authorized']) && $access_token['authorized']);
	}

	public function authorize(&$access_token, &$error)
	{
		$this->client->redirect_uri = $this->redirect_uri;
		$this->client->scope = '';
		if(($success = $this->client->Initialize()))
		{
			if(($success = $this->client->Process()))
			{
				if(strlen($this->client->authorization_error))
				{
					$error = $this->client->error = $this->client->authorization_error;
					$success = false;
				}
				elseif(strlen($this->client->access_token))
				{
					$access_token = $this->client->access_token;
					$success = true;
				}
			}
			elseif(strlen($this->client->error))
			{
				$error = $this->client->error;
			}
			$this->client->Finalize($success);
		}
		if ($this->client->exit) {
			exit;
		}	
		return $success;
	}
	
	public function unauthorize()
	{
		if(($success = $this->client->Initialize()))
		{
			$success = $this->client->ResetAccessToken();
			$this->client->Finalize($success);
		}
		return $success;
	}	

	public function getSurveys()
	{
		$result = array();
		$parameters = new stdClass;
		$success = $this->client->CallAPI(
			'https://api.surveymonkey.net/v2/surveys/get_survey_list?api_key='.$this->client->api_key,
			'POST', $parameters, array('FailOnAccessError'=>true, 'RequestContentType'=>'application/json'), $surveys);
		if ($success && !$surveys->status) {
			foreach($surveys->data->surveys as $survey) {
				$parameters = new stdClass;
				$success = $this->client->CallAPI(
					'https://api.surveymonkey.net/v2/surveys/get_survey_details?api_key='.$this->client->api_key,
					'POST', $survey, array('FailOnAccessError'=>true, 'RequestContentType'=>'application/json'), $details);
				if ($success && !$details->status) {
					$item = new stdClass;
					$item->id = $survey->survey_id;
					$item->name = isset($details->data->title->text) ? $details->data->title->text : $survey->survey_id;
					$result[$item->id] = $item;
				}	
			}
		}	
		return $result;
	}	

}
