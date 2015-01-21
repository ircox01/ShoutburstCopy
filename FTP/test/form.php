<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	

<link rel="stylesheet" href="scripts/style.css" type="text/css" />
<link rel="stylesheet" href="scripts/form.css" type="text/css" />

<title>ContactAbility</title>
<script type="text/javascript">
	 var RecaptchaOptions = {
	    theme : 'clean'
	 };
	
</script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript"></script>
<script src="jquery.validate.min.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function(){
	$("#form").validate({
		errorPlacement: function(error,element) {
	    	return true;
		},   
    });
});
</script>	
</head>
<body>
<div id="all_content">
<div id="header_content">
	<div id="header_inner">
		<div id="logos">
			<a class="alignleft" href="index.html">
				<img src="images/calogo2.png" alt=''/>
			</a>
			<a class="alignright last-social" href="form.html"><img src="images/social_twitter.png" alt=''/></a>
			<a class="alignright" href="form.html"><img src="images/social_fb.png" alt=''/></a>
			<a class="alignright" href="form.html"><img src="images/tel.png" alt=''/></a>
		</div>
		<img src="images/line.png" alt=''/>
		<ul class="top_links">
			<li><a href="form.html">Setting up a homeworking programme</a></li>
			<li><a href="form.html">Access to Work</a></li>
			<li><a href="form.html">Call centre employee</a></li>
			<li><a href="form.html">Case studies</a></li>
			<li><a href="form.html">Events</a></li>
			<li><a href="form.html">Press</a></li>
			<li><a href="form.html">Contact</a></li>	
		</ul>
		<img src="images/line.png" alt=''/>
		
	</div>
</div>
<div id="main_content">
	<h1>Thank you for visiting</h1>
			<p>Contactability.org.uk will be a fantastic resource for the disabled and Contact Centre Managers alike. We will provide all sorts of information, advice and real-life examples. From case-studies, to accredited organisations, to partners who will be able to make all of this a reality, the site will meet all needs.</p>

<p>While we compile all of the information required, we would be delighted to hear from you. Using the form below, please contact us or register your interest, and we will ensure you receive news of updates and the upcoming launch in summer 2013.</p>
	
	<?php
		include_once('mail_form.php'); 
	?>
	<div id="stylized" class="myform">
		<form id="form" name="form" method="post" action="form.php">
					
			<label>Name<span class="small">Add your name</span></label>
			<input type="text" name="name" id="name" class="required" minlength="2" value="<?php echo $name; ?>"/>
			<div class="clear"></div>
			<label>Email<span class="small">Add a valid address</span></label>
			<input type="text" name="email" id="email" class="required email"  value="<?php echo $email; ?>"/>
			<div class="clear"></div>
			<label>Mobile number<span class="small">Add contact number</span></label>
			<input type="text" name="mobile" id="mobile"  value="<?php echo $mobile; ?>"/>
			<div class="clear"></div>
			<label>Main interest<span class="small">Select your area</span></label>
			<select name="interest" id="interest">
				<option value="Disability employment">Disability employment</option>
				<option value="Contact Centre management">Contact Centre management</option>
			</select>
			<div class="clear"></div>
			<label>Notes<span class="small">Your own notes</span></label>
			<textarea name="notes" id="notes"><?php echo $notes; ?></textarea>
			<div class="clear"></div>
	<script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=6LcVltsSAAAAAD4-QjNlaC4k3BgzI5LUtIlgc_c5">
	</script>

	<noscript>
	     <iframe src="http://www.google.com/recaptcha/api/noscript?k=6LcVltsSAAAAAD4-QjNlaC4k3BgzI5LUtIlgc_c5"
        	 height="300" width="500" frameborder="0"></iframe><br>
	     <textarea name="recaptcha_challenge_field" rows="3" cols="40">
	     </textarea>
	     <input type="hidden" name="recaptcha_response_field" value="manual_challenge">
	</noscript>
			
			<button type="submit">Leave feedback</button>
		</form>
	</div>
	<img src="images/line.png" alt=''/>
	<div id="partners">
		<table><tr>
			<td>Partners:</td>
			<td><a href="http://www.disabilityrightsuk.org/"><img class="less_opacity" src="images/logo_druk.png" alt=''/></a></td>
			<td><a href="http://www.invate.co.uk/"><img class="less_opacity" src="images/logo_invate.png" alt=''/></a></td>
			<td><a href="http://businessdisabilityforum.org.uk/"><img class="less_opacity" src="images/logo_bdf.png" alt=''/></a></td>
			<td><a href="http://www.performancetelecom.co.uk/"><img class="less_opacity" src="images/logo_pt.png" alt=''/></a></td>
		</tr></table>
	</div>
	<div id="participants">
		<table>
			<tr>
				<td align="left"><span class="bluish_b" align="left">Participants:</span></td>
				<td><ul>
					<li><a href="#">Amazon</a></li>
					<li><a href="#">Abbot Holdings</a></li>
					<li><a href="#">Abbacus Limited</a></li>
					<li><a href="#">Apple Corp</a></li>
					<li><a href="#">Blogos</a></li>
					<li><a href="#">International</a></li>
					<li><a href="#">Cambridge</a></li>
					<li><a href="#">Logistics</a></li>
					<li><a href="#">California Tech</a></li>
				</ul></td>
				<td><ul>
					<li><a href="#">Google</a></li>
					<li><a href="#">Boston Consulting Group</a></li>
					<li><a href="#">SAS Institute</a></li>
					<li><a href="#">Wegmans Food Market</a></li>
					<li><a href="#">Edward Jones</a></li>
					<li><a href="#">NetApp</a></li>
					<li><a href="#">Camden Property Trust</a></li>
					<li><a href="#">Recreational Equipment</a></li>
					<li><a href="#">(REI)</a></li>
				</ul></td>
				<td valign="top"><ul>
					<li><a href="#">Zappos.com</a></li>
					<li><a href="#">Mercedes-Benz USA</a></li>
					<li><a href="#">DPR Construction</a></li>
					<li><a href="#">DreamWorks Animation</a></li>
					<li><a href="#">NuStar Energy</a></li>
					<li><a href="#">Kimpton Hotels </a></li>
				</ul></td>
			</tr>
		</table>
	</div>
</div>
</div>
<div style="clear: both; margin-top:40px;"></div>
</body>
</html>
