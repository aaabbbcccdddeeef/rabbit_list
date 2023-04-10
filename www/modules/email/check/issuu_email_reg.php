<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$email=str_replace('@','%40',$_GET['email']);
$url="https://issuu.com/call/signup/v2/check-email/$email?_=1";
$header=array(
    'User-Agent: 233',
    'Host: issuu.com',
    'Accept: */*',
    'Accept-Encoding: deflate'
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0); 
$output_data = curl_exec($ch);
curl_close ($ch);
foreach(json_decode($output_data) as $a => $b)
{
    if($a=='status')
    {
if($b=='available')
{
echo 'true';
return ;
}        
    }
}
echo 'false';
?>