<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('date');
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	get_report
	 */
	public function get_report($report_id)
	{
		$this->db->where('report_id', $report_id);
		
		$result = $this->db->get('reports')->row_array();
		
		return $result;
	} 
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	get_reports
	 * @desc:	return all reports w.r.t company 
	 * 			desc order by created_on
	 */
	public function get_reports($comp_id = null)
	{		
		if ( ($comp_id != null) && $comp_id != 'null' )
		{	
			$this->db->select("r.* , DATE_FORMAT(r.created_on,'%Y-%m-%d') As createdon");
			$this->db->select('u.full_name');
			$this->db->from('reports r');
			$this->db->join('users u', 'u.user_id = r.created_by');
			$this->db->where('r.comp_id',$comp_id);
			$this->db->order_by('r.created_on', 'DESC');
			$sqlfrag1='';	
			
			if ($this->access == COMP_AGENT)
			{
				//$this->db->where('r.report_type != ','data');
				//$this->db->where('r.privacy','global');
				//$this->db->where('r.dashboard',1);
				$sqlfrag1="AND r.report_type != 'data' AND r.privacy='global' 
					AND r.dashboard=1";
			}
			$query="SELECT r.* , DATE_FORMAT(r.created_on,'%Y-%m-%d') AS createdon, u.full_name
					FROM reports r join users u ON u.user_id = r.created_by
					WHERE r.comp_id=$comp_id $sqlfrag1
					ORDER BY r.report_name";
			$result = $this->db->query($query)->result();
			//$this->db->get();
		} else {
			
			//$result = $this->db->get('reports')->result();
		}
		return $result;
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	delete
	 * @desc:	publish/unpublish report.
	 * 			stop if more than 4 reports are going to be publish.
	 *
	 * 			for quadrant (qdr_n) [n -> 1~4] & insert report_id where qdr_n = 0
	 * 			qdr_n any one form 1 to 4 {first come first update logic}
	 */
	public function status($report_id, $comp_id, $statusUpdate)
    {
    	# check if 4 reports have already published to Dashboard
    	$db_reports = $this->db->query("SELECT * FROM dashboards 
    								WHERE user_id = {$this->user_id} AND comp_id = {$comp_id} 
    								AND (qdr_1=0 || qdr_2=0 || qdr_3=0 || qdr_4=0)")->row_array();

    	if ( empty($db_reports) && ($statusUpdate == 1) ){
    		return false;
    	} else {
    		
    		$user_id = $this->user_id;
    		$acc_id = $this->access;
    			
    		# update dashboard table
    		# check all 4 fields(qdr_n), if any first cell found with 0 then query will update
    		# that cell with report_id
    		if ($statusUpdate == 1)
    		{		
	    		for ($n=1; $n<=4; $n++)
	    		{
	    			# get report privacy level
	    			$rep = $this->get_report($report_id);
	    			$privacy = $rep['privacy'];
	    			
	    			if ($acc_id == COMP_AGENT && $privacy == 'private'){
	    				// Do nothing!
	    			} else {
		    			$sql = "UPDATE dashboards
								SET qdr_{$n} = IF (qdr_{$n} = 0, {$report_id}, qdr_{$n}) 
								WHERE user_id  = {$user_id} AND comp_id = {$comp_id}";
		    			$this->db->query($sql);
		    			$affected_rows = $this->db->affected_rows();
		    			
		    			if ( $affected_rows === 1 ){
		    				break;
		    			}
	    			}			    			
	    		}
    		} else {
    			# for un-publish case
    				
    			# search report_id & set to 0
    			for ($n=1; $n<=4; $n++)
	    		{
	    			$sql = "UPDATE dashboards
							SET qdr_{$n} = IF (qdr_{$n} = {$report_id}, 0, qdr_{$n}) 
							WHERE comp_id = {$comp_id}";
	    			$this->db->query($sql);
	    			$affected_rows = $this->db->affected_rows();
	    			
	    			if ( $affected_rows === 1 ){
	    				break;
	    			}
	    		}
    		}
    		return true;
    	}
    }
    
    /*
     * @name:	my_dashboard_report
     */
    public function my_dashboard_report($report_id)
    {
    	$row = $this->db->query("SELECT * FROM dashboards 
    							WHERE comp_id = $this->comp_id AND user_id = $this->user_id AND (qdr_1 = $report_id || qdr_2 = $report_id || qdr_3 = $report_id || qdr_4 = $report_id)")->row_array();
    	return $row;
    }
    
    /*
     * @author:	Muhammad Sajid
     * @name:	dashboard_report
     */
    public function dashboard_report($report_id)
    {
    	$dashboard_report = $this->db->query("select report_name, report_type, x_axis_label, y_axis_label, background_color, report_period, 
    											report_interval, report_query 
    											from reports 
    											where dashboard = 1 and report_id = {$report_id}")->row_array();
    	return $dashboard_report;
    }
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	get_report_types
	 */
	public function get_report_types()
	{
		$this->db->order_by("type_name", "asc");
		$result = $this->db->get('report_types')->result();
		return $result;
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	get_report_periods
	 */
	public function get_report_periods()
	{
		$result = $this->db->get('report_periods')->result();
		return $result;
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	get_report_intervals
	 */
	public function get_report_intervals()
	{
		$result = $this->db->get('report_intervals')->result();
		return $result;
	}
	
	/*
	 * @author:	Arshad
	 * @Mathod:	get_chart_data
	 */
	public function get_chart_data($sql)
	{
		if($sql){			
			//set increase group concat val
			$this->db->query("SET SESSION group_concat_max_len = 2000000");
			
			$query = $this->db->query($sql);
			return $query->result_array();
		}
	}
	
	/**
	 * @author Arshad
	 * @Method Save Report Data
	 * */
	
	public function saveReportData($data,$query)
	{		
		
		$report_name				  = 	$this->db->escape($data['report_name']);
		$report_type				  = 	$this->db->escape($data['report_type']);
		$report_period				  = 	$this->db->escape($data['report_period']);
		$report_interval			  = 	$this->db->escape($data['report_interval']);
		$op_req				  		  = 	$this->db->escape($data['op_req']);
		$email_address				  = 	$this->db->escape($data['email_address']);
		$ftp_host_name				  = 	$this->db->escape($data['ftp_host_name']);
		$ftp_port				  	  = 	$this->db->escape($data['ftp_port']);
		$ftp_user_name				  = 	$this->db->escape($data['ftp_user_name']);
		$ftp_password				  = 	$this->db->escape($data['ftp_password']);
		$privacy				  	  = 	$this->db->escape($data['privacy']);
		$op_req_flag				  = 	$this->db->escape($data['op_req_flag']);
		$background_color			  = 	$data['background_color'];
		$x_axis_label				  = 	$this->db->escape($data['x_axis_label']);
		$y_axis_label				  = 	$this->db->escape($data['y_axis_label']);
		$y_axis_midpoint			  = 	$this->db->escape($data['y_axis_midpoint']);
		$logo				  		  = 	$this->db->escape($data['logo']);
		$reports_fields				  = 	$this->db->escape($data['reports_fields']);
		
		/**
		 * Save Report Query Conditions
		 * */
		$report_period_date	=	"";
		if($data['report_period']=='day'){
			$report_period_date			  = $data['custom_date'];//	date('Y-m-d',strtotime($data['custom_date']));
		}
		
		$custom_start_date	=	"";
		$custom_end_date	=	"";
		
		$data['start_date'] = str_replace('/', '-',$data['start_date']);
		$data['end_date'] =  str_replace('/', '-',$data['end_date']);
		
		if($data['report_period']=='custom')
		{
			$custom_start_date			  = 	date('Y-m-d H:i',strtotime($data['start_date']));
			$custom_end_date			  = 	date('Y-m-d H:i',strtotime($data['end_date']));
		}
		
		
		//set default background color
		if($background_color==""||empty($background_color)){
			$background_color = "#ffffff";
		}
		if(!empty($data['condition']) && isset($data['condition']))
		{
			$query_condition			  = 	$this->db->escape(serialize($data['condition']));
		}else
			$query_condition="''";
		//$query_condition			  =		'';
		//$query_condition			  = 	$this->db->escape(serialize($data['condition']));
		$query_data_type			  = 	$this->db->escape(serialize($data['data_type']));
		$query_filter				  = 	$this->db->escape(serialize($data['filter']));
		$query_detail				  = 	$this->db->escape(serialize($data['detail']));
		
		$query				 		  = 	$this->db->escape($query);

		$loginUserId	= 0;
		if($this->session->userdata('user_id')){
			$loginUserId				  = $this->session->userdata('user_id');
		}
		
		$compId			= 0;
		if($this->session->userdata('comp_id')){
			$compId				  = $this->session->userdata('comp_id');
		}	
		
		$dashboardOpt				  = "0";
		$wallboardOpt				  = "0";
		
		//walboard and dashboard will not checked for DATA 
		if($data['report_type']!='data'){
			if(isset($data['dashboard']))				{$dashboardOpt	= "1";}
		}
			if(isset($data['wallboard']))				{$wallboardOpt	= "1";}
		
		if ($data['report_type'] =='word cloud') {
			$dashboardOpt	= "1";
		}
		
		$currentDateTime			  = date('c');
		
		$sql	=	<<<SQL
							INSERT INTO `reports`
							  (
								  `report_name`,
								  `report_type`,
								  `report_period`,
								  `report_interval`,
								  `report_query`,
								  `report_period_date`,
								  `custom_start_date`,
								  `custom_end_date`,
								  `query_condition`,
								  `query_data_type`,
								  `query_filter`,
								  `query_detail`,
								  `op_req`,
								  `email_address`,
								  `ftp_host_name`,
								  `ftp_port`,
								  `ftp_user_name`,
								  `ftp_password`,
								  `wallboard`,
								  `dashboard`,
								  `privacy`,
								  `background_color`,
								  `x_axis_label`,
								  `y_axis_label`,
								  `y_axis_midpoint`,
								  `logo`,
								  `columns_name`,
								  `comp_id`,
								  `created_by`,
								  `created_on`
							  )
							VALUES
							 (
						        $report_name,
						        $report_type,
						        $report_period,
						        $report_interval,
						        $query,
						        '$report_period_date',
						        '$custom_start_date',
						        '$custom_end_date',
						        $query_condition,
						        $query_data_type,
						        $query_filter,
						        $query_detail,
						        $op_req,
						        $email_address,
						        $ftp_host_name,
						        $ftp_port,
						        $ftp_user_name,
						        $ftp_password,
						        $wallboardOpt,
						        $dashboardOpt,
						        $privacy,
						        '$background_color',
						        $x_axis_label,
						        $y_axis_label,
						        $y_axis_midpoint,
						        $logo,
						        $reports_fields,
						        $compId,
						        $loginUserId,
						        '$currentDateTime'
					        )
SQL;
			$this->db->query($sql);
	}
	
	
	/**
	 * @author Arshad
	 * Update Report
	 * */
	
	function updateReportData($data,$query){		
		
		$report_id					  = 	$data['report_id'];
		$report_name				  = 	$this->db->escape($data['report_name']);
		$report_type				  = 	$this->db->escape($data['report_type']);
		$report_period				  = 	$this->db->escape($data['report_period']);
		$report_interval			  = 	$this->db->escape($data['report_interval']);
		$op_req				  		  = 	$this->db->escape($data['op_req']);
		$privacy				  	  = 	$this->db->escape($data['privacy']);
		$op_req_flag				  = 	$this->db->escape($data['op_req_flag']);
		$background_color			  = 	$data['background_color'];
		$x_axis_label				  = 	$this->db->escape($data['x_axis_label']);
		$y_axis_label				  = 	$this->db->escape($data['y_axis_label']);
		$y_axis_midpoint			  = 	$this->db->escape($data['y_axis_midpoint']);
		$logo				  		  = 	$this->db->escape($data['logo']);
		$reports_fields				  = 	$this->db->escape($data['reports_fields']);
		
		/**
		 * Save Report Query Conditions
		 * */
		$report_period_date	=	"";
		if($data['report_period']=='day')
		{
			$report_period_date			  = $data['custom_date'];//	date('Y-m-d',strtotime($data['custom_date']));
		}
		
		$custom_start_date	=	"";
		$custom_end_date	=	"";
		$data['start_date'] = str_replace('/', '-',$data['start_date']);
		$data['end_date'] =  str_replace('/', '-',$data['end_date']);
		if($data['report_period']=='custom')
		{
			$custom_start_date			  =  	date('Y-m-d H:i',strtotime($data['start_date']));
			$custom_end_date			  =		date('Y-m-d H:i',strtotime($data['end_date']));
		}
			
		/**
		 * Set Email Address Empty if another value is selected 
		 * */
		$email_address	=	"";
		if($data['op_req']=='email')
		{
			$email_address				  = 	$data['email_address'];
		}
		
		/**
		 * Set FTP Options Empty if another value is selected 
		 * */
		
		$ftp_host_name				  = 	'';
		$ftp_port				  	  = 	'';
		$ftp_user_name				  = 	'';
		$ftp_password				  = 	'';
		
		if($data['op_req']=='ftp'){
			$ftp_host_name				  = 	$data['ftp_host_name'];
			$ftp_port				  	  = 	$data['ftp_port'];
			$ftp_user_name				  = 	$data['ftp_user_name'];
			$ftp_password				  = 	$data['ftp_password'];
		}
		if(!empty($data['condition']) && isset($data['condition']))
		{
			$query_condition			  = 	$this->db->escape(serialize($data['condition']));
		}else
			$query_condition='""';
		//$query_condition			  = 	 $this->db->escape(serialize($data['condition']));
		$query_data_type			  = 	$this->db->escape(serialize($data['data_type']));
		$query_filter				  = 	$this->db->escape(serialize($data['filter']));
		$query_detail				  = 	$this->db->escape(serialize($data['detail']));
		
		$query				 		  = 	$this->db->escape($query);

		$loginUserId	= 0;
		if($this->session->userdata('user_id')){
			$loginUserId				  = $this->session->userdata('user_id');
		}
		
		$compId			= 0;
		if($this->session->userdata('comp_id')){
			$compId				  = $this->session->userdata('comp_id');
		}

		//set default background color
		if($background_color==""||empty($background_color)){
			$background_color = "#ffffff";
		}
		
		$dashboardOpt				  = "0";
		$wallboardOpt				  = "0";
		//walboard and dashboard will not checked for DATA 
		if($data['report_type']!='data'){
			if(isset($data['dashboard']))				{$dashboardOpt	= "1";}
		}
			if(isset($data['wallboard']))				{$wallboardOpt	= "1";}
		
		
		if ($data['report_type'] =='word cloud') {
			$dashboardOpt	= "1";
		}
		
		$currentDateTime			  = date('c');
		
		$sql	=	<<<SQL
							UPDATE `reports`  SET
								  `report_name`			=	$report_name,
								  `report_type`			= 	$report_type,
								  `report_period`		= 	$report_period,
								  `report_interval`		=  	$report_interval,
								  `report_query`		=  	$query,
								  `report_period_date`	=	'$report_period_date',
								  `custom_start_date`	=	"$custom_start_date",
								  `custom_end_date`		=	"$custom_end_date",
								  `query_condition`		=	$query_condition,
								  `query_data_type`		=	$query_data_type,
								  `query_filter`		=	$query_filter,
								  `query_detail`		=	$query_detail,
								  `op_req`				=	$op_req,
								  `email_address`		=	'$email_address',
								  `ftp_host_name`		=	'$ftp_host_name',
								  `ftp_port`			=	'$ftp_port',
								  `ftp_user_name`		=	'$ftp_user_name',
								  `ftp_password`		=	'$ftp_password',
								  `wallboard`			=	$wallboardOpt,
								  `dashboard`			=	$dashboardOpt,
								  `privacy`				=	$privacy,
								  `background_color`	=	'$background_color',
								  `x_axis_label`		=	$x_axis_label,
								  `y_axis_label`		=	$y_axis_label,
								  `y_axis_midpoint`		=	$y_axis_midpoint,
								  `logo`				=	$logo,
								  `columns_name`		=	$reports_fields,
								  `comp_id`				=	$compId,
								  `modified_by`			=	$loginUserId,
								  `modified_on`			=	'$currentDateTime'
						WHERE
							report_id	=	$report_id
SQL;
		
			$this->db->query($sql);
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	get_my_report
	 */
	public function get_my_report($report_id)
	{
		$report = array();
		$query = $this->db->query("select count(*) as count from dashboards 
							where user_id = {$this->user_id} and comp_id = {$this->comp_id} 
								and (qdr_1 = {$report_id} or qdr_2 = {$report_id} or qdr_3 = {$report_id} or qdr_4 = {$report_id} )")->row_array();
		if ($query['count'] > 0)
		{
			$this->db->where('report_id', $report_id);
			$report = $this->db->get('reports')->row_array();			
		}
		return $report;
	}
}
?>
