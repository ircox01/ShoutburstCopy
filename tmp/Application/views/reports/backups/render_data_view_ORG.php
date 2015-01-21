<?php
$dateRangeHtml = "";
if(!empty($dateRange)&&$dateRange!=null){
	$dateRangeHtml = $dateRange;
}

$report_period		=	ucwords($report_period);
$report_interval	=	ucwords($report_interval);
//get commong button which will display on reporting
$commonButtons		= '';//commonButtons();
?>

<script type="text/javascript" src="../../../js/sorttable.js"></script>

<style>
	.rowHeight{
	height:30px;
	}

	.mainDiv{font-weight:bold; color:#A3CEED;padding:20px;}
	.childDiv{padding:4px;}
	.childDivContent{color:#53A1F4;}


	.table-sb .Transcription{
	width: 200px !important;
}
</style>

<!--
<audio id="audio">
    <source src="http://skippy.org.uk/wp-content/uploads/introduction-to-the-beep-test.mp3" type="audio/mp3" />
</audio>
--->
	<?php
	if(!empty($logo)) {
		?>
		<img src='<?php echo $logo; ?>' width="100" height="100" class="shadow" style="position: absolute; top: 15px; right: 15px;">
		<?php
	} else {
	        $logo = base_url().COMP_LOGO."/temp_logo.png";
	        if (stripos($_SERVER['REQUEST_URI'] ,'wallboard') !== FALSE) {
	        } else {
	                ?>
	                <img src='<?php echo $logo; ?>' width="200" height="57" class="shadow" style="position: absolute; top: 15px; right: 15px;z-index:999;">
					<?php
	        }
	}
	?>

	<div class='report-preview'>
		<div class='row'>
			<div class='col-sm-2 col-field'>Report Name: </div>
			<div class='col-sm-4 col-data'><?php echo $report_name; ?></div>
		</div>
		<div class='row'>
			<div class='col-sm-2 col-field'>Report Date: </div>
			<div class='col-sm-4 col-data'><?php echo $report_date; ?></div>
		</div>
		<div class='row'>
			<div class='col-sm-2 col-field'>Report Period:</div>
			<div class='col-sm-4 col-data'><?php echo $report_period?></div>
		</div>
		<?php
		if($report_type!="Pie Chart")
		{
		?>
			<div class='row'>
				<div class='col-sm-2 col-field'>Report Interval:</div>
				<div class='col-sm-4 col-data'><?php echo $report_interval; ?></div>
			</div>
		<?php
		}

		?>
		<div class='row'>
			<div class='col-sm-2 col-field'>Date Filter:</div>
			<div class='col-sm-4 col-data'><?php echo $dateRangeHtml; ?></div>
		</div>
		<div class='row'>
			<div class='col-sm-2 col-field'>Report Type:</div>
			<div class='col-sm-4 col-data'><?php echo $report_type; ?></div>
		</div>
		<p class="countdown"></p>
	</div>


	<?php

	if(isset($errMessage) && $errMessage!=''){
		echo $errMessage;

	}
	else{

		$selectedColoumnHeadingArr	=	explode(",",$selectedColoumnHeading);
		?>
		<table id='myTable' class='table-sb'>
		<thead>
		<tr class='dark-blue-title'>
		<?php

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


		if(!empty($selectedColoumnHeadingArr)){	
			
			?>
							<th style='background-color: transparent; border-left: 0px;'>Date/Time
							</th>
		<?php

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
				}
					$selectedColoumnHeadingRow=trim($selectedColoumnHeadingRow);
				
				?>
					<th style='white-space: normal !important; <?php echo $hclass; ?>' class='text-center'   >
						<?php echo $selectedColoumnHeadingRow; ?>
					</th>
				<?php

			}
		}
		echo "</tr></thead>";

		if(!empty($agentRecordData)){
			//Total
			$overAllTotalArr	=	array();
			foreach($agentRecordData as $agentName => $agentRecordDataRow){

				?>
				<thead>
				<tr class='agent-name'>
					<th colspan='25'>
						<h6><?php echo $agentName; ?></h6>
					</th>
				</tr>
				</thead>
				
				<?php
				//sort by date
				
				$cpy_agentRecord = $agentRecordDataRow;

			//	ksort($agentRecordDataRow);
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
									echo "<tr>";

									if($loopount==0){	
											echo "<td>$recordDate</td>";
									}else{
											echo "<td>$recordDate</td>";
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
										$urlLink 	= base_url().'recordings/'.$coloumnVal;
										$coloumnVal = "<img  class='music_btn' src='".base_url()."images/play.png' data-src='".$urlLink."' />";
									}
									
											echo "<td>".$coloumnVal."</td>";
									$j++;
									$count++;
								}
								
									echo "</tr>";
		
		
									$loopount++;
							}
						}

					}

					$q1_total=0;
					$q2_total=0;
					$q3_total=0;
					
					$rows_count=0;
					$transcription_counts=0;
					foreach($agentRecordDataRow as $ar){
					  foreach($ar as $ra){
							if(isset($ra['q1']) && !empty($ra['q1'])) {  $q1_total+= $ra['q1']; }
							if(isset($ra['q2']) && !empty($ra['q2'])) {  $q2_total+=$ra['q2']; }
							if(isset($ra['q3']) && !empty($ra['q3'])) {  $q3_total+=$ra['q3']; }
						  	if(!empty($ra['transcriptions_text']) && isset($ra['transcriptions_text']) ){
						  		$transcription_counts++;
						  	}
						    $rows_count++;		
						}
					}

					//echo $sum;
					//echo "<br>";
					//echo $count;

					?>
					<tfoot>
					<tr class='overall-total dark-blue'>
						<?php
						if(!empty($selectedColoumnHeadingArr)){	
	
											echo "<td><b>Average:</b></td>";
							foreach($selectedColoumnHeadingArr as $selectedColoumnHeadingRow){
								$hclass='-';
								if($selectedColoumnHeadingRow=="Q1 Score" )
								{
									$hclass= round($q1_total/$rows_count, 2);
								}else if($selectedColoumnHeadingRow=="Q2 Score")
								{
									$hclass= round($q2_total/$rows_count, 2);
								}else if($selectedColoumnHeadingRow=="Q3 Score")
								{
									$hclass= round($q3_total/$rows_count, 2);
								}else if($selectedColoumnHeadingRow=="Transcription")
								{
									$hclass= $transcription_counts;
								}

								//$selectedColoumnHeadingRow=trim($selectedColoumnHeadingRow);
						?>					<td style=' white-space: normal !important;' class='text-center' >
												<?php echo $hclass; ?>
											</td>
						<?php	
							}
						}
						?>
					</tr></tfoot>
					<?php

				}
				?>
				
				<?php
			}

			?>
	</tbody>
			<!-- Overall total has been -->
			<!--<tr class='overall-total dark-blue'>
				<td>
					<b>Overall Total:</b>
				</td> -->
			<?php
			/*if(!empty($overAllTotalArr)){
				foreach($overAllTotalArr as $attrKey=>$overAllTotalRow){
					
					//filter array sum for strind and undesire column
					$filterForSubtotalDataControl	=	filterForSubtotalDataControl();
				
					$overAllTotalVal	   =	'-';
					if(in_array($selectedColoumnHeadingArr[$attrKey],$filterForSubtotalDataControl)){
						$overAllTotalVal	=	'-';
					}else{
						$overAllTotalVal	=	array_sum($overAllTotalRow);
					}
					
					echo "<td >$overAllTotalVal</td>";
				}
			}
			
			echo "</tr>"; */

		}
		echo "</table><br/>";
	}

	?>
	<!-- </div>-->

<!-- Modal -->
<div id="myModal" class="modal sb nohf fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

<?php
/**
 * LIVE CHART REQUEST IF INTERVAL IS LIVE
 * */
if(strtolower($report_interval) == 'live'){
	
	$liveChartDuration	=  LIVE_CHART_UPDATE_DURATION;
	
	$liveChartUpdate    =  site_url("reports/data_report_view/$report_id/liveRequest");
	?>
		<script type="text/javascript">
			
			   // update chart
				var ajax_call = function() {
				  jQuery.ajax({
						type: "POST",
						url: '$liveChartUpdate',
						async: true,
						success: function(data){
											if(data)
											{
													jQuery('#test').html('');
								            		jQuery('#test').html(data);
								        	}
										},
					});
				};
				
				//var interval = 1000 * $liveChartDuration; // where X is your every X minutes (1000 * Sec * Minute) i.e for second interval  (1000 * 1) => 1 sec for minutes interval  (1000 * 60 * 1) => 1 Minutes   
				//var refreshIntervalId = setInterval(ajax_call, interval);
			
		</script>
<?php
}
/**
 * Display COunter For Demo We Can Hide This 
 * By Set TRUE AND FALSE
 * */
//set ture and flase for show counter
$counterShow	=	CHART_UPDATE_COUNTER_SHOW;

?>


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
<script type="text/javascript">
	var base_url_of_website = '<?php echo base_url(); ?>';
	
</script>
<script>

$(function(){
var audio = document.getElementById('audio');
    $(".music_btn").on("click",function(){
        var data=$(this).attr("data-src");
        if(audio.paused){
        	//audio.currentTime = 0;
        	$("#audio > source").attr("src",data);
        	audio.load();
        	audio.play();
        	$(".music_btn").attr("src",base_url_of_website+"images/play.png");	
        	$(this).attr("src",base_url_of_website+"images/pause.png");

        } else {
        	if(data == $("#audio > source").attr("src"))
        	{
        		audio.pause();
        		$(this).attr("src",base_url_of_website+"images/play.png");
        	
        	} else {
        		audio.pause();
        		//audio.currentTime = 0;
        		$("#audio > source").attr("src",data);
        		audio.load();
        		audio.play();

        		$(".music_btn").attr("src",base_url_of_website+"images/play.png");
        		$(this).attr("src",base_url_of_website+"images/pause.png");
        			
        	
        	}
        }
        
    });
	
});

</script>

