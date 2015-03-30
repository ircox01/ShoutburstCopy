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

<?php if ( ($this->uri->segment(2) != 'launch') && ($this->uri->segment(2) != 'congrats') ){ ?>

	<!-- Usman -->
	<link type="image/x-icon" href="/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="/css/multi-select.css" />	
	<link rel="stylesheet" type="text/css" href="/css/jquery.tagbox.css" />
	<link rel="stylesheet" type="text/css" href="/datatable/dt-bootstrap.css" />
	<!-- <link rel="stylesheet" type="text/css" href="/css/jquery-validator.css?v=10" /> -->
	<link rel="stylesheet" type="text/css" href="/css/chosen.css" /> 
	<!-- <link rel="stylesheet" type="text/css" href="/css/jquery.timeentry.css"/ > -->
	<link rel="stylesheet" type="text/css" href="/css/style.css" />
	<!-- <link rel="stylesheet" type="text/css" href="/css/responsive.css" /> -->
	<link rel="stylesheet" type="text/css" href="/css/datepicker.css" />  
	<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css" />

	<script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="/js/jquery.tablesorter.js"></script>
	<script type="text/javascript" src="/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/js/jquery.campaignsbox.js"></script>
	<script type="text/javascript" src="/js/jquery.confirm.js"></script>
	<script type="text/javascript" src="/jwplayer.js"></script> 
	<script type="text/javascript" src="/jwplayer.js">jwplayer.key="CvAtSHkcmFQjxxbZw6S+xh0ykG5VNZLnmZIggA==";</script>
	<script type="text/javascript" src="/datatable/jquery.dataTables.js"></script>
	<script type="text/javascript" src="/datatable/dt-bootstrap.js"></script>
	<script type="text/javascript">
		$(document).ready( function () {
			$('#example').dataTable();
			$('#myTable').tablesorter();
			$('#alertsDatatable').dataTable({"aaSorting": [[ 0, "desc" ]]}); 
			$('#usersDatatable').dataTable({"aaSorting": [[ 1, "asc" ]]}); 
			//report dashboard new datatble b/c of change sorting
			$('#dashboardDatatable').dataTable({ "aaSorting": [[ 1, "asc" ]],stateSave: true}); 
		} );
	</script>
	
	<script type="text/javascript" src="/js/jquery.datetimepicker.js"></script>
	<script type="text/javascript" src="/js/jquery.jstepper.js"></script>
	<script type="text/javascript" src="/js/jquery.validate.js"></script>
	<script type="text/javascript" src="/js/jquery.multi-select.js"></script>
	<script type="text/javascript" src="/js/jquery-quicksearch.js"></script>
	<script type="text/javascript" src="/js/chosen.jquery.js"></script>
	<script type="text/javascript" src="/js/jquery.plugin.js"></script> 
	<script type="text/javascript" src="/js/jquery.timeentry.js"></script>
	<script type="text/javascript" src="/js/custom_jquery.js"></script> 
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	<!--// Usman Bootstrap -->

<style type="text/css">
	form.cmxform label.error, label.error { color: red; font-style: italic }
	div.error { display: none; }

	input.checkbox { border: none }
	input:focus { border: 1px dotted black; }
	input.error { border: 1px dotted red; }
	form.cmxform .gray * { color: gray; }
	
	.timeEntry-control { vertical-align: middle;	margin-left: 2px;	}
	
	@media (max-width: 767px) { }
	@media (min-width: 768px) and (max-width: 991px) { }
	@media (min-width: 992px) and (max-width: 1199px) { }
	@media (min-width: 1200px) { }
	
</style> 
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
			
			case COMP_MANAGER:
				echo '<div class="nav">';
				echo anchor("welcome", "<span class='icon icon-dashboard'></span>Dashboard", array('class'=>($segment=='dashboard'?'active':'')));
				echo anchor("tags","<span class='icon icon-teams'></span>Tag Store", array('class'=>($segment=='tags'?'active':'')));
				echo anchor("reports","<span class='icon icon-reports'></span>Reports", array('class'=>($segment=='reports'?'active':'')));
				echo anchor("wallboard","<span class='icon icon-wallboards'></span>Wallboards", array('class'=>($segment=='wallboard'?'active':'')));
				echo anchor("users","<span class='icon icon-agents'></span>Users", array('class'=>($segment=='users'?'active':'')));
				
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
	<!-- 					<a href="#">Admin</a> | --> 
	<!--					<a href="#">Faq</a> | -->
	<!--					<a href="#">Help</a> -->
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
							<?php if ($access_level == COMP_ADMIN) {?>
							  <li role="presentation"><?php echo anchor("media/links","Agent Indicator Links"); ?></li>
							<?php } ?>
							</ul>
						</div>
					</div>
				</div>
			</div><!-- .row -->
		  </div>
		</div><!-- .user -->
	</div><!-- #header -->
<?php }?>
