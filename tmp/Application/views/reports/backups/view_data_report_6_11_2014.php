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
			<div class="row content-header">
				<h1>Data Report View</h1>
			</div>
			<div class="row content-body">
				
				<div style='float:right; padding-bottom:10px; padding-right:10px;'>
					<a href='<?php echo base_url().'reports'?>'  class='btn btn-primary'>Back</a>
					<!--  <a href='javascript:;' onClick='return false;' class='btn btn-primary'>Export to PDF</a>
					<a href='javascript:;' onClick='return false;' class='btn btn-primary'>Export to CSV</a>-->
				</div>
				
				<div class="col-sm-12">
					<div id="report_content">
						<div class='queryBuilderHtml'>
							<?php 
							dataReportDraw($query, $report_type,$background_color,$report_period,$report_interval,$report_name,$selectedColoumnHeading,$requestedFromList,$report_id );
							?>
						</div>
					</div><!-- #report_content -->
				</div>
			</div><!-- .row -->
		</div>
	</div>
 	<?php 
}
?>