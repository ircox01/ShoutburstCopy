<div id="content">
	<div class="container">
		<div class="row content-header">
			<a href="#" class="main-nav-toggle" style="left:15px;"></a><h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dashboard</h1>
		</div>
		<?php //var_debug($report_html);exit;?>
		<!-- .row -->
		<div class="row row-space">
			<ul class="funcs">
			<?php
			if (isset($dashboard)){
				for ($d = 1; $d <= 4; $d++ )
				{
				?>
					<?php if (isset($dashboard['qdr_'.$d])){?>
					<li id="<?php echo $dashboard['qdr_'.$d]; ?>" report_id="<?php echo $report_id[$d]?>" class="col-md-6">
					  <div class="chartbox">
					  <?php if (!empty($report_id[$d]) && ($report_id[$d] > 0)){?>
						<h3 class="title"></h3>
						<a href="#myModal" id='modal1' class="modal-iframe" role="button" data-toggle="modal" data-src="<?php echo base_url().'reports/view_report/'.$report_id[$d].'/d'?>" data-height=600 data-width=100% ></a>
						<?php if ( ($is_dashboard[$d] == 1) ){?>
						<iframe scrolling="no" width="100%" height="90%" style="border: 0px;" 
							src="<?php echo base_url().'reports/view_report/'.$report_id[$d].'/d'?>"></iframe>
						<?php }?>
						<?php } else { echo "<div style='margin:25%;text-align:center;'><img src='/shoutburst/img/logo_withbg.png' /></div>"; } ?>
					  </div>
					</li>
					<?php }else{?>
					<li><ul><div style="height: 400px;"></div></ul></li>
					<?php }?>
				<?php
				}


			} else {
				echo "<code>No report published</code>";
			}
			?>
			</ul>				
		</div>
		<!-- .row -->
		
	</div>
</div>
<!-- #content -->

<style type="text/css">
	.funcs { list-style-type: none; margin: 0; padding: 0; }
	.funcs li {
		margin-bottom: 20px;
	}
	li > div {
		padding: 10px;
		background-color: #fff;
		border: 1px solid #ccc;
		cursor: move;
		border-radius: 5px;
		position: relative;
	}
		.ui-sortable-helper > div {
			border: 1px dotted #333;
			color: #333;
			background: #fbfbfb;
			height: auto;
			z-index: 99999;		
		}
	
	a.modal-iframe {
		position: absolute;
		top: 10px;
		right: 10px;
		width: 36px;
		height: 34px;
		background: transparent url(images/full-view.png) no-repeat;
	}
	
	h3.title {
		text-transform: capitalize;
		font-weight: normal;
		color: #3fadf6;
		margin: 10px 100px 10px 0;
		padding: 0 0 20px;
		border-bottom: 1px solid #e1e8ed;
	}
	
</style> 

<script src="<?php echo base_url()?>js/jquery.ui.core.js"></script>
<script src="<?php echo base_url()?>js/jquery.ui.widget.js"></script>
<script src="<?php echo base_url()?>js/jquery.ui.mouse.js"></script>
<script src="<?php echo base_url()?>js/jquery.ui.sortable.js"></script>
<script src="<?php echo base_url()?>js/jquery.ui.swappable.js"></script>

<script type="text/javascript">
$(function() {
	$(".funcs").swappable({
		items: 'li',
		cursorAt: {top:-5}
	});
	$(".funcs").disableSelection();
});


function get_quardrant(){
	var data = new Array();
    var counter = 0;
	$(".funcs li").each(function(){
    	data[counter] = $(this).attr("id");
		counter++;
		return data;
	});

	var concat;
    concat = data.toString();
    $.ajax({
    	type: "POST",
        url: "<?php echo base_url().'dashboard/arrange_dashboard'?>",
        data: {'db_id': <?php echo $dashboard['db_id']?>, 'user_id': <?php echo $dashboard['user_id']?>, 'reports_id': concat},
        success: function(msg)
        {
        	//$("#container").html(msg);  
		}
	});
}
</script>

<!-- Modal -->
<div id="myModal" class="modal sb nohf fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
		<button type="button" class="sb-close" data-dismiss="modal" aria-hidden="true"></button>
		<div class="modal-body">
			<iframe frameborder="0"></iframe>
		</div><!-- .modal-body -->
    </div>
  </div>
</div>
<!--// Modal -->

<script>

	$('a.modal-iframe').on('click', function(e) {
		var src = $(this).attr('data-src');
		var height = $(this).attr('data-height') || 500;
		var width = $(this).attr('data-width') || '100%';

		var newSrc	=	src.slice(0,-1)+"full_view";
		
		$("#myModal iframe").attr({'src':newSrc,
								   'height': height,
								   'width': width,
								   'id':'iframeView'
								   });
	});
	
	//show.bs.modal
	// This event fires immediately when the show instance method is called. If caused by a click, the clicked element is available as the relatedTarget property of the event.
	$('#myModal').on('show.bs.modal', function (e) { 
	  // do something...
	//  alert('shown.bs.modal');
		//var windowHeight = $(window).height();
		var h = $(window).height();
		$(this).find('.modal-body').height( h - 20);
	})


</script>
