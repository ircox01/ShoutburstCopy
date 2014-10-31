<script type="text/javascript">
function launchWallboard(){
		$.ajax({
			url: "<?php echo base_url();?>wallboard/wallboard_launch",
			datatype:"html"
			}).done(function(data) {				
				if(data.trim()!='1' && data.trim() !=1)
				{					
					window.location="/shoutburst/wallboard/congrats/";					
				}
			});
		
}

setTimeout(launchWallboard,<?php echo LAUNCH_WALLBOARD;?>);

</script><?php if ( ($this->uri->segment(2) != 'launch') && ($this->uri->segment(2) != 'congrats') ){?>
	<script src="<?php echo base_url(); ?>js/scripts.js"></script>
	
<?php }?>

</body>
</html>





