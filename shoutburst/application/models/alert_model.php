<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alert_model extends CI_Model {

	public function __construct() {

	}
	
	public function addAlert( $post = array(), $createdBy ='' , $comp_id='' ) {
		$data = array(
            'alert_name'		=>	$post['alert_name'],
            'send_email'		=>	($post['send_email']=="on") ? 1 : 0,
            'send_sms'			=>	($post['send_sms']=="on") ? 1 : 0,
            'email_addresses'	=>	$post['email_address'],
            'sms_numbers'		=>	$post['sms'],
            'filter_conditions' =>  $this->resetFilter($post['filters1']),
            'alert_period'		=>  $post['period'],
            'created_on'		=>	date('Y-m-d h:i:s a', time()),
            'created_by'		=>	$createdBy,
            'status'			=>  0,
            'comp_id'			=>  $comp_id
        );
		
		$this->db->insert("alerts", $data);
	}
	
	public function getAlerts($comp_id = '') {
		$result = $this->db->query("SELECT a.alert_id, a.alert_name, a.status, DATE_FORMAT(a.created_on,'%Y-%m-%d %H:%i') as createdon, u.full_name,a.filter_conditions FROM alerts a JOIN users u ON a.created_by=u.user_id WHERE comp_id=$comp_id ORDER BY createdon DESC ")->result_array();
		return $result;
	}

    public function getHourly() {
        return  $this->db->query("SELECT * FROM alerts WHERE alert_period='lasthour'")->result_array();
    }

    public  function  getDaily() {
        return $this->db->query("SELECT * FROM alerts WHERE alert_period='todate'")->result_array();
    }

    public function getEveryCall() {
        return $this->db->query("SELECT * FROM alerts WHERE alert_period='everycall'")->result_array();
    }

    public function process($alert_id) {
        $alert = $this->db->query("SELECT * FROM alerts WHERE alert_id = " . $this->db->escape($alert_id))->result_array();
        echo "Processing {$alert[0]['alert_period']} Alert {$alert[0]['alert_name']} {$alert[0]['filter_conditions']} \n\r";
        $filters = explode(',',$alert[0]['filter_conditions']);
        $the_filters = array();
        $evil = "";
        $where_comp = "comp_id = " . $this->db->escape($alert[0]['comp_id']);
        $where_period = 'date_time > 0';
        $where_id = 'sur_id > 0';
        $date = new DateTime();

        switch ($alert[0]['alert_period']) {
            case 'lasthour':
                $date->modify('-1 hour');
                $where_period = 'date_time > ' . $this->db->escape($date->format('Y-m-d H:i:s'));
                break;
            case 'todate':
                $date->modify('-1 day');
                $where_period = 'date_time > ' . $this->db->escape($date->format('Y-m-d H:i:s'));
                break;
            case 'everycall':
                $where_id = 'sur_id = '.$this->db->escape($this->db->insert_id());
                break;
        }

        foreach ($filters as $filterPos => &$filter) {
            $filter = trim($filter);
            preg_match_all('/(Or)?(And)?(.*)\h?([<,>,=])\h?([0-9]*)/i', $filter, $conditions, PREG_SET_ORDER);
            $flags = array('Word','Filter','Operator','Value');
            $res = array();
            if ($filterPos == 0 ) {
                array_splice($flags,0,1);
                $res['Word'] = '';
            }
            $i=0;
            foreach ($conditions[0] as $key=>$condition) {
                if ($condition != '' && $key != 0) {
                    $res[$flags[$i]] = trim($condition);
                    $i++;
                }
            }
            if ($res['Operator'] == '=') {
                $res ['phpOperator'] = '==';
            }

            /** Now Prepare Where Cond */
            $filter = explode(':', $res['Filter']);
            switch (trim($filter[0])) {
                case 'total score':
                    $where = " total_score {$res['Operator']} " . $this->db->escape($res['Value']);
                    $sql = "SELECT * FROM surveys WHERE ($where_period) AND ($where_comp) AND ($where) AND ($where_id)";
                    //echo "$sql \r\n";
                    $rows = $this->db->query($sql)->num_rows();
                    $res['Rows'] = $rows;
                    break;
                case 'question score':
                    $filter[1] = isset($filter[1]) ? trim($filter[1]) : '';
                    if ($filter[1] == '') {
                        $temp = array();
                        for ($i = 1; $i < 6; $i++) {
                            $temp[] = "q$i {$res['Operator']} " . $this->db->escape($res['Value']);
                        }
                        $where = implode(' OR ', $temp);
                        $rows = $this->db->query("SELECT * FROM surveys WHERE ($where_period) AND ($where_comp) AND ($where) AND ($where_id)")->num_rows();
                        //echo "Question Score result $rows \n\r";
                        $res['Rows'] = $rows;
                    } else {
                        $rows = $this->db->query("SELECT * FROM surveys WHERE ($where_period) AND ($where_comp) AND ($where_id) AND ({$filter[1]} {$res['Operator']} {$res['Value']})")->num_rows();
                        $res['Rows'] = $rows;
                    }
                    break;
                case 'total surveys':
                    $sql = "SELECT * FROM surveys WHERE ($where_period) AND ($where_comp)";
                    $rows = $this->db->query($sql)->num_rows();
                    $operator = isset($res['phpOperator']) ? $res['phpOperator'] : $res['Operator'];
                    $eval_str = '$res[\'Rows\'] = ' . "($rows $operator {$res['Value']})?1:0;";
                    eval ($eval_str);
                    break;
            }
            $the_filters[] = $res;
            $evil .= " {$res['Word']} {$res['Rows']} ";
        }
        $ev = false;

        /** I apologize for this but not I started this... */
        eval ('$ev = ' . "($evil);");
        //echo ($ev ? 'true' : 'false') . " = ($evil) \n\r";

        if ($ev) {
            /** Processing this alert */
            echo "Alert conditions are true!\n\r";

            if ($alert[0]['send_email']=='1' && $alert[0]['email_addresses']) {
                echo "Sending alert to Emails: {$alert[0]['email_addresses']}\n\r";

                define('MAILGUN_KEY', 'key-fd36f8a5922184c166b613f2b2ad9d9c');
                define('MAILGUN_DOMAIN', 'sandbox20159935eca54c1793b8124ae32c39f5.mailgun.org');

                $mg = new \Mailgun\Mailgun(MAILGUN_KEY);

                $mg->sendMessage(
                    MAILGUN_DOMAIN,
                    array(
                        'from'    => 'Shoutburst <YOU@YOUR_DOMAIN_NAME>',
                        'to'      => $alert[0]['email_addresses'],
                        'subject' => 'Alert ' . $alert[0]['alert_name'],
                        'text'    => 'Alert conditions: ' . $alert[0]['filter_conditions']
                    )
                );
            }

            if ($alert[0]['send_sms']=='1') {

            }
        }
    }

	public function getAlertDetails($alert_id) {
		$this->db->where("alert_id", $alert_id);
		$this->db->from("alerts");
		$result = $this->db->get()->result();
		return $result;	
	}
	
	public function updateAlert( $post = array() , $modifiedby='' )	{
		$data = array(
			'alert_name'		=>	$post['alert_name'],
			'send_email'		=>	($post['send_email']=="on")?1:0,
			'send_sms'			=>	($post['send_sms']=="on")?1:0,
			'email_addresses'	=>	$post['email_address'],
			'sms_numbers'		=>	$post['sms'],
			'filter_conditions' =>  $this->resetFilter($post['filters1']),
			'alert_period'		=>  $post['period'],
			'modified_on'		=>	date('Y-m-d h:i:s a', time()),
			'modified_by'		=>	$modifiedby
        );
		
		$this->db->where('alert_id',$post['alert_id']);
		$this->db->update("alerts",$data);
	}
	
	public function delete( $alert_id='') {
		$this->db->where('alert_id', $alert_id);		
		$this->db->delete('alerts');
	}
	
	private function resetFilter($filters1)	{
		$filters1 = implode(", ",array_filter(explode(",",$filters1)));
		$filters1 = explode(",",$filters1);
		$filters1[0] = preg_replace("/\s*(\bOr\b)|(\bAnd\b)\s*/i", "", $filters1[0]);	
		$filters1 = implode(", ",$filters1);
		return $filters1;
	}
}
