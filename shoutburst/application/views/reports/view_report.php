<script type="text/javascript" src="/js/jquery.min.js"></script>
<!-- JS Chart file need to be here because when ajax request send it will loaded again for each -->
<script type="text/javascript" src="/js/jscharts.js"></script>

<!--  

	Full graphs from dashboard and reports page 



-->
<style>
#graph img {
display:none;
visibility:hidden
}
</style>
<?php echo $this->session->flashdata('message');?>
<div id="content">
	<div class="container">	
		<div id="report_content" class="cf">
			<div class='queryBuilderHtml'>
			<?php
			render_chart($report);?>
			</div>
		</div><!-- #report_content -->
	</div>
</div>
<?php
if ($report['report_interval'] == "live") {
?>

        <script type="text/javascript">
	    var indy;
	    function livereload() {
		history.go(0);
         	}

            $(function() {
              indy = setTimeout(livereload, <?=LIVE_CHART_UPDATE_DURATION*1000?>);
            });
	</script>		


<?php
}
?>
