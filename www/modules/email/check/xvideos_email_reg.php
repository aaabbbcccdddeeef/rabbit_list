<?php
include '../../../config.php';
// access_by_cookie($config,$_COOKIE);
$email=str_replace('@','%40',$_GET['email']);
$url="https://www.xvideos.com/account/checkemail?email=$email";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1); 
$output_data = curl_exec($ch);
curl_close ($ch);
foreach(json_decode($output_data) as $a => $b)
{
    if($a=='message')
    {
if($b=='This email is already in use or its owner has excluded it from our website.')
{
echo 'true';
}        
    }
}
?>