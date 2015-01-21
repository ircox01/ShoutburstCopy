<?php
if(!empty($report)){

	$query					=	$report['report_query'];
	$report_type			=	$report['report_type'];
	$background_color		=	$report['background_color'];
	$report_period			=	$report['report_period'];
	$report_interval		=	$report['report_interval'];
	$report_name			=	$report['report_name'];
	$selectedColoumnHeading	=	$report['columns_name'];
	$report_id				=	$report['report_id'];
	
	$requestedFromList		=	'Request From List';
	?>
	<div id="content">
		<div class="container">	
			<div id="report_content" class="cf">
				<div class='queryBuilderHtml'>
					<?php 
				 	dataReportDraw($query, $report_type,$background_color,$report_period,$report_interval,$report_name,$selectedColoumnHeading,$requestedFromList,$report_id );
				 	?>
 				</div>
			</div><!-- #report_content -->
		</div>
	</div>
 	<?php 
}
?>