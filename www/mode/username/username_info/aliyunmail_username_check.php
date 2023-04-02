<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
$username=$_GET['username'];
$post_data="country=CN&bizEntrance=pc&bizName=aliyun_mail&lang=zh_CN&device=PC&ncoSig=&ncoSessionid=&ncoToken=&mobile=&mobileArea=CN&ua=&phoneCountry=&phoneArea=&phoneNumber=&email=$username&password=&rePassword=&baxia%5Bvalue%5D=unshow&mobileCode=&checkbox=false&bx-ua=1&bx-umidtoken=1";
$header=array();
$header[]='Host: reg.taobao.com';
$header[]='Accept-Encoding: deflate';
$header[]='X-Requested-With: XMLHttpRequest';
$header[]='Content-Type: application/x-www-form-urlencoded';
$url="https://reg.taobao.com/member/reg/fast/unify_process.do?flowId=emailCheck&regSidToken=1&_bx-v=1";
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
$output = curl_exec($ch);
curl_close ($ch);
foreach(json_decode($output) as $a => $b)
{
    if($a=='info')
    {
        if($b=='该邮箱地址已被占用')
        {
        echo "$username@aliyun.com";            
        }
    }
} 
?>