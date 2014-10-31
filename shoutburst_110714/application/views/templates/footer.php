<script type="text/javascript">
function launchWallboard(){
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

//setTimeout(launchWallboard,<?php //echo LAUNCH_WALLBOARD;?>);

</script><?php if ( ($this->uri->segment(2) != 'launch') && ($this->uri->segment(2) != 'congrats') ){?>
	<script src="<?php echo base_url(); ?>js/scripts.js"></script>
	
<?php }?>

</body>
</html>





