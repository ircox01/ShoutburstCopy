<?php
$dateRangeHtml = "";
if(!empty($dateRange)&&$dateRange!=null){
	$dateRangeHtml = $dateRange;
}

$report_period		=	ucwords($report_period);
$report_interval	=	ucwords($report_interval);
//get commong button which will display on reporting
$commonButtons		= '';//commonButtons();

$html = <<<HTML
<style>
.rowHeight{
 height:30px;
}

.mainDiv{font-weight:bold; color:#A3CEED;padding:20px;}
.childDiv{padding:4px;}
.childDivContent{color:#53A1F4;}
</style>
HTML;
if(!empty($logo))
{
$html .=<<<HTML
	<img src='$logo' width="100" height="100" class="shadow" style="position: absolute; top: 15px; right: 15px;">
HTML;
}
$html .=<<<HTML
<div class='report-preview'>
	<div class='row'>
		<div class='col-sm-2 col-field'>Report Name: </div>
		<div class='col-sm-4 col-data'>$report_name </div>
	</div>
	<div class='row'>
		<div class='col-sm-2 col-field'>Report Date: </div>
		<div class='col-sm-4 col-data'>$report_date </div>
	</div>
	<div class='row'>
		<div class='col-sm-2 col-field'>Report Period:</div>
		<div class='col-sm-4 col-data'>$report_period</div>
	</div>
HTML;
if($report_type!="Pie Chart")
{
	$html .=<<<HTML
	<div class='row'>
		<div class='col-sm-2 col-field'>Report Interval:</div>
		<div class='col-sm-4 col-data'>$report_interval</div>
	</div>
HTML;
}

$html .=<<<HTML
	<div class='row'>
		<div class='col-sm-2 col-field'>Date Filter:</div>
		<div class='col-sm-4 col-data'>$dateRangeHtml</div>
	</div>
	<div class='row'>
		<div class='col-sm-2 col-field'>Report Type:</div>
		<div class='col-sm-4 col-data'>$report_type</div>
	</div>
	<p class="countdown"></p>
</div>

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
				<table class='table-sb'>
					<tr class='dark-blue'>
HTML;

$totalColumn	=	count($selectedColoumnHeadingArr);
$totalColumn	=	$totalColumn +2; //increment count value 2 so that we'll able to fetch all desire record

//check total is comming from selected data control
$totalSurveyColPosition = array_search('Total Surveys', $selectedColoumnHeadingArr);
if($totalSurveyColPosition){
	$totalSurveyColPosition	=	$totalSurveyColPosition+2;
}
$tagNamePosition = array_search('Tag', $selectedColoumnHeadingArr);
if($tagNamePosition!==false){
	$tagNamePosition	=	$tagNamePosition+2;
}
/**
 * Set Table Heading HTML
 * */

if(!empty($selectedColoumnHeadingArr)){	
	
	$html .= <<<HTML
					<td style='background-color: transparent; border-left: 0px;'>
					</td>
HTML;

	foreach($selectedColoumnHeadingArr as $selectedColoumnHeadingRow){
		
		
						$hclass='';
		if($selectedColoumnHeadingRow=="Campaign" || $selectedColoumnHeadingRow=="Agent PIN" || $selectedColoumnHeadingRow=="Agent Name" ||
				 $selectedColoumnHeadingRow=="Dialed Number" || $selectedColoumnHeadingRow=="CLI"  )
		{
			$hclass="background-color: #142a4e;";
		}else if($selectedColoumnHeadingRow=="Notes" || $selectedColoumnHeadingRow=="Recording" || $selectedColoumnHeadingRow=="Transcription" || $selectedColoumnHeadingRow=="Tag" || $selectedColoumnHeadingRow=="Sentiment")
		{
			$hclass="background-color: #209700;";
		}else 
		{
			$hclass="background-color: #2254a2;";
		}$selectedColoumnHeadingRow=trim($selectedColoumnHeadingRow);
		$html .= <<<HTML
					<td style='width: 25%; white-space: normal !important;$hclass' class='text-center' $hclass  >
						$selectedColoumnHeadingRow
					</td>
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
									<tr class='agent-name'>
										<td colspan='25'>
											<h6>$agentName</h6>
										</td>
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
										<tr>
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
									$tagNameDisplay=0;
								$totalSurveyValDisplay	=0;
								//use $j for showing record index key and $i for loop count only 
								$j	=	2;
								$count	=	0;
								for($i=2; $i<$totalColumn; $i++){
									
									//check total survey coloumn in heading and create coloumn for total survey
									if($totalSurveyColPosition!==false && $totalSurveyColPosition==$i && $totalSurveyValDisplay==0)
									{										
										//display total survey only first raw
										if($loopount==0){
											$coloumnVal					=	count($agentRecordDateWise);
										}
										else
										{
											$coloumnVal					=	"-";
										}
										
										$totalSurveyValDisplay		=	1;
										//decremenet $j for reuse same index which is use for position of coloumn in total survey case
										$j--;
									}
									else
									{
										$coloumnVal					=	$agentRecordDateWiseRow[$j];
									}
									if($tagNamePosition!==false && $tagNamePosition==$i && $tagNameDisplay==0)
									{
									
										//display total survey only first raw
										if($loopount==0){
											$coloumnVal					=	trim($agentRecordDateWiseRow['tag_name']);
										}
										else
										{
											$coloumnVal					=	"-";
										}
										$tagNameDisplay		=	1;
										$j--;
									}
									
									$subTotalArray[$loopount][]	=	$coloumnVal;
									
									//set recording coloumn link
									if($selectedColoumnHeadingArr[$count]=='Recording'){
										$urlLink 	= base_url().'reports/recording_play/';
										$coloumnVal	="<a href='#myModal' id='modal1' class='modal-iframe' role='button' data-toggle='modal' data-filename='$coloumnVal' data-src='$urlLink' data-height='300' data-width='500' >
											$coloumnVal
											</a>";	
									}
									
									$html .= <<<HTML
											<td>
												$coloumnVal
											</td>
HTML;
									$j++;
									$count++;
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
											<tr class='subtotal light-blue'>
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
										
											//if column is total survey then we dont get sum of subtotal
											if($selectedColoumnHeadingArr[$i]=='Total Surveys'){
												$subTotalVal			= $subTotalArray[0][$i];
											}else{
												foreach($subTotalArray as $subTotalRow){
													$subTotalColumn[]	=	$subTotalRow[$i];
												}
												
												$subTotalVal			= array_sum($subTotalColumn);
											}
											
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
								<tr class='overall-total dark-blue'>
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
	
	<!-- Modal -->
	<div  id="myModal" class="modal sb nohf fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  aria-hidden="true">
	  <div style='width:150px;height:300px;margin-top:20%;' class="modal-dialog">
	    <div class="modal-content">
			<button type="button" class="sb-close" data-dismiss="modal" aria-hidden="true"></button>
			<div class="modal-body">
				Please Wait...
			</div><!-- .modal-body -->
	    </div>
	  </div>
	</div>
	<!--// Modal -->
		
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
			
			
			jQuery('a.modal-iframe').on('click', function(e) {
				
				var src 		= jQuery(this).attr('data-src');
				var fileName	= jQuery(this).attr('data-filename');
				
				jQuery.ajax({
		            type : 'POST',
					url : src,
					data:{'fileName':fileName},
		            success:function (data) {
			          	jQuery('.modal-body').html(data);           	
		            }
		        });
			});
			
			jQuery('#myModal').on('hide.bs.modal', function () {
			
				jQuery(".modal-body#jquery_jplayer_1").jPlayer("stop");
			   	jQuery('.modal-body').html('Please Wait...');           
			});
			
			jQuery('#myModal').on('hidden.bs.modal', function () {
			
				jQuery(".modal-body#jquery_jplayer_1").jPlayer("stop");
			  	jQuery('.modal-body').html('Please Wait...');           
			});		
			
					
		</script>
HTML;

echo $html;
?>