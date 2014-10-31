<?php

$script_location = dirname(__FILE__);
require_once($script_location . DIRECTORY_SEPARATOR . 'CallManagerRecordScraper.php');

$cli = '';
$plan_name = '';
$waytowav = 'storeaudio';
$dbUser = 'root';
//$dbPassword ='';
$dbPassword = 'IanCox2008';
$dbName = 'voicesolution';
$host = 'localhost';
//get all users from each company then curl per account
//:connect to database		
$link = mysql_connect($host, $dbUser, $dbPassword);
if (!$link) {
	die('Not connected : ' . mysql_error());
}

// make voicesolution the current db
$db_selected = mysql_select_db($dbName, $link);
if (!$db_selected) {
	die ("Can\'t use $dbName : " . mysql_error());
}

//get all users now that is not admin
$query = "SELECT *from users WHERE is_admin = 0 and status = 1";
$result = mysql_query($query);
if (!$result) {
	die('Invalid query: ' . mysql_error());
}

//loop each call login record
while ($row = mysql_fetch_assoc($result)) {	
		
	$callManagerFile = new CallManagerRecordScraper(
        $cli,
        '',
        $plan_name,
        $waytowav,
        'https://www.callmanager.virginmediabusiness.co.uk/effectiveL/',
		$row['username'],
		$row['call_login_pw']
		
	);

	$loggedin = $callManagerFile->log_in();

	if (!$loggedin) {
	  return "You are not logged in";
	}
	
	$status = $callManagerFile->search($dbUser, $dbPassword, $dbName, $host, $row['company_id']);
	echo "okay";exit;
}







