<?php
$segment = $this->uri->segment(1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title><?php echo $title;?></title>

<?php if ( ($this->uri->segment(2) != 'launch') && ($this->uri->segment(2) != 'congrats') ){?>

	<!-- Usman -->
	<link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
	<!--// Usman 2 -->
	
	<!-- Initialize jQuery -->
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.7.2.min.js"></script>
	
	<script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
	    
	<!-- jQuery Tags -->
	<link rel="stylesheet" href="<?php echo base_url()?>css/jquery.tagbox.css" />
	<script type="text/javascript" src="<?php echo base_url()?>js/jquery.campaignsbox.js"></script>
	<!--// jQuery Tags -->
	
	<!-- Bootstrap Confirm Box-->
	<script src="<?php echo base_url()?>js/jquery.confirm.js"></script>

	<!-- JW PLayer -->
<script type="text/javascript" src="../../jwplayer.js"></script>
<script type="text/javascript">jwplayer.key="CvAtSHkcmFQjxxbZw6S+xh0ykG5VNZLnmZIggA==";</script>
	
	<!-- Usman's Datatable -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>datatable/dt-bootstrap.css">
	<script type="text/javascript" src="<?php echo base_url(); ?>datatable/jquery.dataTables.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>datatable/dt-bootstrap.js"></script>
	<script type="text/javascript">
		$(document).ready( function () {
			$('#example').dataTable();
			$('#alertsDatatable').dataTable({"aaSorting": [[ 0, "desc" ]]}); 
			$('#usersDatatable').dataTable({"aaSorting": [[ 1, "asc" ]]}); 
			//report dashboard new datatble b/c of change sorting
			$('#dashboardDatatable').dataTable({ "aaSorting": [[ 1, "asc" ]],stateSave: true}); 
		} );
	</script>
	<!--// Usman's Datatable -->
	
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.jstepper.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.js"></script>
	<link href="<?php echo base_url(); ?>css/jquery-validator.css?v=10" rel="stylesheet" type="text/css" />
	
	<!-- Multi Select -->
	<link href="<?php echo base_url(); ?>css/multi-select.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo base_url(); ?>js/jquery.multi-select.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>js/jquery-quicksearch.js" type="text/javascript"></script>
	<!--// Multi Select -->
	
	<!-- jQuery Chosen -->
	<link href="<?php echo base_url(); ?>css/chosen.css?v=10" rel="stylesheet" type="text/css" />
	<script src="<?php echo base_url(); ?>js/chosen.jquery.js" type="text/javascript"></script>
	<!--// jQuery Chosen End-->
	
	<!-- jQuery Time Entry -->
	<script type="text/javascript" src="<?php echo base_url()?>js/jquery.plugin.js"></script> 
	<script type="text/javascript" src="<?php echo base_url()?>js/jquery.timeentry.js"></script>
	<link href="<?php echo base_url()?>css/jquery.timeentry.css" rel="stylesheet">
	<!--// jQuery Time Entry End -->
	
	<!-- Custom Jquery Method -->
	<script type="text/javascript" src="<?php echo base_url()?>js/custom_jquery.js"></script> 
	<!--// Custom Jquery Method-->
	
	<!-- Usman Bootstrap -->
	<link href="<?php echo base_url(); ?>css/style.css?ver=7" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/responsive.css" rel="stylesheet">
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	<link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico">
	<!--// Usman Bootstrap -->
	
	<!-- Arshad Bootstrap Datepicker -->
	<link href="<?php echo base_url(); ?>css/datepicker.css" rel="stylesheet">  
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery.datetimepicker.css"/ >
<script src="<?php echo base_url();?>js/jquery.datetimepicker.js"></script>
	</head>

<body>

<!-- NX FLICKER FIX -->
<script>
$("body").addClass(localStorage.getItem("mainNavState"));
</script>

	<!-- #left-nav -->
	<?php if ( isset($this->session->userdata['user_data']) && !empty($this->session->userdata['user_data'])){?>
	<div id="main-nav">
<!--		<a href="#" class="main-nav-toggle left"></a> -->
		<a class="logo"></a>
        <?php
		$access_level = $this->session->userdata['access'];
    	$transcriber = $this->session->userdata['transcriber'];
		
		switch ($access_level){
    		case SUPER_ADMIN:
				echo '<div class="nav active">';
				echo anchor("companies","<span class='icon icon-dashboard'></span>Companies", array('class'=>($segment=='companies'?'active':'')));
				echo '</div>';
			break;
			
			case COMP_ADMIN:
				echo '<div class="nav">';
				echo anchor("welcome", "<span class='icon icon-dashboard'></span>Dashboard", array('class'=>($segment=='dashboard'?'active':'')));
				echo anchor("tags","<span class='icon icon-teams'></span>Tag Store", array('class'=>($segment=='tags'?'active':'')));
				echo anchor("reports","<span class='icon icon-reports'></span>Reports", array('class'=>($segment=='reports'?'active':'')));
				echo anchor("wallboard","<span class='icon icon-wallboards'></span>Wallboards", array('class'=>($segment=='wallboard'?'active':'')));
				echo anchor("alerts","<span class='icon icon-alerts'></span>Alerts", array('class'=>($segment=='alerts'?'active':'')));
				echo anchor("users","<span class='icon icon-agents'></span>Users", array('class'=>($segment=='users'?'active':'')));
				if (isset($transcriber) && ($transcriber == 1)){
					echo anchor("transcribe","<span class='icon icon-transcriptions'></span>Transcriptions", array('class'=>($segment=='transcribe'?'active':'')));
				}
				echo '</div>';
			break;
			
			case COMP_AGENT:
				echo '<div class="nav">';
				echo anchor("welcome", "<span class='icon icon-dashboard'></span>Dashboard", array('class'=>($segment=='dashboard'?'active':'')));
				echo anchor("reports","<span class='icon icon-reports'></span>Reports", array('class'=>($segment=='reports'?'active':'')));
				echo '</div>';
			break;
		}		
		?>		
	</div>
	<?php }?>
	<!-- #left-nav -->
	
	<div id="header">
		<a href="#" class="header-toggle"></a>
		<div class="top">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-3 pull-right links">
						<a href="#">Admin</a> | 
						<a href="#">Faq</a> | 
						<a href="#">Help</a>
					</div>
				</div><!-- .row -->
			</div>
		</div><!-- .top -->
		<div class="user">
		  <div class="container-fluid">
			<div class="row">
				<div class="col-xs-2">
					<!--<a href="#" class="main-nav-toggle"></a>-->
				</div>
				
				<div class="col-xs-10 pull-right">
						
					<div class="user-info">
						<?php
						if (isset($this->session->userdata['photo']) && !empty($this->session->userdata['photo'])){
							$photo = $this->session->userdata['photo'];
						}else{
							$photo = 'noImageUploaded.png';
						}
						echo anchor( "/", img(array('src' => 'photos/user_photo/'.$photo, 'class' => 'thumb', 'width'=>'45', 'height'=>'45')) );
						?>
						<div class="dropdown">
						  <button class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
							<?php echo isset($this->session->userdata['full_name']) ? $this->session->userdata['full_name'] : ''; ?>
							<span class="caret"></span>
						  </button>
						  <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dropdownMenu1">
							  <li role="presentation"><?php echo anchor("logout","Logout"); ?></li>
							  <li role="presentation"><?php echo anchor("users/settings","Settings"); ?></li>
							</ul>
						</div>
					</div>
				</div>
			</div><!-- .row -->
		  </div>
		</div><!-- .user -->
	</div><!-- #header -->
<?php }?>
