<html><head><title><?php echo $title;?></title>

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.0/jquery.min.js"></script>  
<!--	<script src="< ?php echo base_url()?>js/jquery-ui.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url()?>js/jquery.min.js" type="text/javascript"></script>
-->

	<script src="<?php echo base_url(); ?>newsticker/includes/jquery.ticker.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>newsticker/includes/site.js" type="text/javascript"></script> 
    
<!-- JS Chart file need to be here because when ajax request send it will loaded again for each -->
<script type="text/javascript" src="<?php echo base_url()?>js/jscharts.js"></script>

<!-- Usman Bootstrap -->
	<link href="<?php echo base_url(); ?>newsticker/styles/ticker-style.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>css/style.css?ver=7" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/responsive.css" rel="stylesheet">
	<!-- Usman -->
	<link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
<script type='text/javascript' src='//cdn.jsdelivr.net/jquery.marquee/1.3.1/jquery.marquee.min.js'></script>
<script type='text/javascript' src='<?php echo base_url()?>js/bowser.js'></script>

    	<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/highcharts-3d.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
	
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
				background: rgb(153, 61, 61);
				height: 50px;
				width: 80%;
				margin:0 auto;
				display: block;
				line-height: 50px;
				vertical-align: middle;
				color:white;
				font-size:22px;
				
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
<img src="<?php echo base_url().WB_PHOTO."/".$wb['logo'];?>" width="10%"/>
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
							<div class="row content-header">
								<h1>Data Report</h1>
							</div>
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
									<div class="row content-header">
										<h1>Detail Report View</h1>
									</div>
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
