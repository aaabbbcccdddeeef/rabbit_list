<?php

// get cURL resource
$ch = curl_init();

// set url
curl_setopt($ch, CURLOPT_URL, "https://api.threatbook.cn/v3/ip/adv_query?apikey=请替换apikey&resource=159.203.93.255");
// set method
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
// return the transfer as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// send the request and save response to $response
$response = curl_exec($ch);
if ($response !== false) {
    echo 'HTTP Status Code: ' . curl_getinfo($ch, CURLINFO_HTTP_CODE) . PHP_EOL;
    echo 'Response Body: ' . $response . PHP_EOL;
} else {
    echo 'Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch) . PHP_EOL;
}

// close curl resource to free up system resources
curl_close($ch);
?>