<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author:	Muhammad Sajid
 * @desc:	This is only allowed for company admin and company manager
 */
class Reports extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$data['title'] = TITLE.' | Reports';
		$this->load->model('Reports_model', 'reports');
		
		# get session variable
		$this->user_id = $this->session->userdata['user_id'];
		$this->comp_id = $this->session->userdata['comp_id'];
		$this->access = $this->session->userdata['access'];
		
		# group Data Control for color
		$this->general = array('Agent PIN','Agent Name','Dialed Number','CLI','Campaign');
		$this->score = array('Q1 Score','Q2 Score','Q3 Score','Q4 Score','Q5 Score','Total Score','Average Score','Total Surveys');
		$this->detail = array('Recording','Transcription','Sentiment','Notes','Tag');
		
		$this->load->vars($data);
		
		if( ! isset($this->session->userdata['user_id']) ) {
			redirect('login');
		}
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	generate_pdf
	 */
	public function generate_pdf()
	{
		#var_debug($_POST);exit;
		$filename = $_POST['report_name'].'-'.date('m-d-Y_h-i-s_a');		
		$html = $_POST['report_html'];
		//$html ="<img src='".$_POST['img']."'/>";
		// As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/
		$pdfFilePath = FCPATH."/downloads/reports/$filename.pdf";
		#var_debug($pdfFilePath);exit;
		$data['page_title'] = $_POST['report_name']; // pass data to the view
		
		if (file_exists($pdfFilePath) == FALSE)
		{
		    ini_set('memory_limit','1024M'); // boost the memory limit if it's low <img src="http://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley"> 
		    #$html = $this->load->view('pdf_report', $data, true); // render the view into HTML
		     
		    $this->load->library('pdf');
		    #$param = '"en-GB-x","A4","","",10,10,10,10,6,3';
		    #$param = '"utf-8", "190","236")';
		    $param = "'','', 0, '', 15, 15, 16, 16, 9, 9, 'L'";
		    
		    $pdf = $this->pdf->load($param); 
		    $pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822)); // Add a footer for good measure <img src="http://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley"> 
		    $pdf->WriteHTML($html); // write the HTML into the PDF
		    $pdf->Output($pdfFilePath, 'F'); // save to file because we can
		}
		//var_dump(file_get_contents("http://localhost/shoutburst/reports/add_report"));
		echo "/downloads/reports/$filename.pdf";
		//redirect("/downloads/reports/$filename.pdf");
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	index
	 */
	public function index()
	{
		switch ($this->access){
			case COMP_ADMIN:
				$this->admin();
			break;
			
			case COMP_MANAGER:
				$this->manager();
			break;
			
			case COMP_AGENT:
				$this->agent();
			break;			
		}		
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	admin
	 */
	public function admin()
	{
		# Get all Reports
		$data['reports'] = $this->reports->get_reports($this->comp_id);
		$this->load->template('reports/admin/index', $data);
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	status
	 * @desc:	allow admin/manager to publish
	 * 			report for dashboard/wallboard
	 */
	public function status()
	{
		$report_id = $this->uri->segment(3);
		$action = $this->uri->segment(4);

		if ( is_numeric($report_id) )
		{
			$statusUpdate	=	0;
			$msg			= 'Unpublished';
			//if status is enable 
			if($action=='enable'){
				$statusUpdate = 1;
				$msg			= 'Published';
			}		
			if ( !$this->reports->status($report_id, $this->comp_id, $statusUpdate) ){
				$this->session->set_flashdata('message', '<div id="message" class="error">Four reports have already been published.</div>');				
			} else {
				$this->session->set_flashdata('reportSuccessMessage', "$msg successfully.");
			}
		} else {
			$this->session->set_flashdata('message', '<div id="message" class="error">Error while deleting.</div>');
		}
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	add_report
	 */
	public function add_report()
	{
		if ($this->access != COMP_AGENT){
			# Get all Report Types
			$data['report_types'] 			= $this->reports->get_report_types();
			$data['report_periods'] 		= $this->reports->get_report_periods();
			$data['report_intervals'] 		= $this->reports->get_report_intervals();
			$data['yAxisColoumnList'] 		= $this->yAxisColoumnList();
			
			#Data Control Column
			$data['dataControlColumn']		= $this->dataControlColumn();
			
			$this->load->template('reports/admin/add', $data);
		} else {
			redirect('reports');
		}
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	query_builder
	 * @desc:	insert/update report filters
	 * 			this function will add/edit report.
	 * 			If report name already exsit then 
	 */
	public function query_builder()
	{
		# save post values into variable
		$post = $_POST;
		
		//report type
		$report_type	=	$post['report_type'];
		
		//chart type
		$chartType	=	array('bar chart','line graph','pie chart');
		
		//for Report Data Heading
		$selectedColoumnHeading	=	$post['reports_fields'];
		
		# mapping array for DB tables and Data Control 
		$cols = $this->dbMappingColumn();
		
		$selectedColoumnHeading	=	$post['reports_fields'];
		# create report column array
		$report_fields = explode(",", str_replace(" ", "_", strtolower(trim($post['reports_fields']))));
		
		//Total Survey Variable
		$totalSurvey	=	false;
		
		foreach ($report_fields as $k){
			
			//total survey set true
			if($k == 'total_surveys'){
				$totalSurvey	=	true;
				continue;
			}
			
			$fields[] = $cols[$k];
		}
		
		# build fields list for query string
		$select = implode(",", $fields);
		
		//check data type is chart or not
		if(in_array($report_type,$chartType)){ 
			//select column on basis of chart selection if any
			$selectedChartColumn = $this->getChartColumn($post);
			if($selectedChartColumn){
				$select = $select.",".$selectedChartColumn;
			}
		}
	
		//check data type is chart or not
		if($report_type=='data'){
			//select column on basis of chart selection if any
			$selectedDataColumn = getDataColumn($post,$select);
			if($selectedDataColumn){
				$select = $select.",".$selectedDataColumn;
			}
		}
		
		//check data type is detail
		if($report_type=='detail'){
			//select column on basis of chart selection if any
			$selectedDataColumn = getDetailColumn($post,$select);
			if($selectedDataColumn){
				$select = $selectedDataColumn;
			}
		}
		
		
		$from = "FROM surveys s";
		$where = array();
		$join = "LEFT JOIN users u ON u.user_id = s.user_id
				LEFT JOIN user_companies uc ON uc.user_id = u.user_id
				LEFT JOIN campaigns c ON c.camp_id = s.camp_id";
		
		if(in_array('transcriptions_text',$fields) || in_array('sentiment_score', $fields)){
			$join .= " LEFT JOIN transcriptions t ON t.sur_id = s.sur_id";
		}
		
		//tag table join if tag field is selected
		if(in_array('tag_name',$fields)){
			$join .= " LEFT JOIN tags tg ON tg.comp_id = s.comp_id";
		}
		
		//var_debug($post);exit;
		
		//remove  hidden div value which is comming in data_type,condition,detail & filter
		unset($post['data_type'][0]);
		unset($post['filter'][0]);
		unset($post['detail'][0]);
		//var_debug($post);exit;
		
		$conditionLoop	=	0;
		for($i = 1; $i <= count($post['data_type']); $i++)
		{
			$detail = "'".$post['detail'][$i]."'";
			
			# which operator user selected
			switch ($post['filter'][$i]){
				case 'gt':
					$operator = '>';					
				break;
				
				case 'lt':
					$operator = '<';
				break;
				
				case 'e':
					$operator = '=';
				break;
				
				case 'ne':
					$operator = '!=';
				break;
				
				case 'b':
					$operator = 'BETWEEN';
					$detail = str_replace( ",", " and ", trim($post['detail'][$i]) );
				break;
				
				default:
					$operator = '';
				break;
			}
			
			if ($conditionLoop>0){
				$where[] = $post['condition'][$conditionLoop] .' '. $post['data_type'][$i] .' '. $operator .' '. $detail;
			}else{
				$where[] = $post['data_type'][$i] .' '. $operator .' '. $detail;
			}
			
			$conditionLoop++;
		}
		
		$where = implode(" ", $where);

		$where = 'WHERE '.$where . ' AND acc_id = '.COMP_AGENT;
		#var_debug($where);exit;
		//check data type is chart or not
		if(in_array($report_type,$chartType)){ 
			//set where condition basis of chart selection yearly, monthly
			$chartWhere	=	$this->chartWhereCondition($post);
			if($chartWhere){
				$where = $where." AND ".$chartWhere;
			}
		}
		//if report type is
		if($report_type=='data'){
			//set where condition basis of chart selection yearly, monthly
			$dataWhere	=	dataWhereCondition($post);
			if($dataWhere){
				$where = $where." AND ".$dataWhere;
			}
		}
		
		$query = 'SELECT DISTINCT '. $select .' '. $from .' '. $join .' '. $where;
		#var_debug($query);exit;
		# insert into reports table SaveReport atrribute is comming in requets
		if(isset($post['saveReport'])&&$post['saveReport']=='saveReportData'){
			$this->reports->saveReportData($post,$query);
			echo "<div></div>";
			$this->session->set_flashdata('reportSuccessMessage', 'Report Saved Successfully!');
			exit();
		}
		
		# update report data
		if(isset($post['saveReport'])&&$post['saveReport']=='updateReportData'){
			$this->reports->updateReportData($post,$query);
			echo "<div></div>";
			$this->session->set_flashdata('reportSuccessMessage', 'Report Updated Successfully!');
			exit();
		}
		# TODO: If report column field contains tag_name then while generating reports get campaign id and execute
		#		select * from tags where camp_ids LIKE '%"20"%' to get Tag name
		
		
		
		/**
		 * Show Chart
		 * */
		//check data type is chart or not
		if(in_array($report_type,$chartType)){
			//draw chart
			
			$x_axis_label		=	$post['x_axis_label'];
			$y_axis_label		=	$post['y_axis_label'];
			
			$background_color	=   '#ffffff';
			if($post['background_color']!=''&&!empty($post['background_color'])){
				$background_color	=	$post['background_color'];
			}
			
			$report_period	 =	$post['report_period'];
			$report_interval =	$post['report_interval'];
			$report_name	 =	$post['report_name'];
			
//			$this->chartDraw($query,$report_type,$x_axis_label,$y_axis_label,$background_color,$post);
			$this->chartDraw($query, $report_type, $x_axis_label, $y_axis_label, $background_color,$report_period,$report_interval,$report_name);
		}
		
		/**
		 * Show Data Table
		 * */
		//check data type is data
		if($report_type=='data'){
			
			$background_color	=   '#ffffff';
			if($post['background_color']!=''&&!empty($post['background_color'])){
				$background_color	=	$post['background_color'];
			}
			
			$report_period	 =	$post['report_period'];
			$report_interval =	$post['report_interval'];
			$report_name	 =	$post['report_name'];
			
			//draw data
			dataReportDraw($query, $report_type,$background_color,$report_period,$report_interval,$report_name,$selectedColoumnHeading);
		}
		
		/**
		 * Show Detail Table
		 * */
		//check data type is data
		if($report_type=='detail'){
			
			$background_color	=   '#ffffff';
			if($post['background_color']!=''&&!empty($post['background_color'])){
				$background_color	=	$post['background_color'];
			}
			
			$report_name	 =	$post['report_name'];
			
			//draw data
			detailReportDraw($query, $report_type,$background_color,$report_name,$selectedColoumnHeading);
		}
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	manager
	 */
	public function manager()
	{
		# Get all Reports
		$data['reports'] = $this->db->get('reports')->result();		
		$this->load->template('reports/manager/index', $data);
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	agent
	 */
	public function agent()
	{
		# Get all Reports
		$reports = $this->reports->get_reports($this->comp_id);
		$data['reports'] = $reports;
		$this->load->template('reports/agent/index', $data);
	}

	/**
	 * @author Arshad
	 * @Methods : Charts Common Methods for repot
	 * **/
	function getChartColumn($post){
		
		$chartColoumn		=	array();
		
		if(!empty($post)){
			$report_type		=	$post['report_type'];
			$report_period		=	$post['report_period'];
			$report_interval	=	$post['report_interval'];
			
			$y_axis_label	=	's.total_score';
			if(isset($post['y_axis_label'])&&!empty($post['y_axis_label'])){
				$y_axis_label		=	$post['y_axis_label'];
			}
			//format start and end time for sql query
			$start_date			=   date('Y-m-d',strtotime($post['start_date']));
			$end_date			=   date('Y-m-d',strtotime($post['end_date']));
			
			if(in_array($report_period,array('hour','day','today','yesterday','week','last week','month','last month','custom'))){
				$dateTime = 's.date_time';
			}
			
			#TODO
			
			/**
			 * Coloumn Alias totalSurveyScore will be remove after implementation of multi agent chart for PIE & BAR
			 * for multi agent i am using `totalWithRange` which contain all information related to agent we have to parse that for PIE & BAR 
			 * */
			
			//get cahrt coloumn result on basis of selection 
			switch ($report_interval) {
			    case "live":
			    	$liveInterval	=	LIVE_INTERVAL;
			    	$chartColoumn[]	= "SUM($y_axis_label) AS totalSurveyScore";
					$chartColoumn[] = "DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(date_time) - MOD(UNIX_TIMESTAMP(date_time), $liveInterval)), '%h:%i %p') AS reportDate";
					$chartColoumn[] = "GROUP_CONCAT(CONCAT($y_axis_label,'---+++--', Date_format(From_unixtime(Unix_timestamp(date_time) - Mod( Unix_timestamp(date_time), $liveInterval)),'%h:%i %p')) SEPARATOR '___---___') AS totalWithRange";
			        break;
			    case "minutes":
			    	$chartColoumn[]	= "SUM($y_axis_label) AS totalSurveyScore";
					$chartColoumn[] = "DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(date_time) - MOD(UNIX_TIMESTAMP(date_time), 300)), '%h:%i %p') AS reportDate";
					$chartColoumn[] = "GROUP_CONCAT(CONCAT($y_axis_label,'---+++--', Date_format(From_unixtime(Unix_timestamp(date_time) - Mod( Unix_timestamp(date_time), 300)),'%h:%i %p')) SEPARATOR '___---___') AS totalWithRange";
			        break;
			    case "hours":
			    	$chartColoumn[]	= "SUM($y_axis_label) AS totalSurveyScore";
					$chartColoumn[] = "CONCAT(DATE_FORMAT(DATE_SUB($dateTime, INTERVAL 1 HOUR), '%h:%i%p'),' to ',DATE_FORMAT(DATE_SUB($dateTime, INTERVAL 0 HOUR), '%h:%i'), DATE_FORMAT(s.date_time, '%p'))   AS reportDate ";
					$chartColoumn[] = "GROUP_CONCAT(CONCAT($y_axis_label,'---+++--',CONCAT(DATE_FORMAT(DATE_SUB(s.date_time, INTERVAL 1 HOUR), '%h:%i%p'),' to ',DATE_FORMAT(DATE_SUB(s.date_time, INTERVAL 0 HOUR), '%h:%i%p'))) SEPARATOR '___---___') AS totalWithRange";
			        break;
			    case "days":
			    	$chartColoumn[]	= "SUM($y_axis_label) AS totalSurveyScore";
					$chartColoumn[] = "DAYNAME($dateTime) AS reportDate";
					$chartColoumn[] = "GROUP_CONCAT(CONCAT($y_axis_label,'---+++--', DAYNAME(s.date_time)) SEPARATOR '___---___') AS totalWithRange";
			        break;
			    case "weeks":
			    	$chartColoumn[]	= "SUM($y_axis_label) AS totalSurveyScore";
					$chartColoumn[] = "CONCAT(DATE_FORMAT(DATE_ADD(s.date_time, INTERVAL(1-DAYOFWEEK(s.date_time)) DAY),'%m/%d'),' - ',DATE_FORMAT( DATE_ADD(s.date_time, INTERVAL(7-DAYOFWEEK(s.date_time)) DAY),'%m/%d'))  AS reportDate";
					$chartColoumn[] = "GROUP_CONCAT(CONCAT($y_axis_label,'---+++--', CONCAT(DATE_FORMAT(DATE_ADD(s.date_time, INTERVAL(1-DAYOFWEEK(s.date_time)) DAY),'%m/%d'),' - ',DATE_FORMAT(DATE_ADD(s.date_time, INTERVAL(7-DAYOFWEEK(s.date_time)) DAY),'%m/%d'))) SEPARATOR '___---___') AS totalWithRange";
			        break;
			    case "months":
			    	$chartColoumn[]	= "SUM($y_axis_label) AS totalSurveyScore";
					$chartColoumn[] = "MONTHNAME($dateTime) AS reportDate";
					$chartColoumn[] = "GROUP_CONCAT(CONCAT($y_axis_label,'---+++--', MONTHNAME(s.date_time)) SEPARATOR '___---___') AS totalWithRange";
			        break;
			     
			}
			
			
		//get chart coloumn result text on basis of selection 
			switch ($report_period) {
			    case "hour":
					$chartColoumn[]	= "CONCAT('Record Shown from ',DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 HOUR),'%h:%i'),' to ' , DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 0 HOUR),'%h:%i')) AS recordShownMessage";
			        break;
			    case "day":
			    	$chartColoumn[]	= "CONCAT('Record Shown for ', CURRENT_DATE()) AS recordShownMessage";
			        break;
			    case "today":
			    	$chartColoumn[]	= "CONCAT('Record Shown for ', CURRENT_DATE()) AS recordShownMessage";
			        break;
			    case "yesterday":
			    	$chartColoumn[]	= "CONCAT('Record Shown for ',DATE(DATE_SUB(NOW(), INTERVAL 1 DAY))) AS recordShownMessage";
			        break;
			    case "week":
			    	$chartColoumn[]	= "CONCAT('Record Shown from ',DATE(DATE_SUB(NOW(), INTERVAL 1 WEEK)) ,' to ' , DATE(NOW())) AS recordShownMessage";
			        break;
			    case "last week":
			    	$chartColoumn[]	= "CONCAT('Record Shown from ',DATE(DATE_SUB(NOW(), INTERVAL 2 WEEK)) ,' to ' , DATE(DATE_SUB(NOW(), INTERVAL 1 WEEK))) AS recordShownMessage";
			        break;
			    case "month":
			    	$chartColoumn[]	= "CONCAT('Record Shown for ',MONTHNAME(DATE_SUB(NOW(), INTERVAL 0 MONTH)),',',YEAR(s.date_time)) AS recordShownMessage";
			        break;
			    case "last month":
			    	$chartColoumn[]	= "CONCAT('Record Shown for ',MONTHNAME(DATE_SUB(NOW(), INTERVAL 1 MONTH)),',',YEAR(s.date_time)) AS recordShownMessage";
			        break;
			    case "custom":
			    	$chartColoumn[]	= "CONCAT('Record Shown from ','$start_date' ,' to ' , '$end_date') AS recordShownMessage";
			        break;
			     
			}
			
			
			/**
			 * get Shown Record Range For Show in CHart Detail View  
			 * */
			
			
			$chartColoumn[]	= 'GROUP_CONCAT(DISTINCT(full_name)) AS AgentFullName';
			$chartColoumn[]	= 'full_name';
			$chartColoumn[] = $y_axis_label;			
			
		}
		
		
		//if chart column array is empty then result set will be false else we return comma seprated column
		if(empty($chartColoumn)){
			return false;
		}else{
			$chartColoumn = implode(",",$chartColoumn);
			return $chartColoumn;
		}
		
	}
	
	/**
	 * Get Where condition on basis of chart X-Axis Select i.e yearly,monthly, daily
	 * 
	 * */
	
	function chartWhereCondition($post){
		
		$whereCondition	=	false;
		
		if(!empty($post)){
			$report_period		=	$post['report_period'];
			$report_interval	=	$post['report_interval'];
			
			
			
			if(in_array($report_period,array('hour','day','today','yesterday','week','last week','month','last month','custom'))){
				$dateTime = 's.date_time';
			}
			/**
			 * Set Where Condition
			 * */
			switch ($report_period) {
			    case "hour":
			        $whereCondition =  "$dateTime > DATE_SUB(NOW(), INTERVAL 1 HOUR)";
			        break;
			    case "day":
			    	//customData
					$custom_date	=   date('Y-m-d',strtotime($post['custom_date']));
			        $whereCondition =  "DATE($dateTime) = '$custom_date'";
			        break;
			    case "today":
			        $whereCondition =  "DATE($dateTime) = CURRENT_DATE()";
			        break;
			    case "yesterday":
			        $whereCondition =  "DATE($dateTime) = DATE(DATE_SUB(NOW(), INTERVAL 1 DAY))";
			        break;
			    case "week":
			        $whereCondition =  "DATE($dateTime) >= DATE(DATE_SUB(NOW(), INTERVAL 1 WEEK))";
			        break;
			    case "last week":
			        $whereCondition =  "DATE($dateTime) >= DATE(DATE_SUB(NOW(), INTERVAL 2 WEEK)) AND DATE($dateTime) <= DATE(DATE_SUB(NOW(), INTERVAL 1 WEEK))";
			        break;
			    case "month":
			        $whereCondition =  "MONTHNAME($dateTime) = MONTHNAME(DATE_SUB(NOW(), INTERVAL 0 MONTH))";
			        break;
			    case "last month":
			        $whereCondition =  "MONTHNAME($dateTime) = MONTHNAME(DATE_SUB(NOW(), INTERVAL 1 MONTH))";
			        break;
			    case "custom":
			    	
			    	//format start and end time for sql query
					$start_date		=   date('Y-m-d',strtotime($post['start_date']));
					$end_date		=   date('Y-m-d',strtotime($post['end_date']));
					
			        $whereCondition =  "DATE($dateTime) >= '$start_date' AND DATE($dateTime) <= '$end_date'";
			        break;    
			     
			}
			
			#TODO
			/**
			 * Set Group By Condition Basis on Interval Selection
			 * this method is applicable only for single user
			 * for multi user currently set for only line which is use after bar & pie as well
			 * */
			//if($post['report_type']!='line graph'){
			if($post['report_type']=='bar chart'){
				
				switch ($report_interval) {
				    case "live":
				        $whereCondition .=  "GROUP BY reportDate ORDER BY reportDate";
				        break;
				    case "minutes":
				         $whereCondition .=  "GROUP BY reportDate ORDER BY reportDate";
				        break;
				    case "hours":
				        $whereCondition .=  "GROUP BY DATE_FORMAT($dateTime, '%h %p') ORDER BY reportDate";
				        break;
				    case "days":
				        $whereCondition .=  "GROUP BY reportDate ORDER BY $dateTime";
				        break;
				    case "weeks":
				        $whereCondition .=  "GROUP BY WEEK($dateTime) ORDER BY WEEK($dateTime)";
				        break;
				    case "months":
				        $whereCondition .=  "GROUP BY reportDate ORDER BY $dateTime";
				        break;
				     
				}
			}else if($post['report_type']=='pie chart'){
				$whereCondition .=  " GROUP BY u.user_id ORDER BY $dateTime";
			}
			else{
				#TODO
				/**
				 * Gourp by Will be Intgere ID for overcome redundancy Agent Name,Capaign NAme,Tag Name
				 * GROUP BY full_name will be dynamic after client requiremnt
				 * */
				
				switch ($report_interval) {
				    case "live":
				        $whereCondition .=  "GROUP BY full_name ORDER BY reportDate";
				        break;
				    case "minutes":
				         $whereCondition .=  "GROUP BY full_name ORDER BY reportDate";
				        break;
				    case "hours":
				        $whereCondition .=  "GROUP BY full_name ORDER BY reportDate";
				        break;
				    case "days":
				        $whereCondition .=  "GROUP BY full_name ORDER BY $dateTime";
				        break;
				    case "weeks":
				        $whereCondition .=  "GROUP BY full_name ORDER BY WEEK($dateTime)";
				        break;
				    case "months":
				        $whereCondition .=  "GROUP BY full_name ORDER BY $dateTime";
				        break;
				     
				}
			}
			
		}
		
		return $whereCondition;
	}
	
	/**
	 * Draw Chart
	 * */
	function chartDraw($query, $report_type, $x_axis_label, $y_axis_label, $background_color,$report_period,$report_interval,$report_name,$chartWidth='750',$chartHeight='350'){
		
		if($query){
				$dataArr = $this->reports->get_chart_data($query);				
				//format data for chart
				$chartDataArr	=	array();
				//store maximum score
				$chartScoreVal   = array();
				//Agent FullName Array
				$agentFullName   = array();
				//line chart line name
				$lineChartLineName   = array();
				//line chart Area name
				$lineChartAxisNameArr   = array();
				//line chart Area name
				$lineChartAxisName   = array();
				//line chart agent name array
				$lineAgentNameArr	 = array();
				//set agent name for line
				$lineChartAgentName	=	"";
				
				$recordShownFrom = null;
				if(!empty($dataArr)){
					//data set  for each user
					
						/**
						 * Set Line Graph Data
						 * */
						if($report_type=='line graph'){
							
							/**
							 * Set Data for Time DIvision Basis for each user
							 * */
							$agentDataScoreArr	=	array();
							foreach($dataArr as $dataRow){
								
								$dataScoreArr	=	array();
								
								//explode data set to get agent data array for each user
								$totalRangeArr	  = explode('___---___',$dataRow['totalWithRange']);
								
								if(!empty($totalRangeArr)){
									//expldoe and get date range and dataCount for each user
									foreach($totalRangeArr as  $totalRangeRow){
										
										$totalRangeData	  = explode('---+++--',$totalRangeRow);
										if(!empty($totalRangeData)){
											
											$agentDataValue	=	$totalRangeData[0];
											//set type integer b/c when addition is done on this type it will remain integer for json encoding
											settype($agentDataValue, "integer");
											//check if same key exsist in array then sum up value for same key
											if(isset($dataScoreArr[$totalRangeData[1]])){
												$agentDataValue	=	$dataScoreArr[$totalRangeData[1]] + $agentDataValue;
											}
											$dataScoreArr[$totalRangeData[1]] = $agentDataValue;
											
										}
									}
								}
								
								$agentDataScoreArr[$dataRow['full_name']] = $dataScoreArr;
								
								if(isset($dataRow['recordShownMessage'])){
										$recordShownFrom  = $dataRow['recordShownMessage'];
								}
								
								$agentFullName[] 	  = $dataRow['AgentFullName'];
									
							}
							
							if(!empty($agentDataScoreArr)){
							
								/**
								 * for line chart set line name and area name
								 * */
								
								
								foreach($agentDataScoreArr as $recordAgentName=>$agentDataScoreRow){
									
									$lineAgentNameArr[]	 = "'$recordAgentName'";
									if(!empty($agentDataScoreRow)){									
										foreach($agentDataScoreRow as $reportDate=>$agentDataScoreRow1){
											$agent_rec	=	array();
											
											//create array for mantian none exsist axis element in multi line of agent by PHP end 
											$lineChartAxisNameArr[]  = $reportDate;
											//set line name for chart
											$lineChartAxisName[]	 = "'$reportDate'";
											$agent_rec[0]	= $reportDate;
											$agent_rec[1]	= $agentDataScoreRow1;
											
											$chartDataArr[$recordAgentName][]	  = $agent_rec;
										}
										
									}
								}
							
							}
							
							/**
							 * Remove Commmon Key Pair
							 * */
							$lineChartAxisNameArr	= array_unique($lineChartAxisNameArr);
							$lineChartAxisName		= array_unique($lineChartAxisName);
							
							/**
							 * Set Line Chart Data
							 * */
							
							sort($lineChartAxisName);
							$lineChartAxisName	=	implode(",",$lineChartAxisName);
							$lineChartAgentName	=	implode(",",$lineAgentNameArr);
							
//							var_debug($agentDataScoreArr);exit();
						}else{
					
							foreach($dataArr as $dataRow){
								
								if($report_type=='pie chart'){
									$reportDate		  = $dataRow['full_name'];
								}else {
									$reportDate		  = $dataRow['reportDate'];
								}
									#$reportDate		  = $dataRow['reportDate'];
									$totalSurveyScore = $dataRow['totalSurveyScore'];
									$chartDataArr[]	  = "['$reportDate', $totalSurveyScore]";
									$chartScoreVal[]  = $totalSurveyScore;
								
									if(isset($dataRow['recordShownMessage'])){
										$recordShownFrom  = $dataRow['recordShownMessage'];
									}
									
									$agentFullName[] 	  = $dataRow['AgentFullName'];
									
							}
						}
				}
				
//				var_debug($chartDataArr);exit();
				
				/**
				 * get agent Unique Name from DB raw 
				 * */
				$agentFullNameStr	=	implode(",",$agentFullName);
				$agentFullName		=	implode(", ",array_unique(explode(",",$agentFullNameStr)));
				
				
				
				if(!empty($chartDataArr)||!empty($lineAgentNameArr)){
					
					/**
					 * Validate Data for line chart graph if data is only one then we set first initial point is 0,0
					 * because for line we must have a 2 points
					 * */
					if($report_type=='line graph'){
						$chartDataArr = $this->validateLineChartData($chartDataArr,$lineChartAxisNameArr);
						
						$colors 		= $this->chartColor();	
						$colorThemes 	= implode(",",$colors);
						
						$chartData		= json_encode($chartDataArr);
//						var_debug($chartData);exit();
					}else{
					
						//get color theme array w.r.t to array size
						$colors 		= $this->chartColor();	
						$colorThemes 	= implode(",",array_slice($colors, 0, count($chartDataArr)));
						$chartData		= implode(",",$chartDataArr);
					}
					//get max Y interval w.r.t score
					$maxScore = $this->getMaxInterval($chartScoreVal);
					
					/**
					 * Save Session Requested Chart Data for live chart
					 * */
					$this->session->unset_userdata('live_requested_data');
					if($report_interval=='live'){
						
						$requestedChartData = array(
			                  	 	'live_query_session'  => "$query",
			                   	 	'report_type'    	  => "$report_type",
									'x_axis_label'     	  => "$x_axis_label",
									'y_axis_label'    	  => "$y_axis_label",
									'background_color'    => "$background_color",
									'report_period'       => "$report_period",
									'report_interval'     => "$report_interval",
									'report_name'         => "$report_name",
			               );
			               
						$this->session->set_userdata('live_requested_data', $requestedChartData);
					}
					
					//get line chart formatedData
					//set data for chart
					$data['report_type']   		= ucwords($report_type);
					$data['chartData']     		= $chartData;
					$data['colorThemes']  		= $colorThemes;
					$data['lineChartAxisName']	= $lineChartAxisName;
					$data['lineChartAgentName']	= $lineChartAgentName;
					$data['maxScore']      		= $maxScore;
					$data['background_color']   = $background_color;
					$data['report_date']        = date('d/m/Y',strtotime(date('c')));
					$data['report_period']      = $report_period;
					$data['report_interval']    = $report_interval;
					$data['dateRange']          = $recordShownFrom;
					$data['report_name']		= $report_name;
					$data['chartWidth']			= $chartWidth;
					$data['chartHeight']		= $chartHeight;
					$data['X_Axis']		   		= $this->getAxisName($x_axis_label);
					$data['Y_Axis']		   		= $this->getAxisName($y_axis_label);
					$data['graphTitle']	   		= $this->getAxisName($y_axis_label)." Calculation for ".$agentFullName;
					
				    $this->load->view('reports/admin/reportChart', $data);
				}else{
					
					 $data['errMessage']		 = '<div id="message" class="error">No Record Found</div>';
					 $data['report_date']        = date('d/m/Y',strtotime(date('c')));
					 $data['report_period']      = $report_period;
					 $data['report_interval']    = $report_interval;
					 $data['dateRange']          = $recordShownFrom;
					 $data['report_name']		 = $report_name;
					 $data['report_type']   	 = ucwords($report_type);
					 $data['dateRange']          = $recordShownFrom;
					 
					/**
					 * Save Session Requested Chart Data for live chart
					 * */
					$this->session->unset_userdata('live_requested_data');
					if($report_interval=='live'){
						
						$requestedChartData = array(
			                  	 	'live_query_session'  => "$query",
			                   	 	'report_type'    	  => "$report_type",
									'x_axis_label'     	  => "$x_axis_label",
									'y_axis_label'    	  => "$y_axis_label",
									'background_color'    => "$background_color",
									'report_period'       => "$report_period",
									'report_interval'     => "$report_interval",
									'report_name'         => "$report_name",
			               );
			               
						$this->session->set_userdata('live_requested_data', $requestedChartData);
					}
					 
					  $this->load->view('reports/admin/reportChart', $data);
				}
		}
	}
		
	/**
	 * Live Chart Update
	 * */
	
	function liveChartUpdate(){
		
		
		if($this->session->userdata('live_requested_data')){
			
			$live_requested_data	=	$this->session->userdata('live_requested_data');
			
			if(!empty($live_requested_data)){
				
				$query				=	$live_requested_data['live_query_session'];
				$report_type		=	$live_requested_data['report_type'];
				$x_axis_label		=	$live_requested_data['x_axis_label'];
				$y_axis_label		=	$live_requested_data['y_axis_label'];
				$background_color	=	$live_requested_data['background_color'];
				$report_period		=	$live_requested_data['report_period'];
				$report_interval	=	$live_requested_data['report_interval'];
				$report_name		=	$live_requested_data['report_name'];
				
				$this->chartDraw($query, $report_type, $x_axis_label, $y_axis_label, $background_color,$report_period,$report_interval,$report_name);
			}
		}
	}
	
	/**
	 * Chart Color
	 * #TODO Need to increase number of color for charts
	 * */
	function chartColor(){
		
			return array(
						1=>"'#99CDFB'",
						2=>"'#3366FB'",
						3=>"'#2121D1'",
						4=>"'#F8CC00'",
						5=>"'#F89900'",
						6=>"'#F76600'",	
						9=>"'#2600D9'",
						10=>"'#C23D99'",
						11=>"'#BD42A6'",
						12=>"'#D12E73'",
						13=>"'#E8732E'",
						14=>"'#DEA642'",	
						15=>"'#99CDFA'",
						16=>"'#3362FB'",
						17=>"'#0000EA'",
						18=>"'#F8CC11'",
						19=>"'#F89922'",
						20=>"'#F76633'",
						21=>"'#2644D9'",
						22=>"'#C23D34'",
						23=>"'#BD32A1'",
						24=>"'#D14E76'",
						25=>"'#E3124E'",
						26=>"'#DEA620'",
						27=>"'#DEA620'",
				);
	}
	
	/*
	 * @author:	Arshad
	 * @name:	getAxisName
	 */
	function getAxisName($labelKey){		
		
		$axisLabelArray = array(
									'daily' 			=> 'Daily',
									'weekly' 			=> 'Weekly',
									'monthly' 			=> 'Monthly',
									'yearly' 			=> 'Yearly'
		
								);
		//get y Axis Label
		$yAxisColoumnList	=	$this->yAxisColoumnList();
		
		$axisLabelArray	=	array_merge($yAxisColoumnList,$axisLabelArray);
		if(isset($axisLabelArray["$labelKey"])){						
			return $axisLabelArray["$labelKey"];
		}
		return $labelKey; 
	}
	
	/**
	 * Set Y Axis MID-Point
	 * */
	
	function getMaxInterval($chartScoreVal){
		
		//get 10% max score for bar interval
		$maxScore = 0;
		if(!empty($chartScoreVal)){
			
			$maxScore   = max($chartScoreVal); #get max value from Y-Axis
			$percentage = 10; #percentage for increase height
			$new_width  = ($percentage / 100) * $maxScore;
			$maxScore   = $maxScore+$new_width;
		}
		return $maxScore;
	}
	
	/**
	 * Validate Line Chart Data 
	 * */
	
	function validateLineChartData($data,$lineChartAxisNameArr){
		
		$validatedLineData	 = $data;
		
		/**
		 * For X-Axis Labeling for all user into one line
		 * */
		if(!empty($validatedLineData)){
			
			//Maintain agent Line data for non-exsist axis value like data is not present for some axis then we set 0 value   
			$zeroValueNotAxis		= array();
			$agentFormatedData	 	= array();
			
			/**
			 * Set Time Period Zero fpr those user whose reocrd are not exsist in for same time onterval for that
			 * first get time of exisst ata and then take a difference of all user merge time interval the diff array of 
			 * time interval indicate that record for this interavl are not avaiable so we set default zero for this type data 
			 * */
			//set X-Axis label only once so that is will not display as bold value
   			$count = 0;
			foreach($validatedLineData as $agentName => $validatedLineRow){
				$agentFormatedDataArr	= array();
				if(!empty($validatedLineRow)){
					
					$exsistKeyVal	=	array();
					$exsistRegionArray	=	array();
					foreach($validatedLineRow as $validatedLineRow1){
						//if key are not zero
						$exsistKeyVal[] 		= $validatedLineRow1[0];
						$exsistRegionArray[$validatedLineRow1[0]]	= $validatedLineRow1;
						
					}
					//get different of array for putting value zero on none exsist timep eriod
					$compare_1_To_2 	= array_diff($exsistKeyVal,$lineChartAxisNameArr);
    				$compare_2_To_1 	= array_diff($lineChartAxisNameArr,$exsistKeyVal);
   					$difference_Array 	= array_merge($compare_1_To_2,$compare_2_To_1);
   					
   					$nonExsistRegionArray	=	array();
   					//set zero value for none exsisting value
   					if(!empty($difference_Array)){
   						
   						
   						foreach($difference_Array as $difference_Row){
   							$agentRecord[0] = $difference_Row;
   							$agentRecord[1] = 0;
   							
   							$nonExsistRegionArray[$difference_Row] = $agentRecord;
   						}
   					}
   					
   					/**
   					 * Format and SOrt Agent Data
   					 * */
   					$agentFormatedDataArr	=	array_merge($exsistRegionArray,$nonExsistRegionArray);
   					ksort($agentFormatedDataArr);
//   					var_debug($agentFormatedDataArr);
		
//   					var_debug($agentFormatedDataArr);
   					//after sort keybase value remove keys from record so that json encode data will be displayable on chart
   					if(!empty($agentFormatedDataArr)){
   						$agentFormatedDataArr1 = array();
   						
   						$agentFormatedLineData	=	array();
   						foreach($agentFormatedDataArr as $agentFormatedDataArrRow){
   							
   							$x_axisLabel		=	"";
   							if($count==0){
   								$x_axisLabel	=	$agentFormatedDataArrRow[0];
   							}
   							
   							$agentFormatedLineData[0] = $x_axisLabel;
   							$agentFormatedLineData[1] = $agentFormatedDataArrRow[1];
   							$agentFormatedDataArr1[]  = $agentFormatedLineData;
   							
   							
   						}
   					}
   					
   					$agentFormatedData[$agentName]	=	$agentFormatedDataArr1;
					$count++;
				}
			}
			
		}
//		exit();
		//set zero value for drwaing line some record which are not exsist OR has one record
		$data = $agentFormatedData;
		if(!empty($data)&&count($data)>0){
			
			$emptyDataArray[0]		= '0';
			$emptyDataArray[1]		= 0;
			$emptyDataArraySet[]	= $emptyDataArray;
			foreach($data as $userName=>$dataRow){
			
				//if data for line chart is only one
				if(count($dataRow)==1){
					
					$agentFormatedData[$userName] = array_merge($emptyDataArraySet,array($dataRow[0]));
				}
				//if no record found for user
				if(count($dataRow)==0){
					$agentFormatedData[$userName] = array_merge($emptyDataArraySet,$emptyDataArraySet);
				}
			}
			
		}
//		var_debug($agentFormatedData);
//		exit();
		
		
		return $agentFormatedData;
	}
	
	/**
	 * Y-Axis Chart COloumn NAme List
	 * */
	
	function yAxisColoumnList(){
		# mapping array for DB tables and Data Control 
		$cols = array(
					's.q1'				=>'Q1 Score',
					's.q2'				=>'Q2 Score',
					's.q3'				=>'Q3 Score',
					's.q4'				=>'Q4 Score',
					's.q5'				=>'Q5 Score',
					's.total_score'		=>'Total Score',
					's.average_score'	=>'Average Score',
					);
					
		return $cols;
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	view_report
	 */
	public function view_report()
	{
		if ($this->uri->segment(4) && ($this->uri->segment(4) == 'full_view') && ($this->access != COMP_AGENT) )
		{
			$report_id = $this->uri->segment(3);
			$data['report'] = $this->reports->get_report($report_id);
			$this->load->view('reports/view_report', $data);
			
		} elseif ($this->uri->segment(3)) {
			
			$report_id = $this->uri->segment(3);
			
			if (!empty($report_id) && is_numeric($report_id))
			{
				$report = $this->reports->get_my_report($report_id);

				if (!empty($report)){
					$data['report'] = $report;

					if ($this->uri->segment(4)) {
						$this->load->view('reports/view_report', $data);
					} else {
						$this->load->template('reports/view_report', $data);
					}
				} else {
					$this->load->template('reports/access_denied');
				}
			}
		}
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	access_denied
	 */
	public function access_denied(){
		$this->load->template('reports/access_denied');
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	not_found
	 */
	public function not_found(){
		$this->load->template('reports/not_found');
	}
	
	/**
	 * @author Arshad
	 * @name Update Report 
	 * */
	
	function updateReport()
	{
		if ($this->access != COMP_AGENT)
		{
			$reportId = $this->uri->segment(3);
			//if url has report id then we process request 
			if($reportId && is_numeric($reportId)){
				
				#set report id
				$data['reportId']				= $reportId;
				
				# Get all Report Types
				$data['report_types'] 			= $this->reports->get_report_types();
				$data['report_periods'] 		= $this->reports->get_report_periods();
				$data['report_intervals'] 		= $this->reports->get_report_intervals();
				$data['yAxisColoumnList'] 		= $this->yAxisColoumnList();
				
				#Data Control Column
				$dataControlColumn			= $this->dataControlColumn();
				
				
				//get report data
				$reportData	=	$this->reports->get_report($reportId);
				$data['reportData'] 		= $reportData;
				
				
				if(!empty($reportData)){
					
				#select data control array 
				$selectedCols = $reportData['columns_name'];
				# create report column array
				$selectedDataControl = explode(",", str_replace("_", " ", ucwords(trim($selectedCols))));
				
				//remaining data control array
				$dataControlColumn			=	array_diff($dataControlColumn,$selectedDataControl);
				
				
				/**
				 * Unserialize Condition,Detail,Filter Array for conidtion create section 
				 * */
				
				$data['query_condition']	=	unserialize($reportData['query_condition']);
				$data['query_data_type']	=	unserialize($reportData['query_data_type']);
				$data['query_filter']		=	unserialize($reportData['query_filter']);
				$data['query_detail']		=	unserialize($reportData['query_detail']);
				
				$data['dataControlColumn']		=	$dataControlColumn;
				$data['selectedDataControl']	=	$selectedDataControl;
				$data['reportUpdate']			=   true;
				$data['general']				=	$this->general;
				$data['score']					=	$this->score;
				$data['detail']					=	$this->detail;
				
					$this->load->template('reports/admin/edit', $data);
				}else{
					echo '<div id="message" class="error">No Record Found</div>';
				}
			}
		} else {
			redirect('reports');
		}
	}

	/*
	 * @name:	delete
	 * @author:	Muhammad Sajid
	 */
	public function delete()
	{
		$report_id = $this->uri->segment(3);
		$acc_id = $this->access;
		$comp_id = $this->comp_id;
		$user_id = $this->user_id;
		
		# delete from reports table
		$this->db->where('report_id', $report_id);
		$this->db->where('comp_id', $comp_id);
		$this->db->where('created_by', $user_id);
		if ($this->db->delete('reports'))
		{
			# delete from dashboard table
			for ($n=1; $n<=4; $n++)
			{
	    		# get report privacy level
	    		$rep = $this->reports->get_report($report_id);
	    		$privacy = $rep['privacy'];
	    			
	    		if ($acc_id == COMP_AGENT && $privacy == 'private'){
	    			// Do nothing!
				} else {
		    		$sql = "UPDATE dashboards
							SET qdr_{$n} = IF (qdr_{$n} = {$report_id}, 0, qdr_{$n}) 
							WHERE comp_id = {$comp_id}";
		    		$this->db->query($sql);
				}			    			
	    	}
	    	$this->session->set_flashdata('message', '<div id="message" class="update">Report deleted successfully</div>');
		} else {
			$this->session->set_flashdata('message', '<div id="message" class="error">Error occur while deleting report</div>');
		}
		//redirect('reports');
	}
	
	/**
	 * @author Arshad
	 * @name get coloumn name for data control
	 * */
	
	function dataControlColumn(){
		
		$cols = array(
						'Agent PIN',
						'Agent Name',
						'Dialed Number',
						'CLI',
						'Campaign',
						'Q1 Score',
						'Q2 Score',
						'Q3 Score',
						'Q4 Score',
						'Q5 Score',
						'Total Score',
						'Total Surveys',
						'Average Score',
						'Recording',
						'Transcription',
						'Sentiment',
						'Notes',
						'Tag',
					);
					
		return $cols;
	}
	
	/**
	 * @author Arshad
	 * @name DB Mapping Column
	 * */
	
	function dbMappingColumn(){
		
		return array(
						'agent_pin'			=> 'user_pin',
						'agent_name'		=> 'full_name',
						'dialed_number'		=> 'dialed_number',
						'cli'				=> 'cli',
						'campaign'			=> 'camp_name',
						'q1_score'			=> 'q1',
						'q2_score'			=> 'q2',
						'q3_score'			=> 'q3',
						'q4_score'			=> 'q4',
						'q5_score'			=> 'q5',
						'total_score'		=> 'total_score',
						'average_score'		=> 'average_score',
						'recording'			=> 'recording',
						'transcription'		=> 'transcriptions_text',
						'sentiment'			=> 'sentiment_score',
						'notes'				=> 'comments',
						'tag'				=> 'tag_name',
						'total_surveys'		=> 'total_surveys'
					);
	}
	
	/**
	 * @author Arshad
	 * @Name Copy Report
	 * */
	
	function copyReport(){
		$report_id = $this->uri->segment(3);
		//if url has report id then we process request 
		if($report_id && is_numeric($report_id)){
			
			//get report data
			$reportData	=	$this->reports->get_report($report_id);
			
			if(!empty($reportData)){
				
				$query	=	$reportData['report_query'];
				
				//change report name
				$reportData['report_name']	= 	$reportData['report_name']."_".strtotime(date('c'));
				
				//unserialize data for saving record with same method of model which serialize it again
				$reportData['condition']	=	unserialize($reportData['query_condition']);
				$reportData['data_type']	=	unserialize($reportData['query_data_type']);
				$reportData['filter']		=	unserialize($reportData['query_filter']);
				$reportData['detail']		=	unserialize($reportData['query_detail']);
				
				$reportData['reports_fields']	= 	$reportData['columns_name'];
				$reportData['custom_date']		= 	$reportData['report_period_date'];
				$reportData['start_date']		= 	$reportData['custom_start_date'];
				$reportData['end_date']			= 	$reportData['custom_end_date'];
				//set report unpublished
				$reportData['published']		= 	0;
				
				//walboard remove from array if value is zero
				if($reportData['wallboard']==0){
					unset($reportData['wallboard']);
				}
				//dashboard remove from array if value is zero
				if($reportData['dashboard']==0){
					unset($reportData['dashboard']);
				}
				$this->reports->saveReportData($reportData,$query);
				$this->session->set_flashdata('reportSuccessMessage', 'Report Copied Successfully!');
				
			}
		}
	}
	
	
	/**
	 * @author Arshad
	 * @Method Live Data Report Update
	 * */
	
	function liveDataReportUpdate(){
		
		if($this->session->userdata('live_requested_data')){
			
			$live_requested_data	=	$this->session->userdata('live_requested_data');
			
			if(!empty($live_requested_data)){
				
				$query					=	$live_requested_data['live_query_session'];
				$report_type			=	$live_requested_data['report_type'];
				$background_color		=	$live_requested_data['background_color'];
				$report_period			=	$live_requested_data['report_period'];
				$report_interval		=	$live_requested_data['report_interval'];
				$report_name			=	$live_requested_data['report_name'];
				$selectedColoumnHeading	=	$live_requested_data['selectedColoumnHeading'];
				//draw data
				dataReportDraw($query, $report_type,$background_color,$report_period,$report_interval,$report_name,$selectedColoumnHeading);
			}
		}
	}
	
	
	/**
	 * Data Report View From List
	 * */
	
	function data_report_view(){
		
		if ($this->uri->segment(3)) {
			
			$report_id = $this->uri->segment(3);
			
			if (!empty($report_id) && is_numeric($report_id))
			{
				
				//data report not shown to agent
				if (isset($this->session->userdata['access'])&&$this->session->userdata['access'] != COMP_AGENT){
					
					$report	=	$this->reports->get_report($report_id);
					$data['report'] = $report;

					if ($this->uri->segment(4)) {
						$this->load->view('reports/view_data_report', $data);
					} else {
						$this->load->template('reports/view_data_report', $data);
					}
				} else {
					$this->load->template('reports/access_denied');
				}
			}
		}
	
	}
	
	/**
	 * Detail Report View From List
	 * */
	
	function detail_report_view(){
		
		if ($this->uri->segment(3)) {
			
			$report_id = $this->uri->segment(3);
			
			if (!empty($report_id) && is_numeric($report_id))
			{
				
				//data report not shown to agent
				if (isset($this->session->userdata['access'])&&$this->session->userdata['access'] != COMP_AGENT){
					
					$report	=	$this->reports->get_report($report_id);
					$data['report'] = $report;

					$this->load->template('reports/view_detail_report', $data);
				} else {
					$this->load->template('reports/access_denied');
				}
			}
		}
	
	}
	
	//play recording
	function recording_play(){
		if(!empty($_POST)&&isset($_POST['fileName'])){
			
			$fileName				= $_POST['fileName'];
			$data['fileName']		=	$fileName;
			$data['extraScripts']   = transcribe_js(true);
						
			$this->load->view('reports/recording_play',$data);
		}
	}
}