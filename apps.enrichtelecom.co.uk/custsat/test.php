<?php

$query_string = http_build_query($_REQUEST);

$url = "http://144.76.168.74/shoutburst/services/$query_string";

$output = file_get_contents($url);

echo $output;
?>
