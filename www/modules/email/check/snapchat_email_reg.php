<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$email=$_GET['email'];
 $url="https://bitmoji.api.snapchat.com/api/user/find";
// $url="https://enevijs9metm.x.pipedream.net/";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$post="{\"email\":\"$email\"}";
$header=array();
$header[]="Content-Type: text/plain";
curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
$output_data = curl_exec($ch);
curl_close ($ch);
// echo $output_data;
if($output_data=='{"account_type":"snapchat"}')
{
    echo 'true';
}
else 
{
    echo 'false';
}
?>