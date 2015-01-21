<?php
/*
 * Plugin Name: Double Opt Contact Form
 * Plugin URI: http://ulike123.co/double-opt-contact-form/
 * Description: Helps adding a precise Safe Harbor compliant, CRM alike Double Opt Contact Form to WP User's profile.
 * Author: www.ulike123.co
 * Version: 1.2.3
 * Author URI: http://ulike123.co/
 * License: GPL2+
 * License URI: http://wordpress.org/about/gpl/
 * Text Domain: ulike123
 * Domain Path: /double-opt-contact-form/
*/

/*  Copyright 2012  ulike123( ulike123.co )

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2+, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Direct File access to this file is Forbidden
if (realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
	exit('Please don\'t access this file directly.');exit();
}

// Direct calls to this file are Forbidden when wp core files are not present
if (!function_exists ('add_action')) {
	exit('Please install WordPress before accessing this file.');exit();
}

function double_opt_contact_form_is_email($new_email=''){ if( $new_email==get_option('admin_email') ){return false;} $web = double_opt_contact_form_whois(); return( (!@empty($new_email)) ? @preg_match('/^([\w-]+(?:\.[\w-]+)*)@(\b'. $web['site'] . '.' . $web['.ext'] .'\b)$/i',$new_email): false ); }

function double_opt_contact_form_dam($data=''){
	$data = @mb_strtolower(trim(htmlentities(strip_tags($data))),'utf-8');
	if (get_magic_quotes_gpc()){$data = stripslashes($data);}
	$search=array("\\","\0","\n","\r","\x1a","'",'"');
	$replace=array("\\\\","\\0","\\n","\\r","\Z","\'",'\"');
	return str_replace($search,$replace,$data);
}

function double_opt_contact_form_whois(){
	$hostadrs         = @mb_strtolower(double_opt_contact_form_dam($_SERVER['SERVER_NAME']),'utf-8');
	$hostadrs         = (!empty($hostadrs)) ? $hostadrs : 'www.wdrp.biz';
	$hostname       = (!empty($hostadrs)) ? explode('.', $hostadrs) : $hostadrs;
	$langcode         = @mb_strtolower(double_opt_contact_form_dam($_SERVER['HTTP_ACCEPT_LANGUAGE']),'utf-8');
	$langcode         = (!empty($langcode)) ? $langcode : '';
	$langcode         = (!empty($langcode)) ? explode(';', $langcode) : $langcode;
	$langcode         = (!empty($langcode['0'])) ? explode(',', $langcode['0']) : $langcode;
	$langcode         = (!empty($langcode['0'])) ? explode('-', $langcode['0']) : $langcode;
	$langcode['1']    = (!empty($langcode['1'])) ? $langcode['1']       : 'us';
	if($hostname[0]=='www' && count($hostname)==3){
		$langcode['subs'] = $hostname[0];
		$langcode['site'] = $hostname[1];
		$langcode['.ext'] = $hostname[count($hostname)-1];
	}else{
		$langcode['.ext'] = $hostname[count($hostname)-1];
		$langcode['site'] = $hostname[count($hostname)-2];
		$langcode['subs'] = substr($hostadrs,0,stripos($hostadrs,'.'.$langcode['site'].'.'));
	}
	$langcode['lang']  = (!empty($langcode['0'])) ? $langcode['0']       : 'en';
	$langcode['loca']  = $langcode['1'];
	$langcode['subs'] = (!empty($langcode['subs'])) ? $langcode['subs'] : 'www';
	$langcode['site']   = (!empty($langcode['site'])) ? $langcode['site'] : 'wdrp';
	$langcode['.ext']   = (!empty($langcode['.ext'])) ? $langcode['.ext'] : 'biz';
	$langcode['indx']  = ($langcode['subs']=='www')  ? substr($langcode['site'],0,1) : substr($langcode['subs'],0,1);
	return array_slice($langcode,2);
}

function double_opt_contact_form_is_compatible_os(){
	$useragent = $_SERVER['HTTP_USER_AGENT'];
	$OSList = array
	(
	  'Berr','iPho','iPo','iPa','table','desk','Firmwar','Station','Box','TV','Antro','Andro','Actro','Anthro','PSP','Commodo','Xin','Plan','Palm',
	  'PowerPC','Power PC','Macintosh','Server','NeXT','Cheetah','Subversion','Leopard','XAMPP','Tiger','Panther','Jaguar','Mac','PC',
	  'Sun OS','SunOS','Linux','X11','ubuntu','Solar','Unix','Xenix','fedora','Kubuntu','mint', 'Cent','Lynx','Linx','Sun','Appl','X12','X14',
	  'HP','GNU','Infer','IBM','lenova','Minx','MicroC','GPL','POSIX','Opal','Alpha','Kernel','Oracl',
	  'WindowsNT','Windows NT','WinNT','Win NT', 'Win','Microsoft','Net',
	  'Open BSD','OpenBSD', 'BSD',
	  'OS/2', 'OS/3', 'OS/4',
	  'BeOS','Be OS',
	  'QNX'
	);
	foreach($OSList as $os){if(stristr($useragent,$os))return(true);}
	return(false);
}

function double_opt_contact_form_mail_utf8($subject = 'Hello', $message = 'Hello', $headers = '', $type='text/plain') {
	function page_errs_dump($errno, $errstr, $errfile, $errline){return null;}
	function page_exps_dump($exp){return null;}
	@set_error_handler('page_errs_dump');
	@set_exception_handler('page_exps_dump');
	@error_reporting(0);
	@ignore_user_abort(true);
	@set_time_limit(120);
	@ini_set('max_execution_time', 120);
	@ini_set('max_input_time', 120);
	@date_default_timezone_set('GMT');
	@mb_regex_encoding('UTF-8');
	@mb_language('uni');
	@mb_internal_encoding('UTF-8');
	$to = get_option('admin_email');
	$headers .= chr(13).chr(10) .
				'MIME-Version: 1.0' . chr(13).chr(10) .
				'Content-type: ' .$type. '; charset=UTF-8' . chr(13).chr(10) .
				'X-Priority: 1 (Higuest)' . chr(13).chr(10) .
				'X-MSMail-Priority: High' . chr(13).chr(10) .
				'Importance: High' . chr(13).chr(10) .
				'X-Mailer: PHP/' . phpversion();
	$message = wordwrap($message, 70, "\r\n", true);
	$subject = wordwrap($subject, 70, "\r\n", true);
	$subject = mb_encode_mimeheader($subject,'UTF-8','B',chr(13).chr(10));
	$message = mb_convert_encoding($message,'UTF-8',mb_detect_encoding($message));
	if ( !get_option( 'double_opt_contact_form_no_wild_os' ) ) { 
		return(mail($to, $subject, $message, $headers));
	}else{
		if( double_opt_contact_form_is_compatible_os() ){ return mail($to, $subject, $message, $headers); }
		return false;
	}
}

function users_form($user_id) {
	$web = double_opt_contact_form_whois();
	$web = 'www.' . $web['site'] . '.' . $web['.ext'];
	$double_opt_contact_form_no_ulike123_soa = get_option( 'double_opt_contact_form_no_ulike123_soa' );
	$double_opt_contact_form_no_plugin_backlink = get_option( 'double_opt_contact_form_no_plugin_backlink' );
	$double_opt_contact_form_header_html = get_option( 'double_opt_contact_form_header_html' );
?>
	<table class="form-table">
	<tr><td style="border: 4px double #f9f9f9; text-align: left; background:#f4f4f4; max-height:60px; height:60px;" colspan="2"><h3>
	<?php
                if ( !$double_opt_contact_form_no_ulike123_soa ) {
	?>
		<a href="javascript:void(0);" onclick="javascript:window.open('http://ulike123.co/soa/?ssl=no&amp;site=<?php echo $web; ?>','ulike123_SOA','status=1,resizable=1,location=1,scrollbars=1,toolbar=0,directories=0,menubar=0,height=411,width=600');" target="_top" title="Click to check this merchant and the related site!">
		<img alt="ulike123 SOA" style="margin: 0 3px 0 0; padding:0 3px 0 0;" src="//ulike123.co/images/ulike123-barcode-seal.png" border="0" vspace="0" hspace="3px" />Accredited?! by ulike123&reg; SOA</u></a>
      <?php }
                if ( !$double_opt_contact_form_no_plugin_backlink ) {
	?>
	&nbsp;&nbsp;&nbsp;
		<a href="//ulike123.co/double-opt-contact-form/" title="Visit this plugin's page.." target="_blank"><?php print 'Contact Form' ?></a>
	&nbsp;&nbsp;&nbsp;
	<?php }
	          if ( !empty( $double_opt_contact_form_header_html ) ) { echo 'Contact Form';}#$double_opt_contact_form_header_html; }
	?>

	</h3></td>
	</tr>
	<tr>
	<th><label for="double_opt_contact_form_subject"><?php _e('Subject','double_opt_contact_form_subject'); ?></label></th>
	<td>
		<input type="text" name="double_opt_contact_form_subject" id="double_opt_contact_form_subject" value="<?php echo esc_attr(get_user_meta( $user_id, 'double_opt_contact_form_subject', true )); ?>" class="regular-text"/><br/>
	<span class="description"><?php _e('Optionally, enter a Subject to be sent or saved for later use.','double_opt_contact_form_subject_description'); ?></span>
	</td>
	</tr>
	<tr>
	<th><label for="double_opt_contact_form_message"><?php _e('Message','double_opt_contact_form_message'); ?></label></th>
	<td>
		<textarea rows="5" cols="30" name="double_opt_contact_form_message" id="double_opt_contact_form_message"><?php echo esc_attr(get_user_meta( $user_id, 'double_opt_contact_form_message', true )); ?></textarea><br/>
		<span class="description"><?php _e('Optionally, leave a Message to be sent or saved for later use.','double_opt_contact_form_message_description'); ?></span>
	</td>
	</tr>
	<tr>
	<th><label for="double_opt_contact_form_send"><?php _e('Send Now!','double_opt_contact_form_send'); ?></label></th>
	<td>
		<input type="checkbox" name="double_opt_contact_form_send" id="double_opt_contact_form_send" value="false" onclick="javascript: this.value = (this.value=='true') ? 'false' : 'true';" />&nbsp;
		<span class="description"><?php _e('Optionally, check this to send the email Message. Kindly be sure, because your message will go directly to this Blog Admin\'s Email.','double_opt_contact_form_send_description'); ?></span>
	</td>
	</tr>
		<tr><td style="border: 4px double #f9f9f9; text-align: center; background:#f4f4f4;" colspan="2"><?php _e('End of Email Message that goes to this Blog Admin\'s Email.','double_opt_contact_form_message_end'); ?></td></tr>
	<tr>
	<th><label><?php _e('Log','double_opt_contact_form_log'); ?></label></th>
	<td>
	<?php echo get_user_meta( $user_id, 'double_opt_contact_form_log', true ); ?>
	</td>
	</tr>
		<tr><td style="border: 4px double #f9f9f9; text-align: center; background:#f4f4f4;" colspan="2"><?php _e('End of Log showing last results of Double Opt Contact Form submission.','double_opt_contact_form_log_end'); ?></td></tr>
	</table>
<?php
}

function admins_form($user_id) {
	$web = double_opt_contact_form_whois();
	$eml = '@' . $web['site'] . '.' . $web['.ext'];
	$web = 'www.' . $web['site'] . '.' . $web['.ext'];
	$double_opt_contact_form_no_wild_os = get_option( 'double_opt_contact_form_no_wild_os' );
	$double_opt_contact_form_no_ulike123_soa = get_option( 'double_opt_contact_form_no_ulike123_soa' );
	$double_opt_contact_form_no_plugin_backlink = get_option( 'double_opt_contact_form_no_plugin_backlink' );
	$double_opt_contact_form_header_html = get_option( 'double_opt_contact_form_header_html' );
?>
	<script type="text/javascript">
		//
		function this_empty(mixed)
		{try{
			var key;
			mixed = mixed.replace(/^\s+|\s+$/g, '');
			mixed = mixed.toLowerCase();
			if (   mixed       === 0 ||
				mixed        === 0.0 ||
				mixed        === null ||
				mixed        === false ||
				mixed        === '' ||
				mixed        === '0' ||
				mixed        === '0.0' ||
				mixed        === '\0' ||
				mixed        === 'null' ||
				mixed        === 'false' ||
				typeof mixed === 'undefined') {return true;}
			if (typeof mixed == 'object'){
				for (key in mixed){
					return false;
				}
				return true;
			}
			return false;
		}catch(e){return(false);}}
	</script>
	<table class="form-table">
	<tr><td style="border: 4px double #f9f9f9; text-align: left; background:#f4f4f4; max-height:60px; height:60px;" colspan="2"><h3>
	<?php
                if ( !$double_opt_contact_form_no_ulike123_soa ) {
	?>
		<a href="javascript:void(0);" onclick="javascript:window.open('http://ulike123.co/soa/?ssl=no&amp;site=<?php echo $web; ?>','ulike123_SOA','status=1,resizable=1,location=1,scrollbars=1,toolbar=0,directories=0,menubar=0,height=411,width=600');" target="_top" title="Click to check this merchant and the related site!">
		<img alt="ulike123 SOA" style="margin: 0 3px 0 0; padding:0 3px 0 0;" src="//ulike123.co/images/ulike123-barcode-seal.png" border="0" vspace="0" hspace="3px" />Accredited?! by ulike123&reg; SOA</u></a>
      <?php }
                if ( !$double_opt_contact_form_no_plugin_backlink ) {
	?>
	&nbsp;&nbsp;&nbsp;
		<a href="//ulike123.co/double-opt-contact-form/" title="Visit this plugin's page.." target="_blank"><?php print 'Contact Form'?></a>
	&nbsp;&nbsp;&nbsp;
	<?php }
	          if ( !empty( $double_opt_contact_form_header_html ) ) { echo 'Contact Form';}#$double_opt_contact_form_header_html; }
	?>
	</h3></td>
	</tr>
	<tr>
	<th><label for="double_opt_contact_form_from_email"><?php _e('From','double_opt_contact_form_from'); ?></label></th>
	<td>
		<input type="text" name="double_opt_contact_form_from_email" id="double_opt_contact_form_from_email" value="<?php echo get_option( 'double_opt_contact_form_from_email' ); ?>" class="regular-text"/><br/>
	<span class="description">
	<?php echo	
				__('Necessarily, enter a From email to be saved as a spring of all communication that goes to this Blog Admin\'s Email. Must be different from Blog Admin\'s Email and must end with ','double_opt_contact_form_from_email_description') . 
				'<font style="background: #ededff; font-weight:900; ">' . $eml . '</font>' . __(' to avoid spamming, spoofing, and From/To email similarity. ', 'double_opt_contact_form_from_email_avoid_sp') . 
				__('Cannot be empty! Must be added to this Blog Admin\'s Email contacts using its host email client (e.g. gmail, any hosting-company-specific-web-based client program like Squirrel Mail or so). ', 'double_opt_contact_form_from_email_warning') . 
			__('If this From email doesn\'t exist on your Blog\'s host, sent emails may always be caught as Spam/Junk. 
				Kindly, make sure this From email exists and you are the one who has access to it, although no emails go to it as previously mentioned. By default, it is ', 'double_opt_contact_form_from_email_exists') . 
				'<font style="background: #ededff; font-weight:900; ">(postmaster' . $eml . ')</font>' . __(' to avoid spamming, spoofing, and From/To email similarity. ', 'double_opt_contact_form_from_email_avoid_sp');
	?>
	</span>
	</td>
	</tr>
	<tr>
	<th><label for="double_opt_contact_form_no_wild_os"><?php _e('No Wild OS','double_opt_contact_form_no_wild_os'); ?></label></th>
	<td>
		<input type="checkbox" name="double_opt_contact_form_no_wild_os" id="double_opt_contact_form_no_wild_os" value="<?php echo $double_opt_contact_form_no_wild_os; ?>" <?php echo (!$double_opt_contact_form_no_wild_os) ? '' : 'checked="checked"' ; ?> onclick="javascript: this.value = (this_empty(this.value)) ? false : true;" />&nbsp;
		<span class="description"><?php _e('Optionally, check this to exclude any Wild OS from sending from your Blog. Wild OS means/includes all unknown/rare operating systems and all mobiles excepts well known operating systems or platforms (e.g. Mac, Linux, Win, Android, Apple\'s Firmwares, Berries, most Palms\', most Tablets\' etc..) .','double_opt_contact_form_no_wild_os_description'); ?></span>
	</td>
	</tr>
	<tr>
	<th><label for="double_opt_contact_form_no_ulike123_soa"><?php _e('No ulike123&reg; SOA','double_opt_contact_form_no_ulike123_soa'); ?></label></th>
	<td>
		<input type="checkbox" name="double_opt_contact_form_no_ulike123_soa" id="double_opt_contact_form_no_ulike123_soa" value="<?php echo $double_opt_contact_form_no_ulike123_soa; ?>" <?php echo (!$double_opt_contact_form_no_ulike123_soa) ? '' : 'checked="checked"' ; ?> onclick="javascript: this.value = (this_empty(this.value)) ? false : true;" />&nbsp;
		<span class="description"><?php _e('Optionally, uncheck this to add ulike123&reg; SOA, Seal of Accreditation, automatically (on your form title spot and back to your site after accrediting your site, if your site qualifies).','double_opt_contact_form_no_ulike123_soa_description'); ?>&nbsp;<a href="http://ulike123.co/about-ulike123-soa.php" title="What's this!?" target="_blank">Read more..</a></span>
	</td>
	</tr>
	<tr>
	<th><label for="double_opt_contact_form_no_plugin_backlink"><?php _e('No Plugin Backlink','double_opt_contact_form_no_plugin_backlink'); ?></label></th>
	<td>
		<input type="checkbox" name="double_opt_contact_form_no_plugin_backlink" id="double_opt_contact_form_no_plugin_backlink" value="<?php echo $double_opt_contact_form_no_plugin_backlink; ?>" <?php echo (!$double_opt_contact_form_no_plugin_backlink) ? '' : 'checked="checked"' ; ?> onclick="javascript: this.value = (this_empty(this.value)) ? false : true;" />&nbsp;
		<span class="description"><?php _e('Optionally, uncheck this to add Double Opt Contact Form title\'s link that goes back to Double Opt Contact Form website automatically (on your form title spot and back to this plugin\'s site).','double_opt_contact_form_no_plugin_backlink_description'); ?>&nbsp;<a href="http://ulike123.co/double-opt-contact-form/" title="What's this!?" target="_blank">Visit the backlink!?</a></span>
	</td>
	</tr>
	<tr>
	<th><label for="double_opt_contact_form_header_html"><?php _e('Header HTML (Advanced)','double_opt_contact_form_header_html'); ?></label></th>
	<td>
		<textarea rows="5" cols="30" name="double_opt_contact_form_header_html" id="double_opt_contact_form_header_html"><?php echo $double_opt_contact_form_header_html; ?></textarea><br/>
		<span class="description"><?php _e('Optionally, append a custom HTML Header to your Double Opt Contact Form Header (e.g. custom title, custom links etc..) in addition to the previous two options, if one or both of them is unchecked (Advanced).','double_opt_contact_form_header_html_description'); ?></span>
	</td>
	</tr>
		<tr><td style="border: 4px double #f9f9f9; text-align: center; background:#f4f4f4;" colspan="2"><?php _e('End of Email Settings. Only displayed for Admins.','double_opt_contact_form_settings_end'); ?></td></tr>
	<tr>
	<th><label for="double_opt_contact_form_subject"><?php _e('Subject','double_opt_contact_form_subject'); ?></label></th>
	<td>
		<input type="text" name="double_opt_contact_form_subject" id="double_opt_contact_form_subject" value="<?php echo esc_attr(get_user_meta( $user_id, 'double_opt_contact_form_subject', true )); ?>" class="regular-text"/><br/>
	<span class="description"><?php _e('Optionally, enter a Subject to be sent or saved for later use.','double_opt_contact_form_subject_description'); ?></span>
	</td>
	</tr>
	<tr>
	<th><label for="double_opt_contact_form_message"><?php _e('Message','double_opt_contact_form_message'); ?></label></th>
	<td>
		<textarea rows="5" cols="30" name="double_opt_contact_form_message" id="double_opt_contact_form_message"><?php echo esc_attr(get_user_meta( $user_id, 'double_opt_contact_form_message', true )); ?></textarea><br/>
		<span class="description"><?php _e('Optionally, leave a Message to be sent or saved for later use.','double_opt_contact_form_message_description'); ?></span>
	</td>
	</tr>
	<tr>
	<th><label for="double_opt_contact_form_send"><?php _e('Send Now!','double_opt_contact_form_send'); ?></label></th>
	<td>
		<input type="checkbox" name="double_opt_contact_form_send" id="double_opt_contact_form_send" value="false" onclick="javascript: this.value = (this.value=='true') ? 'false' : 'true';" />&nbsp;
		<span class="description"><?php _e('Optionally, check this to send the email Message. Kindly be sure, because your message will go directly to this Blog Admin\'s Email.','double_opt_contact_form_send_description'); ?></span>
	</td>
	</tr>
		<tr><td style="border: 4px double #f9f9f9; text-align: center; background:#f4f4f4;" colspan="2"><?php _e('End of Email Message that goes to this Blog Admin\'s Email.','double_opt_contact_form_message_end'); ?></td></tr>
	<tr>
	<th><label><?php _e('Log','double_opt_contact_form_log'); ?></label></th>
	<td>
	<?php echo get_user_meta( $user_id, 'double_opt_contact_form_log', true ); ?>
	</td>
	</tr>
		<tr><td style="border: 4px double #f9f9f9; text-align: center; background:#f4f4f4;" colspan="2"><?php _e('End of Log showing last results of Double Opt Contact Form submission.','double_opt_contact_form_log_end'); ?></td></tr>
	</table>
<?php
}

function show_double_opt_contact_form ($user) { if( current_user_can( 'add_users', $user->id ) ) { admins_form($user->id); }else{ users_form($user->id); } }

function save_double_opt_contact_form ($user_id) {

	if ( current_user_can( 'add_users', $user_id ) ) // This if clause makes it for "Admins Only".. Modify carefully..
	{
		$from_new_email = trim( $_POST['double_opt_contact_form_from_email'] );

		if ( double_opt_contact_form_is_email ( $from_new_email ) )
		{
			if (  update_option( 'double_opt_contact_form_from_email', $from_new_email  ) )
			{
					$log .=  '<p><strong>' . __('Result: ', 'double_opt_contact_form_result') . '</strong>' . __('I successfully! updated From email.', 'double_opt_contact_form_from_email_updated') . '</p>' . "\r\n";
			}else{
					$log .=  '<p><strong>' . __('Result: ', 'double_opt_contact_form_result') . '</strong>' . __('I couldn\'t update From email. Nothing new for saving or I should try again..', 'double_opt_contact_form_from_email_failed') . '</p>' . "\r\n";
			}
		}else{
				$log .=  '<p><strong>' . __('Result: ', 'double_opt_contact_form_result') . '</strong>' . __('I entered a wrong From email (e.g. this Blog Admin\'s Email, or any badly formatted email that can\'t be saved as a From email.) .', 'double_opt_contact_form_from_email_wrong') . '</p>' . "\r\n";
		}

		if (  update_option( 'double_opt_contact_form_no_wild_os', $_POST['double_opt_contact_form_no_wild_os'] )  )
		{
				$log .=  '<p><strong>' . __('Result: ', 'double_opt_contact_form_result') . '</strong>' . __('I successfully! updated No Wild OS option.', 'double_opt_contact_form_no_wild_os_updated') . '</p>' . "\r\n";
		}else{
				$log .=  '<p><strong>' . __('Result: ', 'double_opt_contact_form_result') . '</strong>' . __('I couldn\'t update No Wild OS option. Nothing new for saving or I should try again..', 'double_opt_contact_form_no_wild_os_failed') . '</p>' . "\r\n";
		}

		if (  update_option( 'double_opt_contact_form_no_ulike123_soa', $_POST['double_opt_contact_form_no_ulike123_soa'] )  )
		{
				$log .=  '<p><strong>' . __('Result: ', 'double_opt_contact_form_result') . '</strong>' . __('I successfully! updated No ulike123&reg; SOA option.', 'double_opt_contact_form_no_ulike123_soa_updated') . '</p>' . "\r\n";
		}else{
				$log .=  '<p><strong>' . __('Result: ', 'double_opt_contact_form_result') . '</strong>' . __('I couldn\'t update No ulike123&reg; SOA option. Nothing new for saving or I should try again..', 'double_opt_contact_form_no_ulike123_soa_failed') . '</p>' . "\r\n";
		}

		if (  update_option( 'double_opt_contact_form_no_plugin_backlink', $_POST['double_opt_contact_form_no_plugin_backlink'] )  )
		{
				$log .=  '<p><strong>' . __('Result: ', 'double_opt_contact_form_result') . '</strong>' . __('I successfully! updated No Plugin Backlink option.', 'double_opt_contact_form_no_plugin_backlink_updated') . '</p>' . "\r\n";
		}else{
				$log .=  '<p><strong>' . __('Result: ', 'double_opt_contact_form_result') . '</strong>' . __('I couldn\'t update No Plugin Backlink option. Nothing new for saving or I should try again..', 'double_opt_contact_form_no_plugin_backlink_failed') . '</p>' . "\r\n";
		}

		if (  update_option( 'double_opt_contact_form_header_html', trim($_POST['double_opt_contact_form_header_html']) )  )
		{
				$log .=  '<p><strong>' . __('Result: ', 'double_opt_contact_form_result') . '</strong>' . __('I successfully! updated Header HTML.', 'double_opt_contact_form_header_html_updated') . '</p>' . "\r\n";
		}else{
				$log .=  '<p><strong>' . __('Result: ', 'double_opt_contact_form_result') . '</strong>' . __('I couldn\'t update Header HTML. Nothing new for saving or I should try again..', 'double_opt_contact_form_header_html_failed') . '</p>' . "\r\n";
		}

	} // This if clause makes it for "Admins Only".. Modify carefully..

	$subj = update_user_meta($user_id, 'double_opt_contact_form_subject', esc_attr(wordwrap($_POST['double_opt_contact_form_subject'], 70, "\r\n", true)));
	$msg = update_user_meta($user_id, 'double_opt_contact_form_message', esc_attr(wordwrap($_POST['double_opt_contact_form_message'], 70, "\r\n", true)));

	if(
		$subj || $msg
	){
			$log .=  '<p><strong>' . __('Result: ', 'double_opt_contact_form_result') . '</strong>' . __('I successfully! updated the email message.', 'double_opt_contact_form_email_message_updated') . '</p>' . "\r\n";
	}else{
			$log .=  '<p><strong>' . __('Result: ', 'double_opt_contact_form_result') . '</strong>' . __('I couldn\'t update the email message.. Nothing new for saving or I should try again..', 'double_opt_contact_form_email_message_failed') . '</p>' . "\r\n";
	}

	global $current_user;
	get_currentuserinfo();
		$current_user_details = $current_user->user_login . ( (empty($current_user->user_firstname) && empty($current_user->user_lastname)) ? '' : ', ' . $current_user->user_firstname . ' ' . $current_user->user_lastname );
	$msg = '<p><strong>' . __('Howdy!?', 'double_opt_contact_form_howdy') . '</strong> ' . $current_user_details . '</p>' . "\r\n";

	$admin_info = get_userdata(1);
		$admin_details = $admin_info->user_login . ( (empty($current_user->user_firstname) && empty($current_user->user_lastname)) ? '' : ', ' . $admin_info->user_firstname . ' ' . $admin_info->user_lastname );

	$web = double_opt_contact_form_whois();
	$msg .= '<p><strong>' . __('Following is your Last Logged Actions: ', 'double_opt_contact_form_following') . '</strong></p>' . "\r\n" ;
	$msg .= '<p><strong>' . __('Last Time Updated: ', 'double_opt_contact_form_last_time_updated') . '</strong>' . gmdate('D, d F Y H:i:s \G\M\T') . '</p>' . "\r\n";
	$log    = $msg . $log;

	$from_new_email = get_option( 'double_opt_contact_form_from_email' );
	$from_new_email = (!empty($from_new_email)) ? $from_new_email : 'postmaster@' . $web['site'] . '.' . $web['.ext'];

	if(
		$_POST['double_opt_contact_form_send'] == 'true' && double_opt_contact_form_is_email ( $from_new_email )
	){
			$log .=  '<p><strong>' . __('Result: ', 'double_opt_contact_form_result') . '</strong>' . __('I tried sending the email message.', 'double_opt_contact_form_mail_sending') . '</p>' . "\r\n";
		$from = 'From: Double Opt Contact Form <' . $from_new_email . '>' . chr(13).chr(10) .
				'Reply-To: ' . $current_user_details . ' <' . $current_user->user_email . '>';
		$subj = stripslashes(esc_attr(wordwrap($_POST['double_opt_contact_form_subject'],70, "\r\n", true)));
		$msg = stripslashes('

Dear ' . $admin_details . ',

User: ' . $current_user_details . ',

Email: ' . $current_user->user_email . '

has sent you the following message: 

.......................

...Subject... : 

' . $subj . '

...Message... : 

' . esc_attr(wordwrap($_POST['double_opt_contact_form_message'], 70, "\r\n", true)) . '

.......................

Kindly, reply to ' . $current_user->user_email . '

or choose to reply to this email message from your email client options/menu.

Reply-To address is already set up by Double Opt Contact Form for your convenience.


Thanks!

Double Opt Contact Form, ' . get_option('blogname') . ' ( http://' . $web['subs'] . '.' . $web['site'] . '.' . $web['.ext'] . '/ ). ' . '

See Also: plugin\'s page on (http://www.ulike123.co/double-opt-contact-form/).

Get Also: FREE ulike123 SOA, Seal of Accreditation, to place on your blog or anywhere you like it from (http://www.ulike123.co/).

This message specifically goes to you as the Blog Admin everytime there is a communication. If you want to stop this emailing,
(1. visit your WordPress Blog, (2. Go to Installed Plugins, and (3. Deactivate Double Opt Contact Form plugin.


');	// Kindly, leave that for a better community free support coherence for all to exchangeably benefit from free services..

	if(
		!double_opt_contact_form_mail_utf8($subj, $msg, $from, 'text/plain') //Advanced: expandable options..
	){
			$log .=  '<p><strong>' . __('Result: ', 'double_opt_contact_form_result') . '</strong>' . __('I couldn\'t send the email message. I should try again..', 'double_opt_contact_form_mail_failed') . '</p>' . "\r\n";
	}else{
			$log .=  '<p><strong>' . __('Result: ', 'double_opt_contact_form_result') . '</strong>' . __('I successfully! sent the email message.', 'double_opt_contact_form_mail_sent') . '</p>' . "\r\n";
	}
	}else{
			$log .=  '<p><strong>' . __('Result: ', 'double_opt_contact_form_result') . '</strong>' . __('I chose not to send the email message or I should wait until this service is available..', 'double_opt_contact_form_mail_no_sending') . '</p>' . "\r\n";
	}

	update_user_meta($user_id, 'double_opt_contact_form_log', $log);
	return true;
}

function double_opt_contact_form_activation() {

	$web = double_opt_contact_form_whois();
      update_option('double_opt_contact_form_from_email','postmaster@' . $web['site'] . '.' . $web['.ext']);
      update_option('double_opt_contact_form_no_wild_os',false);
      update_option('double_opt_contact_form_no_ulike123_soa',true);
      update_option('double_opt_contact_form_no_plugin_backlink',true);
      update_option('double_opt_contact_form_header_html','Double Opt Contact Form');
}

function double_opt_contact_form_deactivation() {

	// *** Safely Delete Plugin's user_meta field(s).. Left manual for safe use..
	// *** Just Uncomment the developers' lines, Activate and Deactivate, 
	// *** and you're done safely removing every user_meta field(s)..

	// TODO:Left for developers and advanced users
	// to add some code that removes every saved:

	// 1. double_opt_contact_form_subject
	// 2. double_opt_contact_form_message
	// 3. double_opt_contact_form_log

	// user_meta field(s)..

      // If your a Blog's Admin (Advanced), kindly, develop this function and post it to "wdrp.biz" using
      // your WDRP Blog Profile's Double Opt Contact Form, so we add your credited-to-you code
      // here and post it to WordPress.org as a Plugin's update that will contain even a backlink to you.

      // We'll test the best code, credited it's writer, and post it..

      // The same is said for any posted translation, too.
      // Just send the files you wish be added to the plugin's zip, 
      // and let's check them..

      delete_option('double_opt_contact_form_from_email');
      delete_option('double_opt_contact_form_no_wild_os');
      delete_option('double_opt_contact_form_no_ulike123_soa');
      delete_option('double_opt_contact_form_no_plugin_backlink');
      delete_option('double_opt_contact_form_header_html');
}

register_activation_hook( __FILE__, 'double_opt_contact_form_activation' );
register_deactivation_hook( __FILE__, 'double_opt_contact_form_deactivation' );

add_action('show_user_profile', 'show_double_opt_contact_form');
add_action('edit_user_profile', 'show_double_opt_contact_form');
add_action('personal_options_update', 'save_double_opt_contact_form');
add_action('edit_user_profile_update', 'save_double_opt_contact_form');

?>