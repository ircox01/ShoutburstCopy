<?php echo $extraScripts; ?>
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

	var myCirclePlayer = new CirclePlayer("#jquery_jplayer_1",
	{
		m4a: "<?php echo base_url() .'recordings/'. $transcription[0]['recording']?>",
		oga: "<?php echo base_url() .'recordings/'. $transcription[0]['recording']?>"
	}, {
		cssSelectorAncestor: "#cp_container_1",
		swfPath: "js",
		wmode: "window",
		keyEnabled: true
	});
});
//]]>
</script>

<div id="content" class="page-transcribe cf">
  <div class="container">
    <div class="row content-header">
      <?php echo anchor("transcribe","Back", array('class'=>('sb-btn sb-btn-white'))); ?>
      <h1>Edit Transcription</h1>
	</div>
    <div class="row content-body">
	  <div class="col-md-12">
<?php echo form_open_multipart('transcribe/edit', array('name'=>'transcribe', 'id'=>'transcribe', 'onsubmit'=>"return check_it(this)")) ?>

<?php echo $this->session->flashdata('message');?>
	<div class="form-group row">
		<div class="col-md-2">Recording Number:</div>
		<div class="col-md-3"><?php echo $transcription[0]['sur_id']?></div>
	</div>
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
	
	<div class="form-group row">
		<div class="col-md-2"><label for="transcriptions_text">Transcription Text</label></div>
		<div class="col-md-3"><textarea tabindex="1" autofocus="autofocus" rows="5" cols="15" class="sb-textarea" name="transcriptions_text" id="transcriptions_text"><?php echo $transcription[0]['transcriptions_text']?></textarea></div>
	</div>
	<h4 class="transcribe-sub-heading">Sentiment Score:</h4>
	<div class="form-group row">
		<div class="col-md-2"><label for="ssHp">Highly Positive</label></div>
		<div class="col-md-3"><input tabindex="2" id="ssHp" type="radio" class="sb-radio" name="sentiment_score" <?php echo ($transcription[0]['sentiment_score'] == 'hp')?'checked="checked"':''?> value="	hp"><label for="ssHp"><span></span></label></div>
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
		<div class="col-md-3"><button tabindex="4" type="submit" name="submit" id="submit" class="sb-btn sb-btn-green">Save</button></div>
	</div>
</form>
      </div><!-- .col-md-12 -->
    </div><!-- .row-content-body -->
  </div><!-- .container -->
</div><!-- #content -->