<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$phone=$_GET['phone'];
$url="https://gitee.com/check";
$data="do=phone&val=$phone&entrance=register";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$output_data = curl_exec($ch);
curl_close ($ch);
if($output_data==1)
{
    echo 'false';
}
else if($output_data=='此手机号已被使用')
{
    echo 'true';
}
?>