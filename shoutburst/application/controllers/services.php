<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Services extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		#session_start();
		define('NEW_LINE', "\r\n");	
		$this->load->model('service_model');	
		$this->load->model('surveys_model');	
			
	}
	
	public function index()
	{
		#09/04/2014 11:16:24
		
		# service call back
		/*
		 * http://localhost/shoutburst/services/?routingplan=CustSatTest&action=new&pin=1234&servicenumber=03303030133&cli=03312027007
		 * http://localhost/shoutburst/services/?max=10&action=question&q=1&answer=7&callid=46
		 * http://localhost/shoutburst/services/?time=03%2F04%2F2014+13%3A29%3A42&tree=RoutingBad&action=record&r=8&callid=169
		 */
		#var_debug($_GET);		
		ini_set("display_errors",1);
		switch ($_GET['action'])
		{
			case 'new':
				
				$date_time = date('m-d-Y h-i-s a');
				$callid = 0;
				$user_pin = addslashes($_GET['pin']);
				
				$user = $this->service_model->checkAgent( $user_pin );
												
				if ( !empty( $user ) )
				{
					# setup surveys
					$camp_id = $this->service_model->getCampID($_GET['routingplan']);
					if($camp_id!=0)
					{
						$insert_survey['camp_id']=$camp_id;
						$insert_survey['comp_id']=$user['comp_id'];
						$insert_survey['user_id']=$user['user_id'];
						$insert_survey['servicenumber'] = addslashes($_GET['servicenumber']);
			            $insert_survey['cli'] = addslashes($_GET['cli']);
			            $insert_survey['plan'] = addslashes($_GET['routingplan']);
			            $insert_survey['date_time'] = date('Y-m-d H:i:s');
			            $insert_survey['action'] = addslashes($_GET['action']);
			            if(isset($GET['NPS']) && !empty($GET['NPS'])){
			            	$insert_survey['nps_question']=($_GET['NPS'] > 0 && $_GET['NPS'] <=5 ) ? $_GET['NPS'] :  'NULL' ;
			            }else{
			            	$insert_survey['nps_question'] ='NULL';
			            }
			            
			            $insert_survey['processed'] = 0;
			            
			            $callid = $this->service_model->insertSurvey($insert_survey);
					}		
				}
				echo  $output = "<container>\n<callid>$callid</callid>\n</container>\n";
			break;
			
			case 'question':
				
				$question_number = $_GET['q'];
				$max = $_GET['max'];
				$callid = addslashes($_GET['callid']);
			        		
				$counts = $this->service_model->checkCallerID($callid);
				
				///Caller id is exists continue process
				if($counts->count>0)
				{					        		
			   	 	$row = $this->service_model->getQuestions($callid);			   		
			    	$row['q'.$question_number] = $_GET['answer'];
			    
		        	$questions_answered = 0;
		        	$total_score = 0;
		        	$average_score = 0;	        
		        
		        	for ($i = 1; $i <= count($row); $i++)
			        {			        	
			        	if(!empty($row['q'.$i])){		        	        	
						            $questions_answered++;					          
						            $total_score += $row['q'.$i];
						            $average_score = $total_score / $questions_answered;
			        	}		        	
					}
			        $score = 'q' . addslashes($question_number) . '=' . addslashes($_GET['answer']);			       	
				$max_q = ", max_q". addslashes($question_number). '=' . $_GET['max'];

			       	$result= $this->service_model->updateSurveyScore($score, $total_score , $average_score , $_GET['action'] , $callid, $max_q);			
			        echo $output = "<container>\n<ok>1</ok>\n</container>\n";
				} else {
					echo $output = "<container>\n<ok>0</ok>\n</container>\n";
				}
			break;
			
			case 'record': 
				
				#shoutburst/services/?time=09%2F04%2F2014+11%3A16%3A24&tree=RoutingBad&callid=179&r=9&action=record
						
				$time =  strtotime(urldecode($_GET['time']));							
				$timestamp = date('d/m/Y H:i:s', $time);
				$callid = intval($_GET['callid']);					
				
				$fileTime =$time ;
				
				# get routing plan
				
				$row = $this->service_model->get_routing_plan($callid);
				$routing_plan = $row['plan'];
				
				$filename = 'ICON_'.$routing_plan.'_'.$_GET['tree'].'_'.$_GET['r'].'_'.$time;				
				$tempfilename = 'ICON_'.$routing_plan.'_'.$_GET['tree'].'_'.$_GET['r'].'_'.$time;				
				$this->service_model->updateSurveyRecording($filename, "" ,$_GET['action'], $_GET['callid']);
				echo $output = "<container>\n<ok>0</ok>\n</container>\n";				
				break;
			
			default:
				$output = "<container>\n<ok>1</ok>\n</container>\n";
			break;
			
		}
	}


	public function add_survey_quickly(){
		$rows=$this->surveys_model->get_surveys();
		$sur_id=(count($rows)+5);
		$comp_id = $this->session->userdata['comp_id'];
  		$user_id = $this->session->userdata['user_id'];
		$results=$this->surveys_model->insert_survey($sur_id,$comp_id,$user_id);
		if(isset($results) && !empty($results)){
			echo "Success";
		}
		else{
			echo "Failed";
		}
		
	}
}
