<?php

if ($is_dash == 1) {
	?>
<script>
$("#main-nav").remove();
$("#header").remove();
</script>
<?php
}

?>

<?php
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


@media all and (max-width: 650px) and (min-width: 220px) {
.table-sb tbody td,.table-sb tbody th{
	font-size:9px;
}
div.row.content-body{
padding-top: 0px !important;
}
div#content{
	padding: 0px !important;
}
@-moz-document url-prefix() { 
  .table-sb tbody td,.table-sb tbody th{
	font-size:8px;
	}

}
}

</style>

HTML;

if (!$is_dash) {

if(!empty($logo))
{
	$html .=<<<HTML
		<img src='$logo' width="100" height="100" class="shadow" style="position: absolute; right: 15px;">
HTML;
}else 
{
	$logo = base_url().COMP_LOGO."/temp_logo.png";
	$html .=<<<HTML
	<img src='$logo' width="200" height="57" class="shadow" style="position: absolute; top: 15px; right: 15px;z-index:999;">
HTML;
}
$html .= <<<HTML
	<div class='report-preview'>
	<div class='row'>
		<div class='col-sm-2 col-field'>Report Name: </div>
		<div class='col-sm-4 col-data'>$report_name </div>
	</div>
	<div class='row'>
		<div class='col-sm-2 col-field'>Report Run Date: </div>
		<div class='col-sm-4 col-data'>$report_date </div>
	</div>
	<div class='row'>
		<div class='col-sm-2 col-field'>Report Period:</div>
		<div class='col-sm-4 col-data'>$report_period</div>
	</div>
HTML;

if($report_period == 'custom'){
$html .= <<<HTML
<div class='row'>
	<div class='col-sm-2 col-field'>Report Dates:</div>
	<div class='col-sm-4 col-data'>$start_date to $end_date</div>
</div>
HTML;
}

$html .= <<<HTML
	<p class="countdown"></p>
</div>

HTML;

}



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
				<div class='col-md-12'>




				<table id="myTable" class="table-sb">
				<thead>
					<tr class='dark-blue-title'>
HTML;

//check total is comming from selected data control
$totalSurveyColPosition = array_search('Total Surveys', $selectedColoumnHeadingArr);


/**
 * Set Table Heading HTML
 * */

if(!empty($selectedColoumnHeadingArr)){	
// NX:  mandatory date field , removed 25% on td style
$html .= <<<HTML
                                        <th style='white-space: normal !important;' class='text-center' >
                                             <b>Date</b>
                                        </th>
                                        <th style='white-space: normal !important;' class='text-center' >
                                             <b>Time</b>
                                        </th>
                                        
HTML;



	
	foreach($selectedColoumnHeadingArr as $selectedColoumnHeadingRow)
	{		
		$hclass='';
		if($selectedColoumnHeadingRow =="Campaign" || $selectedColoumnHeadingRow == "Agent PIN" || $selectedColoumnHeadingRow=="Agent Name" ||
				 $selectedColoumnHeadingRow =="Dialed Number" || $selectedColoumnHeadingRow=="CLI"  )
		{
			$hclass="background-color: #142a4e;";
		}else if($selectedColoumnHeadingRow =="Notes" || $selectedColoumnHeadingRow=="Recording" || $selectedColoumnHeadingRow=="Transcription" || $selectedColoumnHeadingRow=="Tag" || $selectedColoumnHeadingRow=="Sentiment")
		{
			$hclass="background-color: #209700;";
		}else 
		{
			$hclass="background-color: #2254a2;";
		}
		$selectedColoumnHeadingRow=trim($selectedColoumnHeadingRow);
		// NX: removed 25% on td style
		$html .= <<<HTML
					<th style='white-space: normal !important;$hclass' class='text-center' $hclass  >
						<b>$selectedColoumnHeadingRow</b>
					</th>
HTML;
	}
}


$html .= <<<HTML
					</tr>
				</thead>
				<tbody>
HTML;


/**
 * Set Agent Base Record
 * */

//var_debug($agentRecordData);exit();
if(!empty($dataArr)){
	//Total
	$overAllTotalArr	=	array();
	
	//record by agent name	
	foreach($dataArr as $agentRecordDataRow){
		if(!empty($agentRecordDataRow)){

					
			unset($agentRecordDataRow['agentName']);
			unset($agentRecordDataRow['logo']);
			if($totalSurveyColPosition !== false){
				
				if($totalSurveyColPosition==0){
					$agentRecordDataRow	=	array_merge(array("totalSurvey" => $agentRecordDataRow['totalSurvey']),$agentRecordDataRow);
				}else{
					$agentRecordDataRoppw = array_slice($agentRecordDataRow, 0, $totalSurveyColPosition, true) +  array("totalSurvey" => $agentRecordDataRow['totalSurvey']) + array_slice($agentRecordDataRow, $totalSurveyColPosition, count($agentRecordDataRow) - 1, true) ;
				}	
			}
			$i=0;
			foreach($agentRecordDataRow as $key=>$agentRecordRow)
			{
				
					$overAllTotalArr[$key][]	=		$agentRecordRow;
					if($i==0){	
						$date= substr($agentRecordRow, 0,10);
						$time=substr($agentRecordRow, 12,5);
						
					$html .= <<<HTML
							<td>
								$date
							</td>
							<td>
								$time
							</td>
HTML;
					}
					else
					{
					$html .= <<<HTML
							<td>
								$agentRecordRow
							</td>
							
HTML;
					}
					$i++;
			}
			$html .= <<<HTML
									</tr>
								
								
HTML;
		}
	}
	
	
			/**
			 * Total Record
			 * */
			$html .= <<<HTML
			</tbody>
			<tfoot>			
			<tr class='overall-total dark-blue'>
			<td><b>Average</b></td>
			
HTML;
			
			if(!empty($overAllTotalArr)){
				
				$overAllTotalArr	=	array_values($overAllTotalArr);
				$i=0;
				foreach($overAllTotalArr as $attrKey=>$overAllTotalRow){
				//		if($i > 0){
						
						if (! isset($selectedColoumnHeadingArr[$attrKey])) {
							$selectedColoumnHeadingArr[$attrKey] = null;
						}
						
						//filter array sum for strind and undesire column
						$filterForSubtotalDataControl	=	filterForSubtotalDataControl();
						
					//	echo "$selectedColoumnHeadingArr[$attrKey]\n";
						
						
						$overAllTotalVal	   =	'0';
						if((isset($selectedColoumnHeadingArr[$attrKey]) && in_array($selectedColoumnHeadingArr[$attrKey],$filterForSubtotalDataControl)) && $selectedColoumnHeadingArr[$attrKey]){
							$overAllTotalVal	=	'0';
						}else{
							if (strpos(isset($selectedColoumnHeadingArr[$attrKey]),'Agent PIN') !== false) {
								$overAllTotalVal	=	'0';
							} else {
								$overAllTotalVal	=	array_sum($overAllTotalRow);
							}
								
						}
						
						$result = count($overAllTotalRow);
												
						if (($overAllTotalVal != 0 && strtotime($overAllTotalVal) == false) ){
						$result = round($overAllTotalVal/$result,1);
						$html .= <<<HTML
									<td >
										<b>$result</b>
									</td>
HTML;
	
						} else {
						$html .= <<<HTML
									<td ></td>
HTML;
						}
			//	} else {
				//	$html .= <<<HTML
				//				<td ></td>
//HTML;
	//			}
		//		$i++;
				
				}
			}
			
			$html .= <<<HTML
							</tr>
								</tfoot>		
HTML;
	
}


$html .= <<<HTML
					</table></div>
					<br/>
HTML;
//	var_debug($selectedColoumnHeading);
//var_debug($agentRecordData);
//exit();

}


echo $html;

?>


<script type="text/javascript">
	var base_url_of_website = '<?php echo base_url(); ?>';
	
</script>


		<script>



			$(function(){
			var audio = document.getElementById('audio');
			    $(".music_btn").on("click",function()
				{
					var data=$(this).attr("data-src") + '.mp3';

			        if (audio.paused)
					{
			        	//audio.currentTime = 0;
			        	$("#audio > source").attr("src", data);
			        	audio.load();
			        	audio.play();
			        	$(".music_btn").attr("src", base_url_of_website + "images/play.png");
			        	$(this).attr("src", base_url_of_website + "images/pause.png");

			        }
			        else
					{
			        	if(data == $("#audio > source").attr("src"))
			        	{
			        		audio.pause();
			        		$(this).attr("src",base_url_of_website+"images/play.png");
			        	
			        	}
			        	else
			        	{
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

<?php

if ($is_dash == 1) {
        ?>
<script>
$("#content").css("margin-left","0px");
$("body").css("background-color","#ffffff");
$("tr").css("padding","0px");
$("td").css("padding","0px");
</script>


        <script type="text/javascript">
            var indy;
            function livereload() {
                history.go(0);
                }

            $(function() {
              indy = setTimeout(livereload, 10000);
            });
        </script>


<?php
}

?>
