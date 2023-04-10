<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
$phone=$_GET['phone'];
$url="https://tronclass.com.cn/api/login";
$ch = curl_init(); 
$post_data =array(
    'user_name' => "$phone",
    'password' => "123456"
);

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
$headers = array();
// $headers[] = 'Host: tronclass.com.cn';
// $headers[] = 'Accept-Encoding: gzip, deflate';
$headers[] = 'Content-Type: application/json;charset=utf-8';
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);  
$output = curl_exec($ch);
curl_close ($ch);
var_dump($output);
exit;
foreach(json_encode($output) as $a => $b)
{
    if($a=='code')
    {
        if($b=='_USER_NOT_EXIST_')
        {
        echo 'false';    
        }
        else 
        {
        echo 'ture';    
        }
    }
}




?>