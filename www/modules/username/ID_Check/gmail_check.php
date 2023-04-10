<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
$email=$_GET['username'].'@gmail.com';
function check_gmail($email)
{
$url="https://mail.google.com/mail/gxlu?email=$email";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0);
curl_setopt($ch, CURLOPT_HEADER,1);
$output_data = curl_exec($ch);
preg_match('/Set-Cookie:(.*);/iU',$output_data,$str); //这里采用正则匹配来获取cookie并且保存它到变量$str里，这就是为什么上面可以发送cookie变量的原因
$cookie = $str[1]; 
curl_close ($ch);
return $str;
}
if(!empty(check_gmail($email)))
{
    echo $email;
}
?>