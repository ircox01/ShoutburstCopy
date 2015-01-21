<?php

$script_location = dirname(__FILE__);
require_once($script_location . DIRECTORY_SEPARATOR . 'mycurl.php');
require_once($script_location . DIRECTORY_SEPARATOR . 'SFTPConnection.php');
require_once($script_location . DIRECTORY_SEPARATOR . 'phpMailer/class.phpmailer.php');
// Setting max execution time to 10 minutes
ini_set('max_execution_time', 600);

class CallManagerRecordScraperException extends Exception {
    public function __toString() {
        return "Error while scraping record from Call Manager: [{$this->code}]. {$this->message}\n";
    }
}

class CallManagerRecordScraper {
    // TODO : make a recursive mkdir for downloads dir

    // Names for login form fields
    protected $login_input_name = 'j_username';
    protected $pass_input_name = 'j_password';

    // Login and password for Call Manager
    protected $login = 'ptenhanced';
    protected $pass = 'ptadmin#';

    protected $last_login_file = 'cm_login';

	protected $file_path = "";
    // Url to Call Manager
    protected $url = 'https://www.callmanager.virginmediabusiness.co.uk/effectiveL/';
    
    // Relative pathes to login page and page where can find list of records 
    protected $login_page = 'j_acegi_security_check';
    protected $record_list_page = 'resources.recordings.form';

    protected $record_file_download_form_action = 'resources.recordings.form';

    // Get request to page with list records to change a page
    // %page% - replace this with page number - 1
    protected $page_get_request = '?page[%page%]&formname=icon';

    // Temporary directory to store downloaded record
    protected $tmp_wav_dir = 'cmaudiofiles';

    // Date search criteria
    protected $search_date = '';

    // Cli search criteria
    protected $search_cli = '';

    // Plan search criteria
    protected $search_plan = '';

    // Stores data from last search
    protected $last_search = array( 'data' => array (
                                        'RoutePlan' => '',
                                        'file_name' => '',
                                        'duration' => '',
                                        'CLI' => '',
                                        'Time/Date' => ''
                                        ),
                                    'file' => ''
                                );

    protected $curl_object;

    protected $load_cookies = FALSE;

    /** __construct
     *  
     *  Passing all parameters to constructor
     *
     *  @returns null
     */
    public function __construct( $search_cli, 
                          $search_date,
                          $search_plan,
                          $tmp_wav_dir = '',
                          $url = '', 
                          $login = '', 
                          $pass = '', 
                          $login_page = '', 
                          $record_list_page = '', 
                          $record_file_download_form_action = '',
                          $page_get_request = '') 
    {
        $this->search_cli = $search_cli;
        $this->search_date = $search_date;
        $this->search_plan = $search_plan;
        
    	if (!empty($url)) {
            $this->url = $url;
        }

        if (!empty($login)) {
            $this->login = $login;
        }
        $last_login = file_get_contents($this->last_login_file);
        if ($last_login == $login) {
            $this->load_cookies = TRUE;
        }

        if (!empty($pass)) {
            $this->pass = $pass;
        }

        if (!empty($login_page)) {
            $this->login_page = $login_page;
        }

        if (!empty($record_list_page)) {
            $this->record_list_page = $record_list_page;
        }

        if (!empty($record_file_download_form_action)) {
            $this->record_file_download_form_action = $record_file_download_form_action;
        }

        if (!empty($tmp_wav_dir)) {
            $this->tmp_wav_dir = $tmp_wav_dir;
        }

        if (!empty($page_get_request)) {
            $this->page_get_request = $page_get_request;
        }

        $this->curl_object = new Mycurl($this->url, TRUE, 30, 10, FALSE, TRUE, FALSE, $this->load_cookies);
    }

    /**
     * log_in 
     * 
     * Loging in to Call Manager
     * If loging failure returns array with 'error' element
     * Else without it
     * 
     * @access public
     * @return array
     */
    public function log_in() {
        $url = $this->url.$this->login_page;
        $post_array = array(
                            $this->login_input_name => $this->login,
                            $this->pass_input_name => $this->pass
                        );
        $post_str = $this->login_input_name.'='.$this->login.'&'.$this->pass_input_name.'='.$this->pass;

        if (!$this->curl_object) {
            $this->curl_object = new Mycurl($this->url, TRUE, 30, 10, FALSE, TRUE, FALSE, $this->load_cookies);
        }

        $this->curl_object->setPost($post_str);
        $this->curl_object->createCurl($url);
		
        $result = array(
                        'url' => $url,
                        'status' => $this->curl_object->getHttpStatus(),
                        'page' => $this->curl_object->__tostring(),
                        'cookie' => $this->curl_object->getCookie(),
                        'last_url' => $this->curl_object->getLastEffectiveUrl()
                    );
        if (preg_match("/login_error=1/si", $result['last_url'])) {
            $result['error'] = 'Login failure';
        }
        if ($result['status'] != '200') {
            if ($result['status'] >= 400) {
                $result['error'] = 'Wrong login page (page not found)';
            }
            else if ($result['status'] >= 300) {
                if (preg_match("/login_error=1/si", $result['page'])) {
                    $result['error'] = 'Login failure';
                }
            }
        }
        file_put_contents($this->last_login_file, $this->login);

        return $result;
    }
	
	public function getRecordingEmails($dbUser, $dbPassword, $dbName, $host, $companyId)
	{
		
		//get list of recording email that has status 0,meaning email not sent
		
		//:connect to database		
		$link = mysql_connect($host, $dbUser, $dbPassword);
		if (!$link) {
			die('Not connected : ' . mysql_error());
		}

		// make foo the current db
		$db_selected = mysql_select_db($dbName, $link);
		if (!$db_selected) {
			die ("Can\'t use $dbName : " . mysql_error());
		}
		
		//get list of recording email that has status = 0 and company is with the user
		$query = "SELECT `recording_emails`.*,`recordings`.`name`,`recordings`.`cli`,`recordings`.`routing_plan`,`recordings`.`company_id` FROM `recording_emails` INNER JOIN `recordings`
					ON `recording_emails`.`recording_id` = `recordings`.`id` WHERE `recordings`.`company_id` = $companyId AND `recording_emails`.`status` = 0";
		$result = mysql_query($query) 	;
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		}
		
		$userData = '';
		while ($row = mysql_fetch_assoc($result)) {
			
			$filename = $row['name'];
			$status = $this->get_file($filename);
			if($status == 200) {
				//send email
				$stat = $this->sendEmail($row);
				if(!$stat) {
					echo "not sent to recording ".$row['id'];
				} else {
					//change status to this particular recording
					$this->updateRecordingEmailStatus($row['id']);				
				}
			} else {
				echo " error on getting the file : $filename \r\n";
			}
			//$data['file'] = $file;								
		}
		
		while ($row = mysql_fetch_assoc($result)) {
			$filename = $row['name'];
			$status = $this->get_file($filename);
			if($status == 200) {
				//send email
				$stat = $this->sendEmail($row);
				if(!$stat) {
					echo "not sent to recording ".$row['id'];
				} else {
					//change status to this particular recording
					$this->updateRecordingEmailStatus($row['id']);				
				}
			} else {
				echo " error on getting the file : $filename \r\n";
			}
			//$data['file'] = $file;								
		}
		
	}
	
	protected function get_file($filename) {
        $url = $this->url.$this->record_file_download_form_action;
        $post_array = array(
                            $filename => '1'
                        );
        $post_str = $filename.'=1';
		
        if (!$this->curl_object) {
            $this->curl_object = new Mycurl($this->url, TRUE, 30, 10, FALSE, TRUE, FALSE, $this->load_cookies);
        }
		
        $this->curl_object->setHeader(FALSE);
		$this->curl_object->setPost($post_str);
        $file = dirname(__FILE__) . DIRECTORY_SEPARATOR . "storeaudio". DIRECTORY_SEPARATOR . $filename;
		
        $filepath = $file;
        $file = fopen($file.".wav", 'wb');
		
        if (!$file) {
            echo "Can't write to file \"$filepath\"";
			return 302;			
        }
        $this->curl_object->setFile($file);
        $this->curl_object->createCurl($url);
        fclose($file);
        $this->curl_object->setHeader(TRUE);
		
		return $this->curl_object->getHttpStatus();
    }
	
	public function sendEmail(array $details)
	{
	
		$mail = new PHPMailer();
		$mail->From      = 'you@example.com';
		$mail->FromName  = 'Your Name';
		$mail->Subject   = $details['email_header'];
		$mail->Body      = $details['email_message'];
		
		$emails = json_decode($details['email_adds']);
		foreach($emails as $email)
		{
		   $mail->AddAddress($email, '');
		}
		
		//$emails = implode(',',$emails);
		
		$file_to_attach = dirname(__FILE__) . DIRECTORY_SEPARATOR . "storeaudio". DIRECTORY_SEPARATOR . $details['name'].".wav";
		
		$mail->AddAttachment( $file_to_attach , $details['name'].".wav" );

		return $mail->Send();
	}
	
	public function updateRecordingEmailStatus($recordingEmailId)
	{
		$query = "UPDATE recording_emails SET status = 1 WHERE id = $recordingEmailId";		
		$result = mysql_query($query);
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		}
	}

	public function sendMail($to,$subject,$message) {
		$headers = 'From: alniejacobe@gmail.com' . "\r\n" .
			'Reply-To: alniejacobe@gmail.com' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		 
		if(mail($to, $subject, $message, $headers)) {
			return true;
		} else {
			echo('Failure: Email was not sent!');
			exit;
		}
	}
	
    public function search($dbUser, $dbPassword, $dbName, $host, $companyId) {
	
	    $url = $this->url.$this->record_list_page;
		
        if (!$this->curl_object) {
            $this->curl_object = new Mycurl($url, TRUE, 30, 10, FALSE, TRUE, FALSE, $this->load_cookies);
        }
		
        $this->curl_object->unsetPost();
        $this->curl_object->unsetFile();
        $this->curl_object->createCurl($url);

        $result = array(
                        'url' => $url,
                        'status' => $this->curl_object->getHttpStatus(),
                        'page' => $this->curl_object->__tostring(),
                        'cookie' => $this->curl_object->getCookie()
                    );

        $page = $result['page'];
			
        $table = $this->grab_records_table($page);
        
        if (!$table) {
            $this->log_in();
        }

        $this->curl_object->unsetPost();
        $this->curl_object->unsetFile();
        $this->curl_object->createCurl($url);
		
        $result = array(
                        'url' => $url,
                        'status' => $this->curl_object->getHttpStatus(),
                        'page' => $this->curl_object->__tostring(),
                        'cookie' => $this->curl_object->getCookie()
                    );

        $page = $result['page'];
		$test = array();
        $table = $this->grab_records_table($page);
		
        if (!$table) {
            $data['error'] = 'Error scraping data. List of records not found';
            return $data;
        }
		
		$recordList = $this->getRecordingList($table);
		if (!$recordList) {
            $data['error'] = 'Error scraping data. List of records not found';
            return $data;
        }
		
		//save all scrape data to scraped_recording table
		//connect to db			
		$link = mysql_connect($host, $dbUser, $dbPassword);
		if (!$link) {
			die('Not connected : ' . mysql_error());
		}

		// make voicesolution the current db
		$db_selected = mysql_select_db($dbName, $link);
		if (!$db_selected) {
			die ("Can\'t use $dbName : " . mysql_error());
		}

		//$oldScrapedRecordings = $this->getAllScrapedRecording();
		
		//create query,set default company_id determined from users logged in
		$i = 1;		
		$subQuery = '';
		
		while ($i < count($recordList[0])) {
			
			$data = $this->scrape_data($recordList[0][$i]);
			if($data['Filename']!= '') {
				$subQuery .= "('". $data['Filename'] ."', '". $companyId ."', '". $data['CLI'] ."', '". $data['plan'] ."', '". $data['Record Time'] ."', '". $data['Duration']. "','".$data['Size']. "', 0),";
			}
			$i++;
		}
		
		//concat subquery and masterquery not in old scraped_recording data
		$subQuery = substr($subQuery, 0 , -1) . " ON DUPLICATE KEY UPDATE status=1";;
		$sqlQuery = "INSERT INTO scraped_recordings (name, company_id, cli, routing_plan, record_time, duration, size, status) VALUES $subQuery";
		
		//flush all data to db
		$result = mysql_query($sqlQuery);
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		}
		
		return true;
		
    }
	protected function getAllScrapedRecording()
	{
		//get all scraped_recording data for reference
		//get all users now that is not admin
		$query = "SELECT *from scraped_recordings WHERE status = 0";
		$result = mysql_query($query);
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		}
		$scrapedRecordingsArray = array();
		while ($row = mysql_fetch_assoc($result)) {
			$scrapedRecordingsArray[] = $row['name'];			
		}
		
		return $scrapedRecordingsArray;
	}
	
	protected function getRecordingList($table) 
	{
		if(preg_match_all('/<tr.*?>.*?<\/[\s]*tr>/si',$table, $recordList)) {
			return $recordList;
		} else {
			return FALSE;
		}
	}

    protected function grab_records_table($page) {
        $result = array();
        // Picking out table that lists records by its header row
		//if (preg_match_all('/<table>.*?<th>Routing Plan<\/th>.*?<th>CLI<\/th>.*?<\/tr>(.*?)<\/table>/s', $page, $result)) {
		
		if (preg_match_all('/<table.*?>.*?<\/[\s]*table>/si', $page, $result)) {				
		
			return $result[0][4];			
        }
        else {
            return FALSE;
        }
    }

	protected function findRecordingFile($plan, $cli)
	{
		$result = array();
		if(found) {
		
		}else {
		
		}		
	}
	
    protected function find_row($table, $cli, $plan = FALSE) {
        $result = array();
        // Searching first row that matches by cli
        if ($cli) {
            if (preg_match("/<tr>(.*?<td.*?>(.*?$cli.*?)<\/td>.*?)<\/tr>/si", $table, $result)) {
                return $result[1];
            }
            else {
                return FALSE;
            }
        }
        // Searching for row that matches plan
        else if ($plan) {
            if (preg_match("/<tr>(.*?<td.*?>(.*?$plan.*?)<\/td>.*?)<\/tr>/si", $table, $result)) {
                return $result[1];
            }
            else {
                return FALSE;
            }
        }
        else {
            return FALSE;
        }
    }

    protected function scrape_data($row) {
        $result = array();
        if (preg_match_all("/<td.*?>(.*?)<\/td>/si", $row, $result)) {
            $temp = array();
            $input_name = '';
            if (preg_match("/name=\"(.*?)\"/si", $result[1][6], $temp)) {
                $input_name = $temp[1];
            }

            $data = array (
				'plan' => trim($result[1][0]),
				'Filename' => trim($result[1][1]),
				'CLI' => trim($result[1][2]),
				'Record Time' => trim($result[1][3]),
				'Duration' => trim($result[1][4]),
				'Size' => trim($result[1][5])
			);
			//var_dump($data);exit;
            $file = $this->get_file($input_name, $data['Filename']);

            $data['file'] = $file;

            return $data;
        }
        else {
            return FALSE;
        }
    }

    protected function get_page($page) {
        $get_request = $this->page_get_request;

        $page--;

        $get_request = preg_replace("/(%page%)/si", $page, $get_request);

        $url = $this->url.$this->record_list_page.$get_request;
        $this->curl_object->unsetPost();
        $this->curl_object->unsetFile();
        $this->curl_object->createCurl($url);

        $page = $this->curl_object->__tostring();

        return $page;
    }

    
}
