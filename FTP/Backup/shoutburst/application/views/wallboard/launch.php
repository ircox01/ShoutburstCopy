<html><head><title><?php echo $title;?></title>
<?php 
if (stripos($_SERVER['REQUEST_URI'] ,'wallboard') !== FALSE) {
	$wallboard = true;
} else {
	$wallboard = false;
}
?>
	<script src="/js/jquery-1.6.0.min.js" type="text/javascript"></script>

<!-- Usman Bootstrap -->

	<link rel="stylesheet" type="text/css" href="/css/style.css?ver=7"/>
	<link rel="stylesheet" type="text/css" href="/css/responsive.css"/>
	<!-- Usman -->
	<link href="/css/bootstrap.min.css" rel="stylesheet">
	<script type='text/javascript' src='/js/jquery.marquee.min.js'></script>
	<script type='text/javascript' src='/js/bowser.js'></script>

	<script type="text/javascript" src="/highcharts/js/highcharts.js"></script>
	<script type="text/javascript" src="/highcharts/js/highcharts-3d.js"></script>
	<script type="text/javascript" src="/highcharts/js/modules/exporting.js"></script>

		<script type="text/javascript">

		function launchWallboard()
		{
			request = $.ajax({
			url: "<?php echo base_url();?>wallboard/wallboard_launch",
			datatype:"JSON",
			type:"GET"
									});
			request.done(function(data1) {	data1=data1.trim();
				if( data1!='0' || data1 !=0  )
				{	
						//	alert(data1);
					window.location="/shoutburst/wallboard/congrats/"+data1;
				}
			});
				
		}

		//setTimeout(launchWallboard,<?php echo LAUNCH_WALLBOARD;?>);

		function runme() {
			window.location = "<?php echo base_url();?>wallboard/launch/<?=$nextslug?>";
		//	window.location = "http://www.google.com";
		}

		//setTimeout(runme,<?=$wb['screen_delay']*1000?>);

		$(function() {
		  setInterval(runme, <?=$wb['screen_delay']*1000?>);
		  if (bowser.msie ) {
		  	 var marqueetext = "<?=$wb['ticker_tape']?>";
		  	 $('.marquee').html("<marquee>"+marqueetext+"</marquee");
			}
			else{
				$('.marquee').marquee();
		  
			}
		});


		</script>

		<style>
		.marquee {
			background: rgb(252, 249, 209);
			overflow: hidden;
			height: 50px;
			width: 80%;
			margin:0 auto;
			display: block;
			line-height: 50px;
			vertical-align: middle;
			color:#2b9ff1;
			font-size:25px;
			font-weight: bold;		
		}
		</style>
		
</head>
<style>
#graph img {
display:none;
visibility:hidden
}
</style>
<body style='text-align:center;'>
<div id="wallboard-logo">
<?php if($wb['logo']!="no_image_uploaded.png"){?>
<img style="position: relative; left: 500px; top: 70px;" src="<?php echo base_url().WB_PHOTO."/".$wb['logo'];?>" width="10%"/>
</div><?php }?>
<?php echo $this->session->flashdata('message');?>
<span style='text-align:center'><h1><?=$wb['title']?></h1>
</span>
<div style='width: 800px;margin:0 auto;display:none;'>
	<ul id="js-news" class="js-hidden">
		<li class="news-item"><?=$wb['ticker_tape']?></li>
	</ul>
</div>
<!--[if IE]><script src="jquery-1.7.2.min.js"></script><![endif]-->
<div class="marquee" data-duplicated='false'><?=$wb['ticker_tape']?></div>
<div id="content">
	<div class="container">	
		<div id="report_content" class="cf">
			<div class='queryBuilderHtml'>
			<?php
			if($report['report_type']==="bar chart" ||$report['report_type']=== "pie chart" || $report['report_type']==="line graph" || $report['report_type']==="word cloud" )
			{
				render_chart($report);	
			}
			else if($report['report_type']==="data")
			{				
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
						<?php
						if (!$wallboard) {
						?>
							<div class="row content-header">
								<h1>Data Report</h1>
							</div>
						<?php
						}
						?>
							<div class="row content-body">
								
								<div style='float:right; padding-bottom:10px; padding-right:10px;'>
									<!--<a href='<?php echo base_url().'reports'?>'  class='btn btn-primary'>Back</a>
									  <a href='javascript:;' onClick='return false;' class='btn btn-primary'>Export to PDF</a>
									<a href='<?php echo base_url();?>reports/print_csv/<?php echo $report_id;?>' class='btn btn-primary'>Export to CSV</a>-->
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
				
					}else if($report['report_type']==="detail")
					{
						
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
									<?php
									if (!$wallboard) {
									?>
										<div class="row content-header">
											<h1>Detail Report View</h1>
										</div>
									<?php
									}
									?>							
									<div class="row content-body">
										
										<div style='float:right; padding-bottom:10px; padding-right:10px;'>
										  <!--	<a href='javascript:;' onClick='return false;' class='btn btn-primary'>Export to PDF</a>
											<a href='<?php echo base_url();?>reports/print_csv/<?php echo $report_id;?>'  class='btn btn-primary'>Export to CSV</a>
											<a href='<?php echo base_url().'reports'?>' class='btn btn-primary'>Back</a>-->
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
				<?php 	}
					}
				?>
			</div>
		</div><!-- #report_content -->
	</div>
</div>


</body>

</html>
