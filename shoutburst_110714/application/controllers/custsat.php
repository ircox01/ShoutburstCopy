<?php

require_once("./config.php");
require_once("./admin/_inc/backgroundprocess.class.php");
require_once("./admin/_inc/functions.php");
ini_set('display_error', 0);
$dbcon = mysql_connect($SQL_HOST, $SQL_USER, $SQL_PASSWORD);
mysql_select_db($SQL_DATABASE, $dbcon);

$port = '443';

ob_start();

switch ($_REQUEST['action']) {
    case 'new':
        $r = mysql_query("select id from tbl_logins where pin='".addslashes($_REQUEST['pin'])."'");
        $row = mysql_fetch_assoc($r);
        if($row['id']){
            $_REQUEST['Timestamp'] = date("Y/m/d H:i:s");
            $query = sprintf("
                insert into csv_data
                    (dialed_number, dialed_date, cli, var4, var5, processed)
                values
                    ('%s', '%s', '%s', '%s', '%s', 0)",
            addslashes($_REQUEST['servicenumber']),
            addslashes($_REQUEST['Timestamp']),
            addslashes($_REQUEST['cli']),
            addslashes($_REQUEST['plan']),
            addslashes($_REQUEST['pin']));
            $r = mysql_query($query);
            $callid = mysql_insert_id();
        }
        else {
            $callid = 0;
        }
        $output = "<container>\n<callid>$callid</callid>\n</container>\n";
        break;

    case 'question':
        $question_number = $_REQUEST['q'];
        $callid = addslashes($_REQUEST['callid']);

        $r = mysql_query($query);
        $query = "select q1,q2,q3,q4,q5,q6,q7,q8,q9,q10 from csv_data where id=" . addslashes($_REQUEST['callid']);
        $r = mysql_query($query);
        $row = mysql_fetch_row($r);
        $row[$question_number - 1] = $_REQUEST['answer'];
        $questions_answered = 0;
        $total_score = 0;
        $average_score = 0;
        for ($i = 0; $i < $question_number; $i++) {
            $questions_answered++;
            $total_score += $row[$i];
            $average_score = $total_score / $questions_answered;
        }
        $qu = 'q' . addslashes($question_number) . '=' . addslashes($_REQUEST['answer']);
        $query = "update csv_data set $qu, var1=$questions_answered, var2=$total_score, var3=$average_score where id=" . addslashes($_REQUEST['callid']);
        $r = mysql_query($query);

        $output = "<container>\n<ok>1</ok>\n</container>\n";
        break;

    case 'record':

        $callid = addslashes($_REQUEST['callid']);

        $downloader_script = 'rec_downloader.php';

        $server = $_SERVER['HTTP_HOST'];
        $uri = $_SERVER['SCRIPT_NAME'];
        $uri = preg_replace("/\/[\w\d]*?\.php/siU", "/".$downloader_script, $uri);

        $filename = $_SERVER['SCRIPT_FILENAME'];
        $filename = preg_replace("/\/[\w\d]*?\.php/siU", "/".$downloader_script, $filename);

        $php_exec = exec("which php");
        if (!$php_exec) {
            $php_exec = "/usr/local/bin/php";
        }

        exec("{$php_exec} {$filename} {$callid} > /dev/null 2>&1 &");

        $output = "<container>\n<ok>record</ok>\n</container>\n";
        break;

    default:
        $output = "<container>\n<ok>1</ok>\n</container>\n";
        break;
}

ob_end_clean();
echo $output;
exit;
?>