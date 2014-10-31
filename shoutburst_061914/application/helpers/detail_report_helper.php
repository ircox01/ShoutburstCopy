<?php
/**
 * @author Arshad
 * */
	/**
	 * Get Detail Coloumn
	 * 
	 * */
	function getDetailColumn($post,$select){
		
		$chartColoumn		=	array();
		
		if(!empty($post))
		{
			$general = array('Agent PIN','Agent Name','Dialed Number','CLI','Campaign','Tag');
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
							if($selectRow!="GROUP_CONCAT(DISTINCT tag_name) AS tag_name")
								$columnSelect	=	"IFNULL($selectRow,'Not Found') AS $selectRow";
							else 
								$columnSelect	=	 $selectRow;
								
						}
						else
						{
							$columnSelect	=	"CONCAT('-') AS $selectRow";
						}						
					}
					else
					{
						$columnSelect	=	"SUM($selectRow) AS $selectRow";
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
		
		if(!empty($post))
		{
			$whereCondition .=  "GROUP BY agentName ORDER BY agentName";
		}
		
		return $whereCondition;
	}
	
	
	/**
	 * Draw Detail Grid View
	 * */
	
	function detailReportDraw($query, $report_type,$background_color,$report_name,$selectedColoumnHeading, $requestedFromList=null)
	{	
		if($query)
		{
				$ci = &get_instance();
				$dataArr = $ci->reports->get_chart_data($query);
				foreach ($dataArr as $key => $val)
				{
			       if (isset($val['logo']))
			       {
			          $data['logo'] =base_url().COMP_LOGO."/".$val['logo'];
			          break;
			       }
			    }
				$data['dataArr']				= $dataArr;
				$data['selectedColoumnHeading']	= $selectedColoumnHeading;
				$data['report_date']        	= date('d/m/Y',strtotime(date('c')));
				$data['report_name']		 	= $report_name;
				$data['report_type']   	 		= ucwords($report_type);
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