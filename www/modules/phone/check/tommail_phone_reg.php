<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$phone=$_GET['phone'];
$url = "https://vip.tom.com/webmail/vipRegister/checkPhoneNumAndLimit.action";
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url);
$post_data="mobile=$phone&domain=%40vip.tom.com&userName=hmvbjhknjk%40vip.tom.com";
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$headers = array();
$headers[] = 'Host: vip.tom.com';
$headers[] = 'Accept-Encoding: deflate';
$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
$headers[] = "X-Requested-With: XMLHttpRequest";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
$output = curl_exec($ch);
curl_close ($ch);
// var_dump($output);
foreach(json_decode($output) as $a => $b)
{
    if($a=='isUserMobileExist')
    {
        if($b)
        {
        echo 'true';
        }
        else
        {
        echo 'false';
        }
    exit;
    }
}
?>