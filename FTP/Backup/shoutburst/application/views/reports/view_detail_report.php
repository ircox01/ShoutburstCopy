<?php
if(!empty($report)){

$is_dash = false;
if ($this->uri->segment(4) == 'd') {
$is_dash = true;
}

	$query					=	$report['report_query'];
	$report_type			=	$report['report_type'];
	$background_color		=	$report['background_color'];
	$report_name			=	$report['report_name'];
	$selectedColoumnHeading	=	$report['columns_name'];
	$report_id				=	$report['report_id'];
	$report_period			=	$report['report_period'];
	$start_date				=	$report['custom_start_date'];
	$end_date				=	$report['custom_end_date'];
	
	$requestedFromList		=	'Request From List';
	?>
	<div id="content">
		<div class="container">	
<?php
if (!$is_dash) {
?>

			<div class="row content-header">
				<h1>Detail Report View</h1>
			</div>

<?php
}
?>
			<div class="row content-body">
<?php
if (!$is_dash) {
?>
				
				<div style='float:right; padding-bottom:10px; padding-right:10px;'>
				  <!--	<a href='javascript:;' onClick='return false;' class='btn btn-primary'>Export to PDF</a>-->
					<a href='<?php echo base_url().'reports'?>' class='btn btn-primary'>Back</a>
					<a href='<?php echo base_url();?>reports/print_csv/<?php echo $report_id;?>'  class='btn btn-primary'>Export to CSV</a>					
				</div>

<?php
}
?>


				<div class="col-sm-12">
					<div id="report_content">
						<div class='queryBuilderHtml'>
							<?php 
								detailReportDraw($query, $report_type,$background_color,$report_period,$start_date,$end_date,$report_name,$selectedColoumnHeading,$requestedFromList,$is_dash);
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
