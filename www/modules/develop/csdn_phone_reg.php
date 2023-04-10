<?php
$phone=$_GET['phone'];
// get cURL resource
$ch = curl_init();
include('../../config.php');
// set url
curl_setopt($ch, CURLOPT_URL, "https://passport.csdn.net/v1/service/mobiles/$phone?comeFrom=0&code=0086");
// set method
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
// return the transfer as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$headers = array();
$headers[] = 'Host: passport.csdn.net';
$headers[] = 'User-Agent: Mozilla/5.0';
$headers[] = 'Referer: https://passport.csdn.net/forget';
$headers[] = 'Accept-Encoding: identity';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
var_dump($response);
echo '<br>';
echo json_decode($response)['status'];
echo '<br>'; 
$result=getconfig('virustotal_key');
echo $result;
// close curl resource to free up system resources
curl_close($ch);
?>