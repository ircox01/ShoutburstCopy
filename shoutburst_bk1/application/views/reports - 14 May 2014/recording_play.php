	<!-- Initialize jQuery -->
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.7.2.min.js"></script>
	<?php echo $extraScripts; ?>
	<script type="text/javascript"><!--
	//<![CDATA[
	
	$(document).ready(function(){
	
		/*
		 * Instance CirclePlayer inside jQuery doc ready
		 *
		 * CirclePlayer(jPlayerSelector, media, options)
		 *   jPlayerSelector: String - The css selector of the jPlayer div.
		 *   media: Object - The media object used in jPlayer("setMedia",media).
		 *   options: Object - The jPlayer options.
		 *
		 * Multiple instances must set the cssSelectorAncestor in the jPlayer options. Defaults to "#cp_container_1" in CirclePlayer.
		 *
		 * The CirclePlayer uses the default supplied:"m4a, oga" if not given, which is different from the jPlayer default of supplied:"mp3"
		 * Note that the {wmode:"window"} option is set to ensure playback in Firefox 3.6 with the Flash solution.
		 * However, the OGA format would be used in this case with the HTML solution.
		 */
	
		var myCirclePlayer = new CirclePlayer("#jquery_jplayer_1",
		{
			m4a: "<?php echo base_url() .'recordings/'. $fileName?>",
			oga: "<?php echo base_url() .'recordings/'. $fileName?>"
		}, {
			cssSelectorAncestor: "#cp_container_1",			
			canplay: function() {
			    $("#jquery_jplayer_1").jPlayer("play");
		    },
			swfPath: "js",
			wmode: "window",
			keyEnabled: true
		});

			
	});
	//]]>
	</script>
	<style>
	
/* Transcribe Page
-------------------------------------*/
.row-space { padding-bottom: 20px; }
.page-transcribe .cp-container {
    height: 60px;
    width: 60px;
	padding: 0px;
	background: none;
}
.page-transcribe .cp-controls {
	padding: 0px;
}
	.page-transcribe .cp-controls li a {
		position: relative;
		display: block;
		width: 64px;
		height: 64px;
		text-indent: -9999px;
		z-index: 1;
		cursor: pointer;
	}
.page-transcribe .cp-circle-control { display: none; }
.page-transcribe .cp-buffer-holder, .cp-progress-holder { display: none !important; }

.page-transcribe .cp-controls .cp-play {
	background: url("<?php echo base_url();?>/img/aqua-play-icon.png") no-repeat;
}
.page-transcribe .cp-controls .cp-play:hover {
	background: url("<?php echo base_url();?>/img/aqua-play-icon.png");
	opacity: 0.8;
}
	.page-transcribe .cp-controls .cp-pause {
		background: url("<?php echo base_url();?>/img/aqua-pause-icon.png") no-repeat;
	}
	.page-transcribe .cp-controls .cp-pause:hover {
		background: url("<?php echo base_url();?>/img/aqua-pause-icon.png");
		opacity: 0.8;
	}

	
	</style>
	<div class='page-transcribe'>
		<div class="form-group row">
			<div class="col-md-3 col-md-offset-2">
				<!-- The jPlayer div must not be hidden. Keep it at the root of the body element to avoid any such problems. -->
				<div id="jquery_jplayer_1" class="cp-jplayer"></div>
				
				<!-- The container for the interface can go where you want to display it. Show and hide it as you need. -->
				<div id="cp_container_1" class="cp-container">
					<div class="cp-progress-holder"> <!-- .cp-gt50 only needed when progress is > than 50% -->
						<div class="cp-progress-1"></div>
						<div class="cp-progress-2"></div>
					</div>
					<div class="cp-circle-control"></div>
					<ul class="cp-controls">
						<li><a class="cp-play" tabindex="5">play</a></li>
						<li><a class="cp-pause" style="display:none;" tabindex="6">pause</a></li> <!-- Needs the inline style here, or jQuery.show() uses display:inline instead of display:block -->
					</ul>
				</div>
			</div>
		</div>
	</div>