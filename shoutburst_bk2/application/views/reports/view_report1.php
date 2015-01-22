<!--<script src="< ?php echo base_url()?>js/jquery-ui.min.js" type="text/javascript"></script>-->
<script src="<?php echo base_url()?>js/jquery.min.js" type="text/javascript"></script>
<!-- JS Chart file need to be here because when ajax request send it will loaded again for each -->
<script type="text/javascript" src="<?php echo base_url()?>js/jscharts.js"></script>

<style>
#graph img {
display:hidden;
visibility:hidden
}
</style>

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
