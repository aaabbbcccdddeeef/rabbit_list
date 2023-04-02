<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
$phone=$_GET['phone'];
$url = "https://webapi.jghttp.alicloudecs.com/index/users/login_do";
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url);
$post_data="phone=$phone&password=*******&remember=1";
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$headers = array();
$headers[] = 'Host: webapi.jghttp.alicloudecs.com';
$headers[] = 'Accept-Encoding: deflate';
$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
$headers[] = "\n";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
$output = curl_exec($ch);
curl_close ($ch);
// var_dump($output);
foreach(json_decode($output) as $a => $b)
{
    if($a=='msg')
    {
        if($b=='请输入正确的用户名')
        {
        echo 'false';
        }
        else
        {
        echo 'true';
        }
    exit;
    }
}
?>