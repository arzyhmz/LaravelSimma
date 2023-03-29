<?php
// this script will send every new contact to create in qontact
// $host = '127.0.0.1:8000';
$host = 'http://simma.blindpen.my.id';
$source_url = $host."/api/post-contact-to-qontact/";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $source_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$source_response = curl_exec($ch);
print_r($source_response );
curl_close($ch);
?>