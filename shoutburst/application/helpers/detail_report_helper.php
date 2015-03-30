<?php
/**
 * @author Arshad
 *
 */
	/**
	 * Get Detail Coloumn
	 * 
	 * */
	function getDetailColumn($post,$select){

		$chartColoumn		=	array();
		
		if(!empty($post))
		{
			$general = array('Agent PIN','Agent Name','Dialed Number','CLI','Campaign','Tag','Recording');
			$report_type		=	$post['report_type'];
			
			//make report field array to avoid sum of string value
			$reports_fields		=	$post['reports_fields'];
			$reports_fieldsArr	=	explode(",",$reports_fields);
			$reports_fieldsArr1	=	array();
			/**
			 * Set Grouped Selected Coloumn for display on data table w.r.t to particualr agent
			 * */
			$selectArr		=	explode(",",$select);

			//check total survey is comming from selected data control
			$totalSurveyColPosition = array_search('Total Surveys', $reports_fieldsArr);
			if($totalSurveyColPosition!==false)
			{
				
				//remove total survey attribute by flip array then unset key value
				$reports_fieldsArr1	=	array_flip($reports_fieldsArr);
				unset($reports_fieldsArr1['Total Surveys']);
				$reports_fieldsArr1	=	array_flip($reports_fieldsArr1);
				$reports_fieldsArr1	=	array_values($reports_fieldsArr1);
			}else
				$reports_fieldsArr1	=	array_values($reports_fieldsArr);
			
			if(!empty($selectArr))
			{
				foreach($selectArr as $key=>$selectRow)
				{
								
					//filter array sum for strin and undesire column
					$filterForSubtotalDataControl	=	filterForSubtotalDataControl();
					if(in_array($reports_fieldsArr1[$key],$filterForSubtotalDataControl))
					{						
						if(in_array($reports_fieldsArr1[$key],$general))// =='Agent Name' || $reports_fieldsArr1[$key] =='Agent PIN' || $reports_fieldsArr1[$key] =='Campaign')
						{
							if($selectRow!="tag_name")
								$columnSelect	=	"IFNULL($selectRow,'Not Found') AS $selectRow";
							else 
								$columnSelect	=	 $selectRow;
								
						}
						else
						{
							$columnSelect	=	"CONCAT('--') AS $selectRow";
						}						
					}
					else
					{
						$columnSelect	=	"$selectRow";
					}
					
					$chartColoumn[]	=	$columnSelect;
				}
			}			
			
			$chartColoumn[]	= 'full_name AS agentName';
		}
		
		//check total survey is comming from selected data control
		$totalSurveyColPosition = array_search('Total Surveys', $reports_fieldsArr);
		if($totalSurveyColPosition!==false)
		{
			$chartColoumn[]	= 'COUNT(s.sur_id) AS totalSurvey';
		}
		
		//if chart column array is empty then result set will be false else we return comma seprated column
		if(empty($chartColoumn))
		{
			return false;
		}
		else
		{
			$chartColoumn = implode(",",$chartColoumn);
			return $chartColoumn;
		}
		
	}
	
	
	/**
	 * Detail Where COndition
	 * */
	
	function detailWhereCondition($post){
		
		$whereCondition	=	false;

		$dateTime = "s.date_time";
		
		if(!empty($post))
		{
		//	$whereCondition .=  "GROUP BY agentName ORDER BY agentName";
					switch ($post['report_period']) {
						case "current hour":
							$whereCondition .= 'AND TIMEDIFF(DATE_FORMAT(s.date_time, "%Y-%m-%d %H:%i"),DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 HOUR), "%Y-%m-%d %H:%i"))>=0 ';
							break;
						case "day":
							$custom_date    =   date('Y-m-d',strtotime($post['custom_date']));
							$whereCondition .=  "AND DATE($dateTime) = '$custom_date' ";
							break;
						case "today":
							$whereCondition .=  "AND DATE($dateTime) = CURRENT_DATE()";
							break;
						case "yesterday":
							$whereCondition .=  "AND DATE($dateTime) = DATE(DATE_SUB(NOW(), INTERVAL 1 DAY))";
							break;
						case "current week":
							$whereCondition .=  "AND DATE($dateTime) >= DATE(DATE_SUB(NOW(), INTERVAL 1 WEEK))";
							break;
						case "last week":
							$whereCondition .=  "AND DATE($dateTime) >= DATE(DATE_SUB(NOW(), INTERVAL 2 WEEK)) AND DATE($dateTime) <= DATE(DATE_SUB(NOW(), INTERVAL 1 WEEK))";
							break;
						case "current month":
							$whereCondition .=  "AND DATE_FORMAT($dateTime,'%Y-%m') = DATE_FORMAT(NOW(),'%Y-%m')";
							break;
						case "last month":
							$whereCondition .=  "AND DATE_FORMAT($dateTime,'%Y-%m') = DATE_FORMAT(NOW() - INTERVAL 1  MONTH,'%Y-%m')";
							break;
						case "custom":
							//format start and end time for sql query
							$start_date             = date('Y-m-d H:i',strtotime($post['start_date'])); //$post['start_date'];// date('d/m/Y H:i',strtotime($post['start_date']));
							$end_date               = date('Y-m-d H:i',strtotime($post['end_date']));//$post['end_date'];//  date('d/m/Y H:i',strtotime($post['end_date']));

							$whereCondition .=  "AND s.date_time BETWEEN CAST('$start_date' as date) AND CAST('$end_date' as date)";
						break;
					}

		//	$whereCondition .=  " GROUP BY agentName  ORDER BY s.date_time DESC,agentName";
		}
		return $whereCondition;
	}
	
	
	/**
	 * Draw Detail Grid View
	 * */
	
	function detailReportDraw($query, $report_type,$background_color,$report_period,$start_date,$end_date,$report_name,$selectedColoumnHeading, $requestedFromList=null, $is_dash = false)
	{
		if($query)
		{
				$ci = &get_instance();
				$dataArr = $ci->reports->get_chart_data($query);
				
				
				
				//print_r($dataArr);
				foreach ($dataArr as $key => $val)
				{
			       if (isset($val['logo']))
			       {
			          $data['logo'] =base_url().COMP_LOGO."/".$val['logo'];
			          break;
			       }
			    }


				$len = count($dataArr);

				for ($i=0;$i < $len;$i++) {
					if (isset($dataArr[$i]['recording']) && strlen($dataArr[$i]['recording']) > 4) {
						$urlLink 	= base_url().'recordings/'.$dataArr[$i]['recording'];
						$dataArr[$i]['recording'] = "<img  class='music_btn' src='".base_url()."images/play.png' data-src='".$urlLink."' />";	
									
						//<a href="http://144.76.168.74/shoutburst/jwplay.php?rec_id='.$dataArr[$i]['recording'].'" target="_blank">Play</a>';
					}
				}

				//. total score fix
				$totalrows = count($dataArr);


				//for ($i=0;$i < $totalrows;$i++) {
				//	$dataArr[$i]['total_score'] = $dataArr[$i]['q1'] + $dataArr[$i]['q2'] + $dataArr[$i]['q3'] ;
				//}


				$data['dataArr']				= $dataArr;
				$data['selectedColoumnHeading']	= $selectedColoumnHeading;
				$data['report_date']        	= date('Y-m-d',strtotime(date('c')));
				$data['report_name']		 	= $report_name;
				$data['report_type']   	 		= ucwords($report_type);
				$data['report_period']			= $report_period;
				$data['start_date']				= $start_date;
				$data['end_date']				= $end_date;

				$data['is_dash'] = $is_dash;


				if(empty($dataArr))
				{
					$data['errMessage']		 =	'<div id="message" class="error">No Record Found</div>';
				}			

				
				if( $requestedFromList == 'Request From List' )
				{

					$ci->load->view('reports/render_detail_view', $data);
				}
				else
				{
					$ci->load->view('reports/admin/render_detail_view', $data);
				}
		}
	}
