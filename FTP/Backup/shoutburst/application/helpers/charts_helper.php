<?php ini_set("display_errors",1);
/*
 * @author:	Muhammad Sajid Zohaib Fazal
 * @name:	render_chart
 */

function render_chart($report, $from_dash=0)
{
	if (stripos($_SERVER['REQUEST_URI'],'wallboard/launch') !== FALSE) {
		$in_wallboard = true;
	} else {
		$in_wallboard = false;
		
	}

	$ci = &get_instance();
	
	$result = $ci->reports->my_dashboard_report($report['report_id']);
	
	//if full_view then we don;t validate it for assign report
	if ($ci->uri->segment(4) && ($ci->uri->segment(4) == 'full_view') && ($ci->access != COMP_AGENT) ){
		$result	= array('Not Required To validate');
	}	
	if ( !empty($result) || !empty($report))
	{

		#var_debug($ci->uri->segment(4));exit;
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

				$chartWidth = '400';
				$chartHeight = '210';
				
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
		$y_axis_midpoint = $report['y_axis_midpoint'];
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
		if(!empty($dataArr))
		{
			//data set  for each user
			
			/** Set Line Graph Data * */
			if($report_type=='line graph')
			{
				/** Set Data for Time DIvision Basis for each user  * */
				$agentDataScoreArr	=	array();
				$chartScoreVal = array();
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
								array_push($chartScoreVal, $totalRangeData[0]);
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


				/*print_r($recordShownFrom);
				echo "<br><br>";
				print_r($agentFullName);
				*/			
	
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
				
				
			} 
			else 
			{

				if ($report_type == "word cloud") {
					
					$text = "";
					foreach ($dataArr as $row) {
						if (isset($row['logo']))
							$logo = $row['logo'];
						else
							$logo = "";
							$text .= " ".$row['transcriptions_text'];
					}
					$text64 = base64_encode($text);
					// NX: make generic (need to change when going live)
					$query_detail = unserialize($report['query_detail']);
					$query_data_types = unserialize($report['query_data_type']);
					$cond_title = "";
					
					if (count($query_data_types) > 0) {
						for ($j=0;$j < count($query_data_types);$j++) {
							$cond_title .= $query_data_types[$j] . " " . $query_detail[$j]. " ";
						}
					}

					$cond_title = str_replace("_"," ",$cond_title);
					$wc_title = ucfirst($report_interval)." , ".ucfirst($report_period) . ($cond_title == "" ? "" : " for $cond_title");

					if ($from_dash == 1) {
					    $wciframe = "<iframe src='".base_url()."wordcloud_txt_small.php?text=$text64&title=$wc_title' height=580 width=650 frameBorder='0' style='overflow:hidden;'/>";
					} elseif ($in_wallboard) {
						$wciframe = "<iframe src='".base_url()."wordcloud_wallboard.php?text=$text64&logo=$logo&title=$wc_title' height=700 width=1250 frameBorder='0' style='overflow:hidden;'/>";
					} else {
						$wciframe = "<iframe src='".base_url()."wordcloud_txt.php?text=$text64&logo=$logo&title=$wc_title' height=800 width=1450 frameBorder='0' style='overflow:hidden;'/>";
					}
			
					if ($text != "") {
						echo $wciframe;
					} else {
						echo "<span style='text-align:center'><b>$wc_title</b><br />No word cloud data to display</span>";
					}
				
				} else {

					  if ($report_type == 'detail') {
					
						$target_url =  base_url().'reports/detail_report_view/'.$report['report_id'].'/d';
					?>
					<iframe overflow="hidden" width="100%" height="90%" style="border: 0px;" src="<?=$target_url?>"></iframe>
					
					<?php
					
					} else {

						foreach($dataArr as $dataRow)
						{
							$reportDate		  = $dataRow['reportDate'];
							$totalSurveyScore = $dataRow['totalSurveyScore'];
							$chartDataArr[]	  = "['$reportDate', $totalSurveyScore]";
							$chartScoreVal[]  = $totalSurveyScore;
			
							if(isset($dataRow['recordShownMessage']))
							{
								$recordShownFrom  = $dataRow['recordShownMessage'];
							}
							if(isset($dataRow['logo']))
							{
								$comp_logo = base_url().COMP_LOGO."/".$dataRow['logo'];
							}
							$agentFullName[] 	  = $dataRow['AgentFullName'];
						}
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
				$chartDataArr   = validateLineChartData($chartDataArr,$lineChartAxisNameArr);
				$colors 		= chartColor();
				$colorThemes 	= implode(",",$colors);
					
				$chartData		= json_encode($chartDataArr);
				//	var_debug($chartData);exit();
			} else {
				//get color theme array w.r.t to array size
				$colors 		= chartColor();
				$colorThemes 	= implode(",",array_slice($colors, 0, count($chartDataArr)));
				$chartData		= implode(",",$chartDataArr);
			}

			//get max Y interval w.r.t score
			$maxScore = getMaxInterval($chartScoreVal);
	
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
											'y_axis_midpoint'     => "$y_axis_midpoint",
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
			$data['report_date']        = date('Y-m-d',strtotime(date('c')));
			$data['report_period']      = $report_period;
			$data['report_interval']    = $report_interval;
			$data['dateRange']          = $recordShownFrom;
			$data['report_name']		= $report_name;
			$data['chartWidth']			= $chartWidth;
			$data['chartHeight']		= $chartHeight;
			$data['fontSize']			= $fontSize;
			$data['titleFontSize']		= $titleFontSize;
			$data['legendFontSize']		= $legendFontSize;
			$data['X_Axis']		   		= getAxisName($x_axis_label);
			$data['Y_Axis']		   		= getAxisName($y_axis_label);
			$data['graphTitle']	   		= getAxisName($y_axis_label)." Calculation for ".$agentFullName;
			$data['wallboard'] = $in_wallboard;
			$data['y_axis_midpoint']	= $y_axis_midpoint;
			if ($report['report_type'] == 'pie chart'){
				$data['pie_x']			= $pie_x;
				$data['pie_y']			= $pie_y;
				$data['pie_leg_pos_x']	= $pie_leg_pos_x;
				$data['pie_leg_pos_y']	= $pie_leg_pos_y;
				$data['pieRadius']		= $pieRadius;
			}
			$data['logo'] 				= $comp_logo;
			
			$data['fullView']			= $fullView;
			
			if ($ci->uri->segment(4)==="d") {
				$ci->load->view('reports/render_chart1', $data);
			}else
			$ci->load->view('reports/render_chart', $data);
		}else{
			if ($report_type != "word cloud" && $report_type != "detail") {
			$data['errMessage']		 =	'<div id="message" class="error" style="font-family:verdana;font-weight:bold;">No Record Found</div>';
			$data['report_date']        = date('Y-m-d',strtotime(date('c')));
			$data['report_period']      = $report_period;
			$data['report_interval']    = $report_interval;
			$data['dateRange']          = $recordShownFrom;
			$data['report_name']		 = $report_name;
			$data['report_type']   	 = ucwords($report_type);
			$data['dateRange']          = $recordShownFrom;
			$data['wallboard'] = $in_wallboard;
			if ($ci->uri->segment(4)) {
				$ci->load->view('reports/render_chart1', $data);
			} else {
				redirect('reports/not_found');
			}
			}
		}
            }else {	echo "<p style='font-family:\"Museo Sans 500\", Arial, Helvetica, sans-serif;'>No Data Available</p>";}

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
						//if($count==0){
							$x_axisLabel	=	$agentFormatedDataArrRow[0];
						//}
							
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
	#var_debug($agentFormatedData);
				
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
/**
 * Set Y Axis MID-Point
 * */

function getMaxInterval($chartScoreVal)
{

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
 * Chart Color
 * #TODO Need to increase number of color for charts
 * */
function chartColor(){

	return array(
			1=>"'#F08080'",
			2=>"'#FA8072'",
			3=>"'#E9967A'",
			4=>"'#FFA07A'",
			5=>"'#DC143C'",
			6=>"'#FF0000'",
			7=>"'#B22222'",
			8=>"'#8B0000'",
			9=>"'#FFC0CB'",
			10=>"'#FFB6C1'",
			11=>"'#FF69B4'",
			12=>"'#FF1493'",
			13=>"'#C71585'",
			14=>"'#DB7093'",
			15=>"'#FFA07A'",
			16=>"'#FF7F50'",
			17=>"'#FF6347'",
			18=>"'#FF4500'",
			19=>"'#FF8C00'",
			20=>"'#FFA500'",
			21=>"'#FFD700'",
			22=>"'#FFFF00'",
			23=>"'#F4A460'",
			24=>"'#DAA520'",
			25=>"'#CD853F'",
			26=>"'#FFEFD5'",
			27=>"'#FFE4B5'",
			28=>"'#FFDAB9'"	,
			30=>"'#EEE8AA'",
			31=>"'#F0E68C'",
			32=>"'#BDB76B'",
			33=>"'#E6E6FA'",
			34=>"'#D8BFD8'",
			35=>"'#DDA0DD'",
			36=>"'#EE82EE'",
			37=>"'#DA70D6'",
			38=>"'#FF00FF'",
			39=>"'#FF00FF'",
			40=>"'#BA55D3'",
			41=>"'#9370DB'",
			42=>"'#8A2BE2'",
			43=>"'#9400D3'",
			44=>"'#9932CC'",
			45=>"'#8B008B'",
			46=>"'#800080'",
			47=>"'#4B0082'",
			48=>"'#6A5ACD'",
			49=>"'#483D8B'",
			50=>"'#7B68EE'",
			51=>"'#ADFF2F'",
			52=>"'#5F9EA0'",
			53=>"'#4682B4'",
			54=>"'#B0C4DE'",
			55=>"'#32CD32'",
			56=>"'#98FB98'",
			57=>"'#90EE90'",
			58=>"'#00FA9A'",
			59=>"'#00FF7F'",
			60=>"'#3CB371'",
			61=>"'#2E8B57'",
			62=>"'#228B22'",
			63=>"'#008000'",
			64=>"'#006400'",
			65=>"'#9ACD32'",
			66=>"'#6B8E23'",
			67=>"'#808000'",
			68=>"'#556B2F'",
			69=>"'#66CDAA'",
			70=>"'#8FBC8F'",
			71=>"'#20B2AA'",
			72=>"'#008B8B'",
			73=>"'#008080'",
			74=>"'#00FFFF'",
			75=>"'#00FFFF'",
			76=>"'#00008B'",
			77=>"'#AFEEEE'",
			78=>"'#7FFFD4'",
			79=>"'#40E0D0'",
			80=>"'#48D1CC'",
			81=>"'#00CED1'",
			82=>"'#5F9EA0'",
			83=>"'#4682B4'",
			84=>"'#B0C4DE'"
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
	$yAxisColoumnList	=	yAxisColoumnList();

	$axisLabelArray	=	array_merge($yAxisColoumnList,$axisLabelArray);
	if(isset($axisLabelArray["$labelKey"])){
		return $axisLabelArray["$labelKey"];
	}
	return $labelKey;
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
