<?php

	// SurveyMonkey returns &amp; joined QUERY_STRING
	$query_string = str_replace('&amp;','&',$_SERVER['QUERY_STRING']);
	header('Location: http://'.$_SERVER['HTTP_HOST'].'/media/sm_auth_callback/?'.$query_string);

?>