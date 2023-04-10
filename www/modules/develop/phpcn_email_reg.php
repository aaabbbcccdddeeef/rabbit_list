<?php
include '../../../config.php';
// access_by_cookie($config,$_COOKIE);
$email=str_replace('@','%40',$_GET['email']);
$ch = curl_init();
$url="https://www.php.cnc/account/emaillogin.html";
$post="email=$email&pass=1234AA&repass=1234AA&code=1234";
// phone
$header=array();
$header[]='Host: www.php.cnc';
$header[]='Cookie: cookie is not exist';
$header[]='Accept-Encoding: identity';
$header[]='Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
$header[]="X-Requested-With: XMLHttpRequest";
curl_setopt($ch, CURLOPT_URL, $url);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
// curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
$output=curl_exec($ch);
curl_close($ch);
var_dump($output);
exit;
// $check='{"code":0,"msg":"\u8be5\u5e10\u53f7\u4e0d\u5b58\u5728\uff0c\u8bf7\u4f7f\u7528\u5176\u4ed6\u65b9\u5f0f\u767b\u5f55"}';
foreach(json_decode($output) as $a => $b)
{
if($a=='code')
{
if($b==0)
{
    echo 'false';
}
else if($b==1)
{
    echo 'true';
}
break;
}
}
?>