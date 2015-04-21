<?php


$query_string = http_build_query($_REQUEST);

$url = "http://144.76.168.74/shoutburst/services/?$query_string";

// NX DEBUG
$req = print_r($_REQUEST,true);
file_put_contents("/tmp/request.log","REQUEST ($url):\n$req\n\n",FILE_APPEND);


$output = file_get_contents($url);

file_put_contents("/tmp/request.log","RESPONSE :\n$output\n\n",FILE_APPEND);

echo $output;
