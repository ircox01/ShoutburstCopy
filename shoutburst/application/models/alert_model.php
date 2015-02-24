<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alert_model extends CI_Model {

	public function __construct()
	{

	}
	
	public function addAlert( $post = array(), $createdBy ='' , $comp_id='' )
	{
		$data = array(
						'alert_name'		=>	$post['alert_name'],
						'send_email'		=>	($post['send_email']=="on")?1:0,
						'send_sms'			=>	($post['send_sms']=="on")?1:0,
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
	
	public function getAlerts($comp_id='')
	{
		$result = $this->db->query("SELECT a.alert_id, a.alert_name, a.status, DATE_FORMAT(a.created_on,'%Y-%m-%d %H:%i') as createdon, u.full_name,a.filter_conditions FROM alerts a JOIN users u ON a.created_by=u.user_id WHERE comp_id=$comp_id ORDER BY createdon DESC ")->result_array();
		return $result;
	}

    public function getHourly() {
        $res = $this->db->query("SELECT * FROM alerts WHERE alert_period='lasthour'")->result_array();
        return $res;
    }

    public function process($alert_id) {
        $alert = $this->db->query("SELECT * FROM alerts WHERE alert_id = " . $this->db->escape($alert_id))->result_array();
        $filters = explode(',',$alert[0]['filter_conditions']);
        $where = array();
        $where[] = "comp_id = ".$this->db->escape($alert[0]['comp_id']);

        foreach ($filters as $filterPos => $filter) {
            $filter = trim($filter);
            preg_match_all('/(Or)?(And)?(.*)\h?([<,>,=])\h?([0-9]*)/i', $filter, $conditions, PREG_SET_ORDER);
            //var_dump($conditions, $filterPos);
            $flags = array('Word','Filter','Operator','Value');
            $res = array();
            if ($filterPos == 0 )
                array_splice($flags,0,1);
                $res['Word'] = '';
            $i=0;
            foreach ($conditions[0] as $key=>$condition) {
                if ($condition != '' && $key != 0) {
                    $res[$flags[$i]] = trim($condition);
                    $i++;
                }
            }
            //var_dump('Filter ' . $res['Filter']);
            /** Now Prepare Where Cond */
            $filter = explode(':', $res['Filter']);

            switch (trim($filter[0])) {
                case 'total score':
                    $where[] = "{$res['Word']} total_score {$res['Operator']} " . $this->db->escape($res['Value']);
                    break;
                case 'question score':
                    echo "ASF \n\r";

                    var_dump($temp);
                    break;
                case 'total surveys':
                    break;
            }
        }

    }

	public function getAlertDetails($alert_id)
	{
		$this->db->where("alert_id", $alert_id);
		$this->db->from("alerts");
		$result = $this->db->get()->result();
		return $result;	
	}
	
	public function updateAlert( $post = array() , $modifiedby='' )
	{	
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
	
	public function delete( $alert_id='')
	{
		$this->db->where('alert_id', $alert_id);		
		$this->db->delete('alerts');
	}
	
	private function resetFilter($filters1)
	{
		$filters1 = implode(", ",array_filter(explode(",",$filters1)));
		$filters1 = explode(",",$filters1);
		$filters1[0] = preg_replace("/\s*(\bOr\b)|(\bAnd\b)\s*/i", "", $filters1[0]);	
		$filters1 = implode(", ",$filters1);
		return $filters1;
	}
}
