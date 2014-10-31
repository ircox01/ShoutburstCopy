<?php

exit;
ini_set('display_error', '1');

$dirname = dirname(__FILE__);
$script_folder = $dirname . DIRECTORY_SEPARATOR;
//$script_folder = "/home/custsat/domains/custsat.automatedtelecoms.com/public_html/";

$log_file = $script_folder."rec_log.log";
$log_list = fopen($log_file, "a+");

if ($_SERVER['argc'] < 2) {
    fwrite($log_list, date("r")." : Wrong launch\n");
    fclose($log_list);
    exit;
}

if (isset($_SERVER['argv'][2]) and ($_SERVER['argv'][2] == 'wait'))
{
    // wait 1 minute before downloading
    sleep(60);
}

require_once($script_folder.'admin/_inc/config.php');
require_once($script_folder.'CallManagerRecordScraper.php');

$dbcon = mysql_connect($SQL_HOST, $SQL_USER, $SQL_PASSWORD);
mysql_select_db($SQL_DATABASE, $dbcon);

$callid = $_SERVER['argv'][1];
fwrite($log_list, date("r")." : New downloading. CallID : {$callid}\n");

$query = "select dialed_date, cli, var4 as plan from csv_data where id='{$callid}'";
$db->query($query);
$row = db_fetch_rec();
$search_cli = !empty($row['cli']) ? $row['cli'] : FALSE;
$search_date = $row['dialed_date'];
$search_plan = $row['plan'];

$db->query("SELECT tbl_members_cmup.user as user, tbl_members_cmup.pass as pass
            FROM tbl_members_cmup
            JOIN tbl_members_plans on tbl_members_plans.member_id=tbl_members_cmup.m_id
            WHERE tbl_members_plans.plan_name='{$search_plan}'");
if ($db->num_rows() < 1) {
    $login = 'ptEnhanced';
    $password = 'ptadmin#';
}
else {
    $cm = db_fetch_rec();
    $login = $cm['user'];
    $password = $cm['pass'];
}

//$search_cli = FALSE;
//$search_date = '08.02.2011 17:08';
//$search_plan = 'ICI_CS_TA';

fwrite($log_list, date("r"). " : Call ID {$callid}: donwloading\n");
$myScraper = new CallManagerRecordScraper($search_cli, $search_date, $search_plan, $waytowav, '', $login, $password);

//$web_page = $myScraper->log_in();

if (isset($web_page['error'])) {
    fwrite($log_list, date("r")." : Call ID {$callid} error: ".$web_page['error']."\n");
    echo "Error: ".$web_page['error']."<br />";
}

$tries = 3;
$try = 1;
$error = TRUE;

while ($error and ($try <= $tries)) {
    $try++;
    try {
        $data = $myScraper->search();
    }
    catch (CallManagerRecordScraperException $e) {
        $error = $e;
        continue;
    }

    if (isset($data['error'])) {
        $error = $data['error'];
    }
    else {
        $error = FALSE;
    }
}
if ($error) {
    fwrite($log_list, date("r")." : Call ID {$callid} error: {$error}. Login: {$login}, CLI: {$cli}\n");
    fclose($log_list);
    echo $error;
    exit;
}


$query = "select member_id from tbl_members_plans where plan_name='" . mysql_real_escape_string($search_plan) . "'";
$db->query($query);
$row = db_fetch_rec();

$custid = mysql_real_escape_string($row['member_id']);
$plan = mysql_real_escape_string($search_plan);
$record_name = mysql_real_escape_string($data['Filename']);
if (isset($data['Duration'])) {
    $record_duration = mysql_real_escape_string($data['Duration']);
}
else {
    $record_duration = 0;
}
$cli = mysql_real_escape_string($search_cli);

fwrite($log_list, date("r")." : Call ID {$callid}: saving to DB\n");
$query = "insert into recordings (id, custid, plan, name, cli) values ('{$callid}', '{$custid}', '{$plan}', '{$record_name}', '{$cli}')";
$db->query($query);
$query = "update csv_data SET var10 = '{$record_name}.wav', var9='{$record_duration}', processed=1 WHERE id = '{$callid}'";
$db->query($query);

fwrite($log_list, date("r")." : Call ID {$callid}: exiting\n");
fclose($log_list);

exit;
