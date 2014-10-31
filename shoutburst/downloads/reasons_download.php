<?php

require('db_mysql.php');

$db = new db_mysql();
$db->Database = 'shoutburst';
$db->Host = '127.0.0.1';
$db->User = 'alex';
$db->Password = 'Al3XsH00uTb##42';

if ($_POST['submit'] && $_POST['comp_id']) {

$db->query(sprintf("select r.date_time,u.full_name,r.reason from notransfer_reasons r inner join user_companies uc on uc.user_id=r.user_id inner join users u on u.user_id=r.user_id where uc.comp_id='%d' order by date_time", (int)$_POST['comp_id']));

$f = fopen("php://output","w");
ob_end_clean();
header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=\"notransfer.csv\"");
while($db->next_record()) {
    fputcsv($f, array($db->Record[0],$db->Record[1],$db->Record[2]));
}
exit();
    
} else {

$db->query("select comp_id,comp_name from companies order by comp_name");
$companies = array();
while($db->next_record()) {
    $companies[] = $db->Record;
}

}

?>

<html>
<head>
<title>Notransfer reasons</title>
</head>
<body>

<form method="post">
Company:
<select name="comp_id">
<?php
    foreach($companies as $company) {
	echo sprintf("<option value='%d'%s>%s</option>", $company['comp_id'], ($company['comp_id'] == $_POST['comp_id']?' selected':''), htmlspecialchars($company['comp_name']));
    }
?>    
</select>
<input type="submit" value="Download" name="submit">
</form>


</body>
</html>
