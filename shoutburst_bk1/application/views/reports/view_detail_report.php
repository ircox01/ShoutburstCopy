<?php
if(!empty($report)){

	$query					=	$report['report_query'];
	$report_type			=	$report['report_type'];
	$background_color		=	$report['background_color'];
	$report_name			=	$report['report_name'];
	$selectedColoumnHeading	=	$report['columns_name'];
	$report_id				=	$report['report_id'];
	
	$requestedFromList		=	'Request From List';
	?>
	<div id="content">
		<div class="container">	
			<div class="row content-header">
				<h1>Detail Report View</h1>
			</div>
			<div class="row content-body">
				
				<div style='float:right; padding-bottom:10px; padding-right:10px;'>
				  <!--	<a href='javascript:;' onClick='return false;' class='btn btn-primary'>Export to PDF</a>-->
					<a href='<?php echo base_url().'reports'?>' class='btn btn-primary'>Back</a>
					<a href='<?php echo base_url();?>reports/print_csv/<?php echo $report_id;?>'  class='btn btn-primary'>Export to CSV</a>					
				</div>
				<div class="col-sm-12">
					<div id="report_content">
						<div class='queryBuilderHtml'>
							<?php 
								detailReportDraw($query, $report_type,$background_color,$report_name,$selectedColoumnHeading,$requestedFromList);
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
