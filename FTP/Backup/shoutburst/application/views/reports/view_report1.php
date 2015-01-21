<script type="text/javascript" src="/js/jquery.min.js"></script>
<!-- JS Chart file need to be here because when ajax request send it will loaded again for each -->
<script type="text/javascript" src="/js/jscharts.js"></script>

<!--  

	Dashboard graphs 
	
-->


<style>
#graph img {
display:hidden;
visibility:hidden
}
</style>
<center><img src='<?php echo base_url()?>images/simple-loader.png' id='loader' /></center>
<span style='text-align:center;'>
<?php echo $this->session->flashdata('message');?>
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
<div id="content">
	<div class="container">	
		<div id="report_content" class="cf">
			<div class='queryBuilderHtml'>
			<?php render_chart($report,1);?>
			</div>
		</div><!-- #report_content -->
	</div>
</div>
</span>
