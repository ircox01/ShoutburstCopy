<?php
/*
 * @author:	Muhammad Sajid Zohaib Fazal
 * @name:	render_chart
 */
function render_chart($report)
{
	$ci = &get_instance();
	
	$result = $ci->reports->my_dashboard_report($report['report_id']);
	
	//if full_view then we don;t validate it for assign report
	if ($ci->uri->segment(4) && ($ci->uri->segment(4) == 'full_view') && ($ci->access != COMP_AGENT) ){
		$result	= array('Not Required To validate');
	}
	
	#var_debug($result);exit;
	if ( !empty($result))
	{#var_debug($ci->uri->segment(4));exit;
		# set chart attributs for Dashboard
		$fullView	=	"";
		
		if ( $ci->uri->segment(4) )
		{
			
			if (($ci->uri->segment(4) == 'full_view') && ($ci->access != COMP_AGENT))
			{
				//full_size Width/height
				$fullView	=	"";
				if ($ci->uri->segment(4)=='full_view') {
	
					$chartWidth  = '1200';
					$chartHeight = '550';
					$fullView	 =	"full_view";
					
					$titleFontSize = 16;
					$legendFontSize = 9;
					$fontSize = 8;
				
					if ($report['report_type'] == 'pie chart'){
						
						$pie_x = 300;
						$pie_y = 325;
						$pie_leg_pos_x = 650;
						$pie_leg_pos_y = 200;
						$pieRadius	 =  '220';
					}
					
				}
			} else {
				$chartWidth = '590';
				$chartHeight = '370';
				
				$titleFontSize = 16;
				$legendFontSize = 9;
				$fontSize = 8;
				if ($report['report_type'] == 'pie chart'){
					$pie_x = 145;
					$pie_y = 200;
					$pie_leg_pos_x = 290;
					$pie_leg_pos_y = 50;
					$pieRadius	=	'138';
				}
			}
			
		} else {

			$chartWidth = '1150';
			$chartHeight = '530';
			$titleFontSize = 25;
			$legendFontSize = 14;
			$fontSize = 12;
			if ($report['report_type'] == 'pie chart'){
				$pie_x = 100;
				$pie_y = 125;
				$pie_leg_pos_x = 250;
				$pie_leg_pos_y = 120;
				$pieRadius	=	'85';
			}
		}
	
		$query = $report['report_query'];
		$report_type = $report['report_type'];
		$x_axis_label = $report['x_axis_label'];
		$y_axis_label = $report['y_axis_label'];
		$report_period = $report['report_period'];
		$report_interval = $report['report_interval'];
		$report_name = $report['report_name'];
		$background_color = !empty($report['background_color']) ? $report['background_color'] : '#FFFFFF';
		//var_debug($report);
	
		$dataArr = $ci->reports->get_chart_data($query);
		//var_debug($dataArr);
	
		// format data for chart
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
		$comp_logo=null;
		if(!empty($dataArr)){
			//data set  for each user
	
			/**
			 * Set Line Graph Data
			 * */
			if($report_type=='line graph')
			{
				/**
				 * Set Data for Time DIvision Basis for each user
				 * */
				$agentDataScoreArr	=	array();
				foreach($dataArr as $dataRow)
				{
					$dataScoreArr	=	array();
	
					//explode data set to get agent data array for each user
					$totalRangeArr	  = explode('___---___',$dataRow['totalWithRange']);
	
					if(!empty($totalRangeArr))
					{
						//expldoe and get date range and dataCount for each user
						foreach($totalRangeArr as  $totalRangeRow)
						{
							$totalRangeData	  = explode('---+++--',$totalRangeRow);
							if(!empty($totalRangeData))
							{
								$agentDataValue	=	$totalRangeData[0];
								//set type integer b/c when addition is done on this type it will remain integer for json encoding
								settype($agentDataValue, "integer");
								//check if same key exsist in array then sum up value for same key
								if(isset($dataScoreArr[$totalRangeData[1]]))
								{
									$agentDataValue	=	$dataScoreArr[$totalRangeData[1]] + $agentDataValue;
								}
								$dataScoreArr[$totalRangeData[1]] = $agentDataValue;
							}
						}
					}
	
					$agentDataScoreArr[$dataRow['full_name']] = $dataScoreArr;
	
					if(isset($dataRow['recordShownMessage']))
					{
						$recordShownFrom  = $dataRow['recordShownMessage'];
					}
					$agentFullName[] 	  = $dataRow['AgentFullName'];
				}
	
				if(!empty($agentDataScoreArr))
				{
					/**
					 * for line chart set line name and area name
					 * */
					foreach($agentDataScoreArr as $recordAgentName=>$agentDataScoreRow)
					{
						$lineAgentNameArr[]	 = "'$recordAgentName'";
						if(!empty($agentDataScoreRow))
						{
							foreach($agentDataScoreRow as $reportDate=>$agentDataScoreRow1)
							{
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
				#var_debug($agentDataScoreArr);exit();
	
			} else {
				foreach($dataArr as $dataRow)
				{
					$reportDate		  = $dataRow['reportDate'];
					$totalSurveyScore = $dataRow['totalSurveyScore'];
					$chartDataArr[]	  = "['$reportDate', $totalSurveyScore]";
					$chartScoreVal[]  = $totalSurveyScore;
	
					if(isset($dataRow['recordShownMessage'])){
						$recordShownFrom  = $dataRow['recordShownMessage'];
					}if(isset($dataRow['logo'])){
									$comp_logo = base_url().COMP_LOGO."/".$dataRow['logo'];
								}
					$agentFullName[] 	  = $dataRow['AgentFullName'];
				}
			}
		}
		// var_debug($chartDataArr);exit();
			
		/**
		 * get agent Unique Name from DB raw
		 * */
		$agentFullNameStr	=	implode(",",$agentFullName);
		$agentFullName		=	implode(", ",array_unique(explode(",",$agentFullNameStr)));
	
		if(!empty($chartDataArr)||!empty($lineAgentNameArr))
		{
			/**
			 * Validate Data for line chart graph if data is only one then we set first initial point is 0,0
			 * because for line we must have a 2 points
			 * */
			if($report_type=='line graph')
			{
				$chartDataArr   = $ci->validateLineChartData($chartDataArr,$lineChartAxisNameArr);
				$colors 		= $ci->chartColor();
				$colorThemes 	= implode(",",$colors);
					
				$chartData		= json_encode($chartDataArr);
				//	var_debug($chartData);exit();
			} else {
				//get color theme array w.r.t to array size
				$colors 		= $ci->chartColor();
				$colorThemes 	= implode(",",array_slice($colors, 0, count($chartDataArr)));
				$chartData		= implode(",",$chartDataArr);
			}
			//get max Y interval w.r.t score
			$maxScore = $ci->getMaxInterval($chartScoreVal);
	
			/**
			 * Save Session Requested Chart Data for live chart
			 * */
			$ci->session->unset_userdata('live_requested_data');
			if($report_interval=='live')
			{
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
				 
				$ci->session->set_userdata('live_requested_data', $requestedChartData);
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
			$data['fontSize']			= $fontSize;
			$data['titleFontSize']		= $titleFontSize;
			$data['legendFontSize']		= $legendFontSize;
			$data['X_Axis']		   		= $ci->getAxisName($x_axis_label);
			$data['Y_Axis']		   		= $ci->getAxisName($y_axis_label);
			$data['graphTitle']	   		= $ci->getAxisName($y_axis_label)." Calculation for ".$agentFullName;
			if ($report['report_type'] == 'pie chart'){
				$data['pie_x']			= $pie_x;
				$data['pie_y']			= $pie_y;
				$data['pie_leg_pos_x']	= $pie_leg_pos_x;
				$data['pie_leg_pos_y']	= $pie_leg_pos_y;
				$data['pieRadius']		= $pieRadius;
			}$data['logo'] 				= $comp_logo;
			
			$data['fullView']			= $fullView;
			
			if ($ci->uri->segment(4)==="d") {
				$ci->load->view('reports/render_chart1', $data);
			}else
			$ci->load->view('reports/render_chart', $data);
		}else{
	
			$data['errMessage']		 =	'<div id="message" class="error">No Record Found</div>';
			$data['report_date']        = date('d/m/Y',strtotime(date('c')));
			$data['report_period']      = $report_period;
			$data['report_interval']    = $report_interval;
			$data['dateRange']          = $recordShownFrom;
			$data['report_name']		 = $report_name;
			$data['report_type']   	 = ucwords($report_type);
			$data['dateRange']          = $recordShownFrom;
			
			if ($ci->uri->segment(4)) {
				$ci->load->view('reports/render_chart1', $data);
			} else {
				redirect('reports/not_found');
			}
		}
	} else {
		redirect('reports/access_denied');
	}
}

/*
 * @author:	Muhammad Arshad Khan
 * @user:	Muhammad Sajid Zohaib Fazal
 * @name:	validateLineChartData
 */
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
	return $agentFormatedData;
}
