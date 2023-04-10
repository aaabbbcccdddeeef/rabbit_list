<?php
include '../../../config.php';
// access_by_cookie($config,$_COOKIE);
$email=str_replace('@','%40',$_GET['email']);
// $post="email=$email&name=$email&passwd=$email&repasswd=$email&code=0";
$post="email=$email";
// $url="https://fastlink.ws/auth/register";
$url="https://fastlink.ws/password/reset";
$header=array(
    'Host: fastlink.ws',
    'Accept-Encoding: identity',
    'Content-Type: application/x-www-form-urlencoded',
    'X-Requested-With: XMLHttpRequest',
    'Origin: https://fastlink.ws',
    ''
);
$ch=curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
$output_data=curl_exec($ch);
curl_close ($ch);
if(preg_match('/(\"ret\":1)/',$output_data,$nothing))
{
    echo 'true';
    return ;
}
if($output_data=='{"ret":0,"msg":"\u6b64\u90ae\u7bb1\u4e0d\u5b58\u5728."}')
{
    echo 'false';
    // echo $output_data;
}
?>