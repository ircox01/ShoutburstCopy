<?php
$name = "";
$email = "";
$mobile = "";
$interest = "";
$notes = "";
    
if(isset($_POST['email'])) {
	require_once('recaptchalib.php');
	$private_key="6LcVltsSAAAAACaPYDMSvKgmtGXSahHBixIa4MiR";
	$resp = recaptcha_check_answer ($private_key,
       $_SERVER["REMOTE_ADDR"],
       $_POST["recaptcha_challenge_field"],
       $_POST["recaptcha_response_field"]);
     
    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "saviomf@gmail.com";
    $email_subject = "Feedback from CA page";
     
     
    function died($error) {
        echo '<h1>We are very sorry, but there were error(s) found with the form you submitted. </h1>';
        echo $error.'<br /><br />';
    }

    // validation expected data exists
    if(!isset($_POST['name']) ||
        !isset($_POST['email']) ||
        !isset($_POST['mobile']) ||
        !isset($_POST['interest']) ||
        !isset($_POST['notes'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
    }
    else if(!$resp->is_valid){
    	$name = $_POST['name']; // required
    	$email = $_POST['email']; // required
    	$mobile = $_POST['mobile']; // required
    	$interest = $_POST['interest']; // not required
    	$notes = $_POST['notes']; // required
	    died('CAPTCHA is not valid. Please check your solution.');
    }
    else{
     
    $name = $_POST['name']; // required
    $email = $_POST['email']; // required
    $mobile = $_POST['mobile']; // required
    $interest = $_POST['interest']; // not required
    $notes = $_POST['notes']; // required
     
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
  if(!preg_match($email_exp, $email)) {
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  }
    $string_exp = "/^[A-Za-z .'-]+$/";
  if(!preg_match($string_exp, $name)) {
    $error_message .= 'The Name you entered does not appear to be valid.<br />';
  }
  
  
  if(strlen($error_message) > 0) {
    died($error_message);
  }
    $email_message = "Form details below.\n\n";
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
     
    $email_message .= "First Name: ".clean_string($name)."\n";
    $email_message .= "Email: ".clean_string($email)."\n";
    $email_message .= "Telephone: ".clean_string($mobile)."\n";
    $email_message .= "Last Name: ".clean_string($interest)."\n";
    $email_message .= "Comments: ".clean_string($notes)."\n";
     
     
// create email headers
$headers = 'From: '.$email."\r\n".
'Reply-To: '.$email."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers); 
$name = "";
$email = "";
$mobile = "";
$interest = "";
$notes = "";
echo '<h1>Thank you for contacting us. We will be in touch with you very soon.</h1>'; 

}}
?>
