<?php
ob_start();
var_dump($_POST);
$str = ob_get_clean();
//file_put_contents('/var/www/apps.enrichtelecom.co.uk/testing/log.txt', $str);?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Call score</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" type="text/css" media="all" href="css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" media="all" href="css/style.css" />
		<META HTTP-EQUIV="refresh" CONTENT="15">
	</head>
	<body>
		<header><?php
			$initial_data['surveys_total_count'] = 0;
			$initial_data['latest_question_score'] = '';
			$initial_data['detractors_number'] = 0;
			$initial_data['neutrals_number'] = 0;
			$initial_data['promoters_number'] = 0;
			$initial_data['nps_score'] = 0;
			file_put_contents('/var/www/apps.enrichtelecom.co.uk/testing/log.txt', json_encode($initial_data));

			if ( 1 || isset($_GET['q']) && isset($_GET['answer']) ) {
				$call_table_data = file_get_contents('/var/www/apps.enrichtelecom.co.uk/testing/log.txt');
					var_dump($call_table_data);
					//$score = (int)$_GET['answer'];
					$detractors_increment ='`detractors_number`';
					$neutrals_increment ='`neutrals_number`';
					$promoters_increment = '`promoters_number`';
					$detractors_number = $call_table_data['detractors_number'];
					$neutrals_number = $call_table_data['neutrals_number'];
					$promoters_number = $call_table_data['promoters_number'];
					$score =   rand ( 1 , 10 );
					//echo 'score' . $score;
					if($score == 0 || $score == 1) {
						$detractors_increment = '`detractors_number` + 1';
						$detractors_number++;;
					} elseif($score == 9 || $score == 10) {
						$promoters_increment = '`promoters_number` + 1';
						$promoters_number++;
					} else{
						$neutrals_increment = '`neutrals_number` + 1';
						$neutrals_number++;
					}
					/* calculate nps score */
					$nps_score =  round((float)(( 0 - $detractors_number) / ($call_table_data['surveys_total_count'] + 1)), 2);
 				 /* update file with new data */

			} else{ /* there is no $_POST data, so select data from database */
				$call_table_data = file_get_contents('/var/www/apps.enrichtelecom.co.uk/testing/log.txt');
				echo 'in else'; var_dump($call_table_data);
			}
			if(1) { ?>

		</header>
		<section id="calls_information_box" >
			<table id="calls_information_table" class="col-md-3 table-hover table-striped table-condensed">
				<tbody>
					<tr>
						<td>Number of surveys</td>
						<td><?php echo $call_table_data['surveys_total_count']; ?></td>
					</tr>
					<tr>
						<td>Latest Question Score</td>
						<td><?php echo $call_table_data['latest_question_score'];?></td>
					</tr>
					<tr>
						<td>Number of detractors</td>
						<td><?php echo $call_table_data['detractors_number'];?></td>
					</tr>
					<tr>
						<td>Number of neutrals</td>
						<td><?php echo $call_table_data['neutrals_number'];?></td>
					</tr>
					<tr>
						<td>Number of promoters</td>
						<td><?php echo $call_table_data['promoters_number'];?></td>
					</tr>
					<tr>
						<td>NPS Score</td>
						<td><?php echo $call_table_data['nps_score']  . '%';?></td>
					</tr>
				</tbody>
			</table>
		</section>
	</body>
</html> <?php } return 'answerstr'; ?>