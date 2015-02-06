<?php
/**
 * @author Arshad
 * */
	function calc_sentimentscore($str){
		switch ($str) {
			case 'hp':
				return 2;
				break;
			case 'p':
				return 1;
				break;
			case 'n':
				return 0;
				break;
			case 'neg':
				return -1;
				break;
			case 'hn':
				return -2;
				break;
			case 'mpn':
				return 0;
				break;
			default:
				return 0;
				break;
		}
	}

	/**
	 * Get Where condition on basis of data X-Axis Select i.e yearly,monthly, daily
	 * 
	 * */
	
	function dataWhereCondition($post){
		
		$whereCondition	=	false;
		$rept_fields = explode(",",$post['reports_fields']);
		if(!empty($post)){
			$report_period		=	$post['report_period'];
			$report_interval	=	$post['report_interval'];
			
			if(in_array($report_period,array('current hour','day','today','yesterday','current week','last week','current month','last month','custom'))){
				$dateTime = 's.date_time';
			}
			/**
			 * Set Where Condition
			 * */

			switch ($report_period) {
				case "current hour":				  
					$whereCondition = ' TIMEDIFF(DATE_FORMAT(s.date_time, "%Y-%m-%d %H:%i"),DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 HOUR), "%Y-%m-%d %H:%i"))>=0 ';				   
					break;
				case "day":
					//customData
					$custom_date	=   date('Y-m-d',strtotime($post['custom_date']));
					$whereCondition =  " DATE($dateTime) = '$custom_date' ";
					break;
				case "today":
					$whereCondition =  "DATE($dateTime) = CURRENT_DATE()";
					break;
				case "yesterday":
					$whereCondition =  "DATE($dateTime) = DATE(DATE_SUB(NOW(), INTERVAL 1 DAY))";
					break;
				case "current week":
					$whereCondition =  "DATE($dateTime) >= DATE(DATE_SUB(NOW(), INTERVAL 1 WEEK))";
					break;
				case "last week":
					$whereCondition =  "DATE($dateTime) >= DATE(DATE_SUB(NOW(), INTERVAL 2 WEEK)) AND DATE($dateTime) <= DATE(DATE_SUB(NOW(), INTERVAL 1 WEEK))";
					break;
				case "current month":
					$whereCondition =  "MONTHNAME($dateTime) = MONTHNAME(NOW())";
					break;
				case "last month":
					$whereCondition =  "MONTHNAME($dateTime) = MONTHNAME(DATE_SUB(NOW(), INTERVAL 1 MONTH))";
					break;
				case "custom":					
					//format start and end time for sql query
					$start_date		= date('Y-m-d H:i',strtotime($post['start_date'])); //$post['start_date'];// date('d/m/Y H:i',strtotime($post['start_date']));
					$end_date		= date('Y-m-d H:i',strtotime($post['end_date']));//$post['end_date'];//  date('d/m/Y H:i',strtotime($post['end_date']));
				
				   // $whereCondition =  "DATE_FORMAT($dateTime,'%d/%m/%Y %H:%i') >= '$start_date' AND DATE_FORMAT($dateTime,'%d/%m/%Y %H:%i') <= '$end_date' ";
					$whereCondition =  " s.date_time BETWEEN CAST('$start_date' as date) AND CAST('$end_date' as date)";
					break;
			}
			
				/**
				 * Set Group By Condition Basis on Interval Selection
				 * */
				
				switch ($report_interval) {
					case "live":
						if(in_array("Campaign", $rept_fields) ){
							$whereCondition .=  "GROUP BY camp_name,  s.user_id  ORDER BY reportDate";
						}
						else{
							$whereCondition .=  "GROUP BY  s.user_id  ORDER BY reportDate";
						}
						break;
					case "minutes":
						if(in_array("Campaign", $rept_fields) ){
							$whereCondition .=  "GROUP BY camp_name,DATE_FORMAT($dateTime, '%Y-%m-%d %H:%i'), s.user_id   ORDER BY reportDate";
						}
						else{
							$whereCondition .=  "GROUP BY DATE_FORMAT($dateTime, '%Y-%m-%d %H:%i'), s.user_id	ORDER BY reportDate";
						}
						break;
					case "hours":
						if(in_array("Campaign", $rept_fields) ){
							$whereCondition .=  "GROUP BY camp_name,DATE_FORMAT($dateTime, '%Y-%m-%d %H') , s.user_id  ORDER BY $dateTime";
						}else{
							$whereCondition .=  "GROUP BY DATE_FORMAT($dateTime, '%Y-%m-%d %H') , s.user_id  ORDER BY $dateTime";
						}
						break;
					case "days":
						if(in_array("Campaign", $rept_fields) ){
							$whereCondition .=  "GROUP BY camp_name,DATE_FORMAT($dateTime,'%Y-%m-%d') , s.user_id  ORDER BY $dateTime";
						}else{
							$whereCondition .=  "GROUP BY DATE_FORMAT($dateTime,'%Y-%m-%d') , s.user_id  ORDER BY $dateTime";
						}
						break;
					case "weeks":
						if(in_array("Campaign", $rept_fields) ){
							$whereCondition .=  "GROUP BY camp_name,WEEK($dateTime), s.user_id  ORDER BY WEEK($dateTime)";
						}else{
							$whereCondition .=  "GROUP BY WEEK($dateTime), s.user_id  ORDER BY WEEK($dateTime)";
						}
						break;
					case "months":
						if(in_array("Campaign", $rept_fields) ){
							$whereCondition .=  "GROUP BY camp_name,DATE_FORMAT($dateTime,'%Y-%m'), s.user_id  ORDER BY $dateTime";
						}else{
							$whereCondition .=  "GROUP BY WEEK($dateTime), s.user_id  ORDER BY WEEK($dateTime)";
						}
						break;
					 
				}
			
			
		}
		
		return $whereCondition;
	}
	
	
	/**
	 * Get Data Coloumn
	 * 
	 * */
	function getDataColumn($post,$select){
		
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
			$start_date		=	date('Y-m-d H:i',strtotime($post['start_date']));
			$end_date		=	date('Y-m-d H:i',strtotime($post['end_date']));
			
			if(in_array($report_period,array('current hour','day','today','yesterday','current week','last week','current month','last month','custom'))){
				$dateTime = 's.date_time';
			}
			
			
			/**
			 * Set Grouped Selected Coloumn for display on data table w.r.t to particualr agent
			 * */
			$selectArr		=	explode(",",$select);
			$selectedConcat	=	array("full_name",",DAYNAME($dateTime)");
		
			if(!empty($selectArr))
			{
//				$count= 0;
				foreach($selectArr as $selectRow)
				{
					
//					$commaVal	=	"";
//					if($count>0){
					if($selectRow=="avg(q1) as q1 " || $selectRow=="avg(q2) as q2 " || $selectRow=="avg(q3) as q3 " || $selectRow=="avg(q4) as q4 " || $selectRow=="avg(q5) as q5 " || $selectRow=="avg(total_score) as total_score " ){
							$temporary_variable= explode("as ", $selectRow);
							$commaVal	=	",";
							$selectedConcat[]	=	$commaVal."IFNULL($temporary_variable[1], 'Not Found')";

					}
					else if( $selectRow != "GROUP_CONCAT(DISTINCT tag_name) AS tag_name"  ){
						$commaVal	=	",";
//					}
						
						$selectedConcat[]	=	$commaVal."IFNULL($selectRow, 'Not Found')";
					}
//					$count++;
				}
			}
			$selectedConcat	=	implode(",'---+++--'",$selectedConcat);
			#TODO
			
			/**
			 * Coloumn Alias totalSurveyScore will be remove after implementation of multi agent chart for PIE & BAR
			 * for multi agent i am using `totalWithRange` which contain all information related to agent we have to parse that for PIE & BAR 
			 * */
			
			//get cahrt coloumn result on basis of selection 
			switch ($report_interval) {
				case "live":
					$liveInterval	=	LIVE_INTERVAL;
					$chartColoumn[] = "date_time AS reportDate";
					//$chartColoumn[] = "DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(date_time) - MOD(UNIX_TIMESTAMP(date_time), $liveInterval)), '%d-%M %H:%i') AS reportDate";
					$chartColoumn[] = "GROUP_CONCAT(CONCAT($selectedConcat,'---+++--', Date_format(From_unixtime(Unix_timestamp(date_time) - Mod( Unix_timestamp(date_time), $liveInterval)),'%H:%i'),'---+++--',s.sur_id,'---+++--') SEPARATOR '___---___') AS totalWithRange";
					break;
				case "minutes":
					$chartColoumn[] = "DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(date_time) - MOD(UNIX_TIMESTAMP(date_time), 300)), '%M-%d %H:%i') AS reportDate";
					$chartColoumn[] = "GROUP_CONCAT(CONCAT($selectedConcat,'---+++--', Date_format(From_unixtime(Unix_timestamp(date_time) - Mod( Unix_timestamp(date_time), 300)),'%H:%i'),'---+++--',s.sur_id,'---+++--') SEPARATOR '___---___') AS totalWithRange";
					break;
				case "hours":
					$chartColoumn[] = "CONCAT(DATE_FORMAT(DATE_SUB($dateTime, INTERVAL 1 HOUR), '%H:%i'),' to ',DATE_FORMAT(DATE_SUB($dateTime, INTERVAL 0 HOUR), ' %M-%d %H:%i'))   AS reportDate ";
					$chartColoumn[] = "GROUP_CONCAT(CONCAT($selectedConcat,'---+++--',CONCAT(DATE_FORMAT(DATE_SUB(s.date_time, INTERVAL 1 HOUR), '%H:%i'),' to ',DATE_FORMAT(DATE_SUB(s.date_time, INTERVAL 0 HOUR), '%H:%i')),'---+++--',s.sur_id,'---+++--') SEPARATOR '___---___') AS totalWithRange";
					break;
				case "days":
					$chartColoumn[] = "CONCAT(DATE_FORMAT($dateTime,'%M-%d '),DAYNAME($dateTime)) AS reportDate";
					$chartColoumn[] = "GROUP_CONCAT(CONCAT($selectedConcat,'---+++--', DAYNAME(s.date_time),'---+++--',s.sur_id,'---+++--') SEPARATOR '___---___') AS totalWithRange";
					break;
				case "weeks":
					$chartColoumn[] = "CONCAT(DATE_FORMAT(DATE_ADD(s.date_time, INTERVAL(1-DAYOFWEEK(s.date_time)) DAY),'%M-%d'),' - ',DATE_FORMAT( DATE_ADD(s.date_time, INTERVAL(7-DAYOFWEEK(s.date_time)) DAY),'%M-%d'))  AS reportDate";
					$chartColoumn[] = "GROUP_CONCAT(CONCAT($selectedConcat,'---+++--', CONCAT(DATE_FORMAT(DATE_ADD(s.date_time, INTERVAL(1-DAYOFWEEK(s.date_time)) DAY),'%m-%d'),' - ',DATE_FORMAT(DATE_ADD(s.date_time, INTERVAL(7-DAYOFWEEK(s.date_time)) DAY),'%m-%d')),'---+++--',s.sur_id,'---+++--') SEPARATOR '___---___') AS totalWithRange";
					break;
				case "months":
					$chartColoumn[] = "DATE_FORMAT(s.date_time,'%Y-%M') AS reportDate";
					$chartColoumn[] = "GROUP_CONCAT(CONCAT($selectedConcat,'---+++--', MONTHNAME(s.date_time),'---+++--',s.sur_id,'---+++--') SEPARATOR '___---___') AS totalWithRange";
					break;				 
			}			
			
		//get chart coloumn result text on basis of selection 
			switch ($report_period) {
				case "current hour":
					$chartColoumn[]	= "CONCAT('Record Shown from ',DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 HOUR),'%H:%i'),' to ' , DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 0 HOUR),'%H:%i')) AS recordShownMessage";
					break;
				case "day":
					$custom_date	=  $post['custom_date'];
					$chartColoumn[]	= "CONCAT('Record Shown for ', DATE_FORMAT('$custom_date','%Y-%m-%d')) AS recordShownMessage";
					break;
				case "today":
					$chartColoumn[]	= "CONCAT('Record Shown for ', DATE_FORMAT(CURRENT_DATE(),'%Y-%m-%d')) AS recordShownMessage";
					break;
				case "yesterday":
					$chartColoumn[]	= "CONCAT('Record Shown for ', DATE_FORMAT(DATE(DATE_SUB(NOW(), INTERVAL 1 DAY)),'%Y-%m-%d')) AS recordShownMessage";
					break;
				case "current week":
					$chartColoumn[]	= "CONCAT('Record Shown from ', DATE_FORMAT(DATE(DATE_SUB(NOW(), INTERVAL 1 WEEK)),'%Y-%m-%d') ,' to ' , DATE_FORMAT(DATE(NOW()),'%Y-%m-%d')) AS recordShownMessage";
					break;
				case "last week":
					$chartColoumn[]	= "CONCAT('Record Shown from ', DATE_FORMAT(DATE(DATE_SUB(NOW(), INTERVAL 2 WEEK)),'%Y-%m-%d') ,' to ' , DATE_FORMAT(DATE(DATE_SUB(NOW(), INTERVAL 1 WEEK)) ,'%Y-%m-%d')) AS recordShownMessage";
					break;
				case "current month":
					$chartColoumn[]	= "CONCAT('Record Shown for ',MONTHNAME(DATE_SUB(NOW(), INTERVAL 0 MONTH)),',',YEAR(s.date_time)) AS recordShownMessage";
					break;
				case "last month":
					$chartColoumn[]	= "CONCAT('Record Shown for ',MONTHNAME(DATE_SUB(NOW(), INTERVAL 1 MONTH)),',',YEAR(s.date_time)) AS recordShownMessage";
					break;
				case "custom":
					$chartColoumn[]	= "CONCAT('Record Shown from ',DATE_FORMAT('$start_date','%Y-%m-%d') ,' to ' , DATE_FORMAT('$end_date','%Y-%m-%d')) AS recordShownMessage";
					break;
				 
			}
			
			
			/**
			 * get Shown Record Range For Show in CHart Detail View  
			 * */
			
			$chartColoumn[]	= 'GROUP_CONCAT(DISTINCT(full_name)) AS AgentFullName';
			$chartColoumn[]	= 'full_name';
			//$chartColoumn[] = $y_axis_label;			
			//var_debug($selectRow);exit;
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
	 * Draw Data Report
	 * */
	
	function dataReportDraw($query, $report_type,$background_color,$report_period,$report_interval,$report_name,$selectedColoumnHeading,$requestedFromList = null,$reportId	=	null)
	{		
		if($query)
		{
				$ci = &get_instance();
				$s=$ci->load->model('surveys_model');
				for ($i = 0; $i<10; $i++){
				//	$ci->surveys_model->insert_survey(-1,30,rand(1,121));
					//$ci->surveys_model->insert_survey(-1,31,rand(1,121));
				}
				$dataArr = $ci->reports->get_chart_data($query);

				//data set by agent name
				$agentRecordData	=	array();
				$comp_logo	=	null;
				$recordShownFrom = null;
				if(!empty($dataArr))
				{				
					//extracting data from DB 
					foreach($dataArr as $dataRow)
					{						
						$recordShownFrom	=	$dataRow['recordShownMessage'];
						//create copy of data and unset totalWIthRange key which are long string will causing issue when we'll handling large data
						$dataRowCopy	=	$dataRow;
						
						unset($dataRowCopy['totalWithRange']);
						if(isset($dataRow['logo'])){
							$comp_logo = base_url().COMP_LOGO."/".$dataRow['logo'];
						}
						
						//data set  for each user

						if(isset($dataRow['totalWithRange']))
						{
							
							$totalRangeArr	=	explode('___---___',$dataRow['totalWithRange']);
							$totalRangeArr = array_unique($totalRangeArr);
							
							if(!empty($totalRangeArr))
							{								
								foreach($totalRangeArr as $totalRangeRow)
								{									
									$totalRangeRowArr	=	explode('---+++--',$totalRangeRow);
									if(!empty($totalRangeRowArr))
									{										
										
										$interVal 	= $dataRow['reportDate'];
										$agentName	= $totalRangeRowArr[0];
										$totalRangeRowArr	=	array_merge($dataRowCopy,$totalRangeRowArr);

										//group by week number
										$agentRecordData[$interVal][$agentName][]	=	$totalRangeRowArr;

									}

								}
							}
							
						}
					}
						
				}
				
				
				/**
				 * Save Data in Session For Live Data Report
				 * */
				$ci->session->unset_userdata('live_requested_data');
				if($report_interval=='live'){

					$requestedChartData = array(
								'live_query_session'  		=> "$query",
								'report_type'		  		=> "$report_type",
								'background_color'			=> "$background_color",
								'report_period'		  		=> "$report_period",
								'report_interval'	 		=> "$report_interval",
								'report_name'	   		    => "$report_name",
								'selectedColoumnHeading'	=> "$selectedColoumnHeading",
					);

					$ci->session->set_userdata('live_requested_data', $requestedChartData);
				}
				
				if(!empty($agentRecordData)){
				
					$data['agentRecordData']		= $agentRecordData;
					$data['selectedColoumnHeading']	= $selectedColoumnHeading;
					$data['report_date']			= date('Y-m-d',strtotime(date('c')));
					$data['report_period']	  	= $report_period;
					$data['report_interval']   		= $report_interval;
					$data['dateRange']		 		= $recordShownFrom;
					$data['report_name']		 	= $report_name;
					$data['report_type']   	 		= ucwords($report_type);
					$data['logo']					= $comp_logo;
					
					if($requestedFromList=='Request From List'){
						$data['report_id']	=	$reportId;
						$data['hancymode'] = ($ci->uri->segments[1] == 'wallboard' && $ci->uri->segments[2] == 'launch');
						$ci->load->view('reports/render_data_view', $data);
					}else{
						$ci->load->view('reports/admin/render_data', $data);
					}
				}else{
					
					$data['errMessage']		 =	'<div id="message" class="error">No Record Found</div>';
					$data['agentRecordData']		= $agentRecordData;
					$data['selectedColoumnHeading']	= $selectedColoumnHeading;
					$data['report_date']			= date('Y-m-d',strtotime(date('c')));
					$data['report_period']	  	= $report_period;
					$data['report_interval']   		= $report_interval;
					$data['dateRange']		 		= $recordShownFrom;
					$data['report_name']		 	= $report_name;
					$data['report_type']   	 		= ucwords($report_type);
					$data['logo']					= $comp_logo;
					if($requestedFromList=='Request From List'){
						$data['report_id']	=	$reportId;
						$ci->load->view('reports/render_data_view', $data);
					}else{
						$ci->load->view('reports/admin/render_data', $data);
					}
					
				}
		}
	}
	
	/**
	 * @author Arshad
	 * Common Button For Reports
	 * */
	

	function commonButtons(){
		
		$html = <<<HTML
				<div style='float:right; padding-right:10px;'>
					<a href='javascript:;' onClick='report_list(); clearContent(); liveChartIntervalRemove(); return false;' class='btn btn-primary'>Back</a>
				</div>
HTML;
		return $html;
	}
		
	/**
	 * Filter Array For Avoiding Total And Subtotal
	 * */
	
	function filterForSubtotalDataControl(){
		
		$cols = array(
						'Agent PIN',
						'Agent Name',
						'Dialed Number',
						'CLI',
						'Campaign',
						'Recording',
						'Transcription',
						'Sentiment',
						'Notes',
						'Tag',
					);
					
		return $cols;
	}