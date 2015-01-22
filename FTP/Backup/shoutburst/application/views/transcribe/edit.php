<?php echo $extraScripts; ?>
<style type="text/css">
	input[type='checkbox']{
		display: block !important;
	}
</style>
<link rel="stylesheet" type="text/css" href="../../../css/jplayer.blue.monday.css" />
<script type="text/javascript">
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
	 $("#jquery_jplayer_1").jPlayer({
		ready: function (event) {
			$(this).jPlayer("setMedia", {
				title: "Bubble",
				m4a: "<?php echo base_url() .'recordings/'. $transcription[0]['recording']?>",
				oga: "<?php echo base_url() .'recordings/'. $transcription[0]['recording']?>"
			});
		},
		swfPath: "../js",
		supplied: "m4a, oga",
		wmode: "window",
		smoothPlayBar: true,
		keyEnabled: true,
		remainingDuration: true,
		toggleDuration: true
	});

	$("form").submit(function (evt){
	 	var gender=$("input[name='gender']").val();
	 	var sentiment_score=$("input[name='sentiment_score']").val();
	 	var transcriptions_text=$("#transcriptions_text").val();
	 	var empty_recording=$("#empty_recording").attr("checked");
	 	var background_comments=$("#background_comments").attr("checked");
	 	console.log(empty_recording);
	 	console.log(background_comments);
	 	
	 	if(empty_recording!="checked" && background_comments != "checked")
		{
			if(!gender || !sentiment_score || !transcriptions_text) {
		    	alert("All fields must be filled");
		    	evt.preventDefault();
			}
		}
		//evt.preventDefault();
	});
        	
    $('#end').click(function(){
        $('#transcribe').attr('action',"<?php echo base_url().'transcribe/end';?>");
        $('#submit').trigger("click");
    });
    function showallboxes(background_comments){
    	if(background_comments!=1){
    		var i=0;
    	
        	if($("form").children().length <17){ 
	        	$("form").children().each(function(){
	        		
	        		if(i!=0 && i!=1 && i!=2 && i!=15)
	        			$(this).show();
	        		i++;
	        	});
			}
			else
			{
				$("form").children().each(function(){
	        		
	        		if(i!=0 && i!=1 && i!=2 && i!=3 && i!=16)
	        			$(this).show();
	        		i++;
	        	});
			}
		}
		else {
			var i=0;
    	
        	if($("form").children().length <17){ 
	        	$("form").children().each(function(){
	        		
	        		if(i>=5 && i!=15)
	        			$(this).show();
	        		i++;
	        	});
			}
			else
			{
				$("form").children().each(function(){
	        		
	        		if(i>5 && i!=16)
	        			$(this).show();
	        		i++;
	        	});
			}
		}
    }
    function hideallboxes(background_comments){
    	if(background_comments!=1){
        	var i=0;
        	if($("form").children().length <17){ 
        		$("form").children().each(function(){
        		
	        		if(i!=0 && i!=1 && i!=2 && i!=15)
	        			$(this).hide();
	        		i++;
        		});
        	}
        	else{
        		$("form").children().each(function(){
        		
	        		if(i!=0 && i!=1 && i!=2 && i!=3 && i!=16)
	        			$(this).hide();
	        		i++;
        		});	
        	}
    	}
    	else{
    		var i=0;
        	if($("form").children().length <17){ 
        		$("form").children().each(function(){
        		
	        		if(i>=5 && i!=15)
	        			$(this).hide();
	        		i++;
        		});
        	}
        	else{
        		$("form").children().each(function(){
        		
	        		if(i>5 && i!=16)
	        			$(this).hide();
	        		i++;
        		});	
        	}
    	}
    }

    $("#empty_recording").on('change', function(e) {
    	var status=$(this).attr("checked")
    	if(status == undefined){
    		showallboxes(0);
    	}
    	else{
    		hideallboxes(0);
    	}
    });



    $("#background_comments").on('change', function(e) {
    	var status=$(this).attr("checked")
    	if(status == undefined){
    		showallboxes(1);
    	}
    	else{
    		hideallboxes(1);
    	}
    });
});
//]]>
</script>
<div id="content" class="page-transcribe cf">
  <div class="container">
    <div class="row content-header">
      <?php echo anchor("transcribe","Cancel", array('class'=>('sb-btn btn-primary-red'))); ?>
      <h1>Edit Transcription</h1>
	</div>
    <div class="row content-body">
	  <div class="col-md-12">
<?php echo form_open_multipart('transcribe/edit', array('name'=>'transcribe', 'id'=>'transcribe', 'onsubmit'=>"return check_it(this)")) ?>

<?php echo $this->session->flashdata('message');?>
	<div class="form-group row">
		<div class="col-md-2">Recording Number:</div>
		<div class="col-md-3"><?php echo $transcription[0]['sur_id']?></div>
		<input type="hidden" name="sur_id" value="<?php echo $transcription[0]['sur_id']?>">
	</div>
	<div class="form-group row">
		<div class="col-md-3 col-md-offset-2">
			<!-- The jPlayer div must not be hidden. Keep it at the root of the body element to avoid any such problems. -->

<div id="jquery_jplayer_1" class="jp-jplayer"></div>
<div id="jp_container_1" class="jp-audio" role="application" aria-label="media player">
	<div class="jp-type-single">
		<div class="jp-gui jp-interface">
			<div class="jp-controls">
				<button class="jp-play" role="button" tabindex="0">play</button>
				<button class="jp-stop" role="button" tabindex="0">stop</button>
			</div>
			<div class="jp-progress">
				<div class="jp-seek-bar">
					<div class="jp-play-bar"></div>
				</div>
			</div>
			<div class="jp-volume-controls">
				<button class="jp-mute" role="button" tabindex="0">mute</button>
				<button class="jp-volume-max" role="button" tabindex="0">max volume</button>
				<div class="jp-volume-bar">
					<div class="jp-volume-bar-value"></div>
				</div>
			</div>
			<div class="jp-time-holder">
				<div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
				<div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
			</div>
		</div>
		<div class="jp-no-solution">
			<span>Update Required</span>
			To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
		</div>
	</div>
</div>

		</div>
	</div>
	

	<div class="form-group row">
		<div class="col-md-2"><label for="empty_recording">Empty Recording</label></div>
		<div class="col-md-3"><input type="checkbox" tabindex="1" autofocus="autofocus" rows="5" cols="15"  name="empty_recording" id="empty_recording" /></div>
	</div>


	<div class="form-group row">
		<div class="col-md-2"><label for="background_comments">Background Comments</label></div>
		<div class="col-md-3"><input type="checkbox" tabindex="1" autofocus="autofocus" rows="5" cols="15"  name="background_comments" id="background_comments" /></div>
	</div>


	<div class="form-group row">
		<div class="col-md-2"><label for="transcriptions_text">Transcription Text</label></div>
		<div class="col-md-3"><textarea tabindex="1" autofocus="autofocus" rows="5" cols="15" class="sb-textarea" name="transcriptions_text" id="transcriptions_text"><?php echo $transcription[0]['transcriptions_text']?></textarea></div>
	</div>
	<h4 class="transcribe-sub-heading">Sentiment Score:</h4>
	<div class="form-group row">
		<div class="col-md-2"><label for="ssHp">Highly Positive</label></div>
		<div class="col-md-3"><input tabindex="2" id="ssHp" type="radio" class="sb-radio" name="sentiment_score" <?php echo ($transcription[0]['sentiment_score'] == 'hp')?'checked="checked"':''?> value="hp"><label for="ssHp"><span></span></label></div>
	</div>
	<div class="form-group row">
		<div class="col-md-2"><label for="ssP">Positive</label></div>
		<div class="col-md-3"><input type="radio" id="ssP" name="sentiment_score" <?php echo ($transcription[0]['sentiment_score'] == 'p')?'checked="checked"':''?> value="p"><label for="ssP"><span></span></label></div>
	</div>
	<div class="form-group row">
		<div class="col-md-2"><label for="ssN">Neutral</label></div>
		<div class="col-md-3"><input type="radio" id="ssN" name="sentiment_score" <?php echo ($transcription[0]['sentiment_score'] == 'n')?'checked="checked"':''?> value="n" /><label for="ssN"><span></span></label></div>
	</div>
	<div class="form-group row">
		<div class="col-md-2"><label for="ssNeg">Negative</label></div>
		<div class="col-md-3"><input type="radio" id="ssNeg" name="sentiment_score" <?php echo ($transcription[0]['sentiment_score'] == 'neg')?'checked="checked"':''?> value="neg" /><label for="ssNeg"><span></span></label></div>
	</div>
	<div class="form-group row">
		<div class="col-md-2"><label for="ssHn">Highly Negative</label></div>
		<div class="col-md-3"><input type="radio" id="ssHn" name="sentiment_score" <?php echo ($transcription[0]['sentiment_score'] == 'hn')?'checked="checked"':''?> value="hn" /><label for="ssHn"><span></span></label></div>
	</div>
	<div class="form-group row">
		<div class="col-md-2"><label for="ssMpn">Mixed Positive/Negative</label></div>
		<div class="col-md-3"><input type="radio" id="ssMpn" name="sentiment_score" <?php echo ($transcription[0]['sentiment_score'] == 'mpn')?'checked="checked"':''?> value="mpn" /><label for="ssMpn"><span></span></label></div>
	</div>
	<h4 class="transcribe-sub-heading">Gender:</h4>
	<div class="form-group row">
		<div class="col-md-2"><label for="ssM">Male Customer</label></div>
		<div class="col-md-3"><input tabindex="3" type="radio" id="ssM" name="gender" <?php echo ($transcription[0]['gender'] == 'm')?'checked="checked"':''?> value="m" /><label for="ssM"><span></span></label></div>
	</div>
	<div class="form-group row">
		<div class="col-md-2"><label for="ssF">Female Customer</label></div>
		<div class="col-md-3"><input type="radio" id="ssF" name="gender" <?php echo ($transcription[0]['gender'] == 'f')?'checked="checked"':''?> value="f" /><label for="ssF"><span></span></label></div>
	</div>
	<div class="form-group row">
		<div class="col-md-2"><input type="hidden" name="transcription_id" id="transcription_id" value="<?php echo $transcription[0]['transcription_id']?>"/></div>
		<div class="col-md-3"><button tabindex="4" type="submit" name="submit" id="submit" class="btn btn-primary-green">Next</button></div>
                <div class="col-md-3"><a id="end" tabindex="5" class="btn btn-primary-red">End</a></div>
	</div>
</form>
      </div><!-- .col-md-12 -->
    </div><!-- .row-content-body -->
  </div><!-- .container -->
</div><!-- #content -->