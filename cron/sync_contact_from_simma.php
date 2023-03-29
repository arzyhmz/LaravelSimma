<?php
// this script will hit url to get detail every contact from simma that listed in the change list and save to database
// $host = '127.0.0.1:8000';
$host = 'http://simma.blindpen.my.id';
$source_url = $host."/api/detail-simma/";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $source_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$source_response = curl_exec($ch);
print_r($source_response );
curl_close($ch);
?>