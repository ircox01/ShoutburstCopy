<?php
$dateRangeHtml = "";
if(!empty($dateRange)&&$dateRange!=null){
	$dateRangeHtml = $dateRange; 
}

$report_period		=	ucwords($report_period);
$report_interval	=	ucwords($report_interval);

//get commong button which will display on reporting
//$commonButtons		= commonButtons();

$html = <<<HTML
<style>
#graph img {
	display:none;
	visibility:hidden
}

.mainDiv{font-weight:bold; color:#A3CEED;padding:20px;}
.childDiv{padding:4px;}
.childDivContent{color:#53A1F4;}
</style>
HTML;
if(!empty($logo))
{
$html .=<<<HTML
	<img src='$logo' width="100" height="100"/>
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
	<div id="graph" style="min-width: 310px; height: 400px; margin: 0 auto">Loading graph...</div>
	<p class="countdown"></p>
</div>

HTML;

/**
 * Record Not Found
 * */

if(isset($errMessage) && $errMessage!=''){
	$html .= <<<HTML
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('#graph').html('$errMessage');
			});
		</script>
HTML;
}else{

	$data['chartData']     		= $chartData;
	$data['colorThemes']  		= $colorThemes;
	$data['maxScore']      		= $maxScore;
	$data['graphTitle']			= $graphTitle;
	$data['background_color']   = $background_color;
	$data['chartWidth']			= $chartWidth;
	$data['chartHeight']		= $chartHeight;
	$data['X_Axis']		   		= $X_Axis;
	$data['Y_Axis']		   		= $Y_Axis;

	/**
	 * DRAW BAR CHART
	 * */
	if(strtolower($report_type) == 'bar chart'){
		 $html .= $this->load->view('reports/admin/chart/barChart', $data);
	}

	/**
	 * DRAW PIE CHART
	 * */
	if(strtolower($report_type) == 'pie chart'){
		$html .= $this->load->view('reports/admin/chart/pieChart', $data);
	}

	/**
	 * DRAW LINE CHART
	 * */
	if(strtolower($report_type) == 'line graph'){
		$html .= $this->load->view('reports/admin/chart/lineChart', $data);
	}

}
/**
 * LIVE CHART REQUEST IF INTERVAL IS LIVE
 * */
if(strtolower($report_interval) == 'live'){
	
	$liveChartDuration	=  LIVE_CHART_UPDATE_DURATION;
	$liveChartUpdate    =  site_url("reports/liveChartUpdate");
	
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



echo $html;exit();
?>