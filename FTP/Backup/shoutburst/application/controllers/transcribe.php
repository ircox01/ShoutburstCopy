<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author:	Muhammad Sajid
 * @desc:	This is only allowed for company admin
 */
class Transcribe extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$data['title'] = TITLE.' | Transcribe';
		$this->load->vars($data);
		$this->load->model('Users_model', 'users');
		$this->load->model('Surveys_model', 'surveys');
		$this->load->model('Transcriptions_model', 'transcriptions');
		
		if( ! isset($this->session->userdata['user_id']) ) {
			redirect('login');
		} elseif( $this->session->userdata['access'] == COMP_AGENT ){
			redirect('dashboard');
		}
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	index
	 */
	public function index()
	{
		# get session variable
		$user_id = $this->session->userdata['user_id'];
		$comp_id = $this->session->userdata['comp_id'];
		$transcriber = $this->session->userdata['transcriber'];

		# Get all transcribed audios		
		$data['transcribe'] = $this->transcriptions->get_transcriptions($comp_id, $transcriber);
		$this->load->template('transcribe/index', $data);
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	add
	 * @resources:	http://jplayer.org/latest/demo-05/
	 */
	public function add()
	{
		# add resource script
		$data['extraScripts'] = transcribe_js(true);
		
		# get session variable
		$user_id = $this->session->userdata['user_id'];
		$comp_id = $this->session->userdata['comp_id'];
		
		$sur_id = $this->uri->segment(3);
		
		# save posted varaibles in array variable
		$post = $this->input->post();
		
		if (isset($post) && !empty($post))
		{
			# insert transcriptions
			$insert_transcription['sur_id'] = rtrim($post['sur_id']);
			$insert_transcription['transcriptions_text'] = rtrim($post['transcriptions_text']);
			$insert_transcription['sentiment_score'] = rtrim($post['sentiment_score']);
			$insert_transcription['gender'] = rtrim($post['gender']);
			if ( $this->transcriptions->insert_transcription($insert_transcription) > 0 ){
				$this->session->set_flashdata('message', '<div id="message" class="update">Transcription Saved</div>');				
			} else {
				$this->session->set_flashdata('message', '<div id="message" class="error">Error Occured</div>');				
			}
			redirect('transcribe');
			
		} elseif ( isset($sur_id) && !empty($sur_id) ) {
			
			$survey = $this->surveys->get_survey($sur_id);
			$data['sur_id'] = $sur_id;
			$data['recording'] = $survey[0]['recording'];
		}
		$this->load->template('transcribe/add', $data);
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	edit
	 * @resources:	http://jplayer.org/latest/demo-05/
	 */
	public function edit()
	{
		# add resource script
		$data['extraScripts'] = transcribe_js(true);
		
		# get session variable
		$comp_id = $this->session->userdata['comp_id'];
		$transcriber = $this->session->userdata['transcriber'];
		$transcription_id = $this->uri->segment(3);
		
		# save posted varaibles in array variable
		$post = $this->input->post();
		if(isset($post['empty_recording']) && !empty($post['empty_recording']))
		{
			$empty=1;
		}
		else{
			$empty=2;
		}


		if(isset($post['background_comments']) && !empty($post['background_comments']))
		{
			$bg_comments=1;
		}
		else{
			$bg_comments=2;
		}


		if (isset($post) && !empty($post))
		{
			if($empty==1){

				$sur_id = $_POST['sur_id'];
				$update_transcription['empty']=1;
				$update_transcription['transcriptions_text']='NULL';
				$update_transcription['gender']='NULL';
				$update_transcription['sentiment_score']='NULL';
				$update_transcription['background_comments']='NULL';
				$update_transcription['transcription_id'] = rtrim($post['transcription_id']);
				
				if ( $this->transcriptions->update_transcription($update_transcription)){
					$this->session->set_flashdata('message', '<div id="message" class="update">Transcription with Recording Number: '.$sur_id.' saved</div>');
				} else {
					$this->session->set_flashdata('message', '<div id="message" class="error">Error Occured</div>');
				}
	                        
                $next_id = $this->transcriptions->next_transcription($comp_id,$transcriber,$post['transcription_id']);
                
                if(!empty($next_id)){
                    redirect('transcribe/edit/'.$next_id[0]->transcription_id);
                }else{
                    redirect('transcribe');
                }

			}else if($bg_comments == 1){
				$sur_id = $_POST['sur_id'];
				$update_transcription['empty']='NULL';
				$update_transcription['transcriptions_text']=rtrim($post['transcriptions_text']);
				$update_transcription['gender']='NULL';
				$update_transcription['sentiment_score']='NULL';
				$update_transcription['background_comments']=1;
				$update_transcription['transcription_id'] = rtrim($post['transcription_id']);
				
				if ( $this->transcriptions->update_transcription($update_transcription)){
					$this->session->set_flashdata('message', '<div id="message" class="update">Transcription with Recording Number: '.$sur_id.' saved</div>');
				} else {
					$this->session->set_flashdata('message', '<div id="message" class="error">Error Occured</div>');
				}
	                        
                $next_id = $this->transcriptions->next_transcription($comp_id,$transcriber,$post['transcription_id']);
                
                if(!empty($next_id)){
                    redirect('transcribe/edit/'.$next_id[0]->transcription_id);
                }else{
                    redirect('transcribe');
                }
			}
			else{
				# Update transcription
				$sur_id = $_POST['sur_id'];
				$update_transcription['transcription_id'] = rtrim($post['transcription_id']);
				$update_transcription['transcriptions_text'] = rtrim($post['transcriptions_text']);
				$update_transcription['sentiment_score'] = rtrim($post['sentiment_score']);
				$update_transcription['gender'] = rtrim($post['gender']);
				
				if ( $this->transcriptions->update_transcription($update_transcription) ){
					$this->session->set_flashdata('message', '<div id="message" class="update">Transcription with Recording Number: '.$sur_id.' saved</div>');
				} else {
					$this->session->set_flashdata('message', '<div id="message" class="error">Error Occured</div>');
				}
	                        
                $next_id = $this->transcriptions->next_transcription($comp_id,$transcriber,$post['transcription_id']);
                
                if(!empty($next_id)){
                    redirect('transcribe/edit/'.$next_id[0]->transcription_id);
                }else{
                    redirect('transcribe');
                }
				// $next_transcription = ($post['transcription_id']+1);
				//redirect('transcribe/edit/'.$next_transcription);

            }
		}
		
		if ( is_numeric($transcription_id) ) {
			
			$data['transcription'] = $this->transcriptions->get_transcription($transcription_id, $comp_id, $transcriber);
			if (!empty($data['transcription'])){
				$this->load->template('transcribe/edit', $data);
			} else {
				redirect('transcribe');
			}
			
		} else {
			redirect('transcribe');
		}
	}
        
        public function end()
        {
            # get session variable
            $comp_id = $this->session->userdata['comp_id'];
            $transcriber = $this->session->userdata['transcriber'];
            
            # save posted varaibles in array variable
            $post = $this->input->post();
            
            if (isset($post) && !empty($post))
		{
			# Update transcription
			$sur_id = $_POST['sur_id'];
			$update_transcription['transcription_id'] = rtrim($post['transcription_id']);
			$update_transcription['transcriptions_text'] = rtrim($post['transcriptions_text']);
			$update_transcription['sentiment_score'] = rtrim($post['sentiment_score']);
			$update_transcription['gender'] = rtrim($post['gender']);
			
			if ( $this->transcriptions->update_transcription($update_transcription) ){
				$this->session->set_flashdata('message', '<div id="message" class="update">Transcription with Recording Number: '.$sur_id.' saved</div>');
			} else {
				$this->session->set_flashdata('message', '<div id="message" class="error">Error Occured</div>');
			}
			redirect('transcribe');
		}
        }


}