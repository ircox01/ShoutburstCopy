<?php
$data = file_get_contents('/var/www/apps.enrichtelecom.co.uk/testing/log.txt');
$file_data = json_decode($data, true);
if($data == false){ /* if file doesn't exists yet, create it with initial data */
	$initial_data['surveys_total_count'] = 0;
	$initial_data['latest_question_score'] = '';
	$initial_data['detractors_number'] = 0;
	$initial_data['neutrals_number'] = 0;
	$initial_data['promoters_number'] = 0;
	$initial_data['nps_score'] = 0;
	file_put_contents('/var/www/apps.enrichtelecom.co.uk/testing/log.txt', json_encode($initial_data));
	$file_data = $initial_data;
}
if ( isset($_GET['q']) && isset($_GET['answer']) ) {
	$score = (int)$_GET['answer'];
	//$score =   rand ( 1 , 10 );
	$file_data['latest_question_score'] = $score;
	$file_data['surveys_total_count']++;
		if($score == 0 || $score == 1) {
			$file_data['detractors_number']++;
		} elseif($score == 9 || $score == 10) {
			$file_data['promoters_number']++;
		} else{
			$file_data['neutrals_number']++;
		}
		/* calculate nps score */
		$npm_score = ( (float) ( ( $file_data['promoters_number'] - $file_data['detractors_number'] ) / ( $file_data['surveys_total_count'] ) ) ) * 100;
		$file_data['nps_score'] =  round($npm_score, 2);
	 /* update file with new data */
	file_put_contents('/var/www/apps.enrichtelecom.co.uk/testing/log.txt', ""); // clear file content
	file_put_contents('/var/www/apps.enrichtelecom.co.uk/testing/log.txt', json_encode($file_data));
}