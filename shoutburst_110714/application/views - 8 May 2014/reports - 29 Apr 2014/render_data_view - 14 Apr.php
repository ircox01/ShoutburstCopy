<?php

$html = <<<HTML
<style>
.rowHeight{
 height:30px;
}

.mainDiv{font-weight:bold; color:#A3CEED;padding:20px;}
.childDiv{padding:4px;}
.childDivContent{color:#53A1F4;}
</style>
<div style='background-color:#ffffff;'>
HTML;

/**
 * Record Not Found
 * */

if(isset($errMessage) && $errMessage!=''){
	$html .= <<<HTML
			$errMessage
HTML;
}else{

	$selectedColoumnHeadingArr	=	explode(",",$selectedColoumnHeading);
	
$html .= <<<HTML
				<table width='95%'>
					<tr class='rowHeight'>
HTML;

$totalColumn	=	count($selectedColoumnHeadingArr);
$totalColumn	=	$totalColumn +2; //increment count value 2 so that we'll able to fetch all desire record

/**
 * Set Table Heading HTML
 * */

if(!empty($selectedColoumnHeadingArr)){	
	
	$html .= <<<HTML
					<th>
					</th>
HTML;
	foreach($selectedColoumnHeadingArr as $selectedColoumnHeadingRow){
		
		$html .= <<<HTML
					<th style='background-color:#B6C9DB; text-align:center;'>
						$selectedColoumnHeadingRow
					</th>
HTML;
	}
}


$html .= <<<HTML
					</tr>
HTML;


/**
 * Set Agent Base Record
 * */

//var_debug($agentRecordData);exit();
if(!empty($agentRecordData)){
	//Total
	$overAllTotalArr	=	array();

	//record by agent name	
	foreach($agentRecordData as $agentName => $agentRecordDataRow){
			
						
		
								$html .= <<<HTML
									<tr class='rowHeight' style='background-color:#D3D3D3;'>
										<th colspan='25'>
											$agentName
										</th>
									</tr>
HTML;
				
				//sort by date
				ksort($agentRecordDataRow);
			//recodr by data
				if(!empty($agentRecordDataRow)){
					
					/**
					 * Record Raw Divided Date(Day) Basis
					 * */
					
					foreach($agentRecordDataRow as $recordDate=>$agentRecordDateWise){
					
						
						/**
						 * Define Sub-Total Variable for each selected heading 
						 * */
						$subTotalArray		=	array();
						
						
						if(!empty($agentRecordDateWise)){
							$loopount	=	0;
							foreach($agentRecordDateWise as $agentRecordDateWiseRow){
								
								  	$range = end($agentRecordDateWiseRow);
									/**
									 * Record Date Only Shown Once
									 * */
									$html .= <<<HTML
										<tr class='rowHeight' style='border-bottom:1px solid #F2F2F2;'>
HTML;
									if($loopount==0){	
										$html .= <<<HTML
											<td>$recordDate</td>
HTML;
									}else{
										$html .= <<<HTML
											<td></td>
HTML;
									}
									
									
								/**
								 * set record w.r.t heading count Record key 0 & 1 is for data and last record shown date interavl
								 * so taht we only show record from Key->2 to second last key only in numeric
								 */
								
								for($i=2;$i<$totalColumn;$i++){
								
									$subTotalArray[$loopount][]	=	$agentRecordDateWiseRow[$i];
									
									$html .= <<<HTML
											<td>
												$agentRecordDateWiseRow[$i]
											</td>
HTML;
								}
								
									$html .= <<<HTML
										</tr>
HTML;
		
		
									$loopount++;
							}
						}
						
						
						
									/**
									 * Create Raw for SubTotal
									 * */
									
									$html .= <<<HTML
											<tr style='background-color:#DBEAF9' class='rowHeight'>
												<td>
													<b>Subtotal:</b>
												</td>
HTML;
		
								/**
								 * Sub Total Of Each Row
								 * */
									
								$subTotalLoop	=	count($subTotalArray[0]);
								if($subTotalLoop>0){
									for($i=0;$i<$subTotalLoop;$i++){
										
										
										$subTotalColumn	=	array();
										
										//filter array sum for strin and undesire column
										$filterForSubtotalDataControl	=	filterForSubtotalDataControl();
										$subTotalVal	=	'-';
										if(in_array($selectedColoumnHeadingArr[$i],$filterForSubtotalDataControl)){
											$subTotalVal	=	'-';
										}else{
										
											foreach($subTotalArray as $subTotalRow){
												$subTotalColumn[]	=	$subTotalRow[$i];
											}
											
											$subTotalVal			= array_sum($subTotalColumn);
										}
										
										//maintain subtotal array for using in Overall Total
										$overAllTotalArr[$i][]		= $subTotalVal;
										
											$html .= <<<HTML
													<td >
														$subTotalVal
													</td>
HTML;
									}
								}
								$html .= <<<HTML
										</tr>
HTML;
						
						}
				
				}
					
	}
			/**
			 * Total Record
			 * */
			$html .= <<<HTML
								<tr style='background-color:#92B1D1' class='rowHeight'>
									<td>
										<b>Overall Total:</b>
									</td>
HTML;
			if(!empty($overAllTotalArr)){
				foreach($overAllTotalArr as $attrKey=>$overAllTotalRow){
					
					//filter array sum for strind and undesire column
					$filterForSubtotalDataControl	=	filterForSubtotalDataControl();
				
					$overAllTotalVal	   =	'-';
					if(in_array($selectedColoumnHeadingArr[$attrKey],$filterForSubtotalDataControl)){
						$overAllTotalVal	=	'-';
					}else{
						$overAllTotalVal	=	array_sum($overAllTotalRow);
					}
					
					$html .= <<<HTML
									<td >
										$overAllTotalVal
									</td>
								
HTML;
				}
			}
			
			$html .= <<<HTML
							</tr>		
HTML;
}


$html .= <<<HTML
					</table>
					<br/>
HTML;
//	var_debug($selectedColoumnHeading);
//var_debug($agentRecordData);
//exit();

}
$html .= <<<HTML
	</div>
HTML;
/**
 * LIVE CHART REQUEST IF INTERVAL IS LIVE
 * */
if(strtolower($report_interval) == 'live'){
	
	$liveChartDuration	=  LIVE_CHART_UPDATE_DURATION;
	
	$liveChartUpdate    =  site_url("reports/data_report_view/$report_id/liveRequest");
	
	$html .= <<<HTML
	
		<script type="text/javascript">
			
			   // update chart
				var ajax_call = function() {
				  jQuery.ajax({
						type: "POST",
						url: '$liveChartUpdate',
						async: true,
						success: function(data){
											if(data){
								            		jQuery('.queryBuilderHtml').html(data);
								        	}
										},
					});
				};
				
				//var interval = 1000 * $liveChartDuration; // where X is your every X minutes (1000 * Sec * Minute) i.e for second interval  (1000 * 1) => 1 sec for minutes interval  (1000 * 60 * 1) => 1 Minutes   
				//var refreshIntervalId = setInterval(ajax_call, interval);
			
		</script>
HTML;

/**
 * Display COunter For Demo We Can Hide This 
 * By Set TRUE AND FALSE
 * */
	//set ture and flase for show counter
	$counterShow	=	CHART_UPDATE_COUNTER_SHOW;
	
$html .= <<<HTML
		<script type="text/javascript">
			// Our countdown plugin takes a callback, a duration, and an optional message
			var countdown	=	"";
			$.fn.countdown = function (callback, duration, message) {
			    // If no message is provided, we use an empty string
			    message = message || "";
			    // Get reference to container, and set initial content
			    if($counterShow == 1){
			    	var container = $(this[0]).html(duration + message);
			    }
			    // Get reference to the interval doing the countdown
			     countdown = setInterval(function () {
			        // If seconds remain
			        if (--duration) {
			            // Update our container's message
			             if($counterShow == 1){
			            	container.html(duration + message);
			             }
			        // Otherwise
			        } else {
			            // Clear the countdown interval
			            clearInterval(countdown);
			            // And fire the callback passing our container as `this`
			            callback.call(container);   
			        }
			    // Run interval every 1000ms (1 second)
			    }, 1000);
			    
			};
			
			// Use p.countdown as container, pass redirect, duration, and optional message
			$(".countdown").countdown(ajax_call, $liveChartDuration, "s remaining");
			
			// Function to be called after 5 seconds
			function redirect () {
			    this.html("Chart Updating.");
			}
		</script>
HTML;
}

//remove set interval method global in this file b/c it will call on each time of back button hit 
$html .= <<<HTML
		<script type="text/javascript">
			function liveChartIntervalRemove(){
				// check interval id is define or not
				if ( typeof countdown !== 'undefined'){
					clearInterval(countdown);
				}
			}
		</script>
HTML;

echo $html;
?>