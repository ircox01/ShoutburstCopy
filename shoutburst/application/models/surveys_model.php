<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Surveys_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

    /**
     * Inserts random surveys
     * FOR TESTING ONLY!
     * @param $num
     * @param $comp_id
     */

	public function insert_rand_surveys($comp_id, $num) {
        for ($i = 0; $i<$num; $i++) {
            $this->insert_survey(-1,$comp_id,rand(1,121));
        }
    }

	/**
	 * @author:	Muhammad Sajid
	 * @name:	get_survey
	 */
	public function get_survey($sur_id)
	{
		$result = $this->db->get_where('surveys', array('sur_id'=>$sur_id, 'processed'=>1))->result_array();
		return $result;
	}

	public function get_surveys(){
		$result = $this->db->get('surveys')->result_array();
		return $result;	
	}

	public function getUsersByAccess($acc_id, $comp_id)
	{
		 return $this->db->query("select
										*
									from
										user_companies as user_c
											inner join
										users ON users.user_id = user_c.user_id
											inner join
										companies as comp ON comp.comp_id = user_c.comp_id
											inner join
										company_campaings as cc ON cc.comp_id = comp.comp_id
									where
										user_c.acc_id = $acc_id and user_c.comp_id = $comp_id")->result();
	}

	public function getCampaigns()
	{
		return $this->db->query("select
										*
									from
										campaigns")->result();
	}

	public function insertRandomSurvey($comp_id, $user_id, $camp_id)
	{
		$q1 = rand(0,10);
		$q2 = rand(0,10);
		$q3 = rand(0,10);
		$q4 = rand(0,10);
		$q5 = rand(0,10);
		$total = $q1 + $q2 + $q3 + $q4 + $q5;
		$avrs = $total / 5;

		$sql_query = "INSERT INTO `surveys`(`comp_id`, `user_id`, `camp_id`, `dialed_number`, `date_time`,
			`cli`, `q1`, `q2`, `q3`, `q4`, `q5`, `total_score`, `average_score`,`nps_question`, `http_icon`, `action`, `recording`,
			`ftp_path`, `comments`, `servicenumber`, `plan`, `downloaded`, `recorded`, `processed`, `max_q1`, `max_q2`, `max_q3`,
			`max_q4`, `max_q5`)
			VALUES ($comp_id,$user_id,$camp_id,NULL,NOW(),NULL,$q1,$q2,$q3,$q4,$q5,$total,$avrs,1,NULL,NULL,0,1,0,0,0,0,0,0,0,5,5,5,5)";

		$result = $this->db->query($sql_query);

		echo "$sql_query \n\r";
		$this->load->model('alert_model');
		$everyCallAlerts = $this->alert_model->getEveryCall();

		foreach ($everyCallAlerts as $alert)
		{
			$this->alert_model->process($alert['alert_id']);
		}
		return $result;
	}

	public function insert_survey($sur_id,$comp_id,$user_id) {
		$sql_query = "INSERT INTO `surveys`(`sur_id`, `comp_id`, `user_id`, `camp_id`, `dialed_number`, `date_time`,
			`cli`, `q1`, `q2`, `q3`, `q4`, `q5`, `total_score`, `average_score`,`nps_question`, `http_icon`, `action`, `recording`,
			`ftp_path`, `comments`, `servicenumber`, `plan`, `downloaded`, `recorded`, `processed`, `max_q1`, `max_q2`, `max_q3`,
			`max_q4`, `max_q5`)
			VALUES ($sur_id,$comp_id,$user_id,49,NULL,NOW(),NULL,8,8,8,8,8,40,8,1,NULL,NULL,0,1,0,0,0,0,0,0,0,5,5,5,5)";

		if ($sur_id == -1)
		{
            $q1 = rand(0,10);
			$q2 = rand(0,10);
			$q3 = rand(0,10);
			$q4 = rand(0,10);
			$q5 = rand(0,10);
			$total = $q1 + $q2 + $q3 + $q4 + $q5;
			$avrg = $total/5;
			$sql_query = "INSERT INTO `surveys`( `comp_id`, `user_id`, `camp_id`, `dialed_number`, `date_time`,
				`cli`, `q1`, `q2`, `q3`, `q4`, `q5`, `total_score`, `average_score`,`nps_question`, `http_icon`,
				`action`, `recording`, `ftp_path`, `comments`, `servicenumber`, `plan`, `downloaded`, `recorded`,
				`processed`, `max_q1`, `max_q2`, `max_q3`, `max_q4`, `max_q5`)
				VALUES ($comp_id,$user_id,49,NULL,NOW(),NULL,$q1,$q2,$q3,$q4,$q5,$total,$avrg,1,NULL,NULL,0,1,0,0,0,0,0,0,0,5,5,5,5)";
		}
		$result = $this->db->query($sql_query);
        echo "$sql_query \n\r";
        $this->load->model('alert_model');
        $everyCallAlerts = $this->alert_model->getEveryCall();

        foreach ($everyCallAlerts as $alert) {
            $this->alert_model->process($alert['alert_id']);
        }
        return $result;
	}
}
