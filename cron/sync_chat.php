<?php

// Set the URLs for the source and destination APIs
$source_url = "https://example.com/api/source";
$destination_url = "https://example.com/api/destination";

// Initialize cURL for the source API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $source_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$source_response = curl_exec($ch);
curl_close($ch);

// Initialize cURL for the destination API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $destination_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $source_response);
$destination_response = curl_exec($ch);
curl_close($ch);

// Output the response from the destination API
echo $destination_response;

?>