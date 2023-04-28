<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$email=$_GET['email'];
$url="https://api.accounts.firefox.com/v1/account/status";
$data=array(
    'email' => $email
);
$payload=json_encode($data);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Host: api.accounts.firefox.com',
    'Content-Type: application/json; charset=utf-8',
    'Content-Length: '.strlen($payload)
));
// curl_setopt($ch, CURLOPT_HEADER,1);
$output_data = curl_exec($ch);
curl_close($ch);
// var_dump($output_data);
foreach(json_decode($output_data) as $a => $b)
{
if($a=='exists')
{
if($b)
{
    $site="firefox.com";
    echo '[{"from_id":"'.$email.'","root_id":"registed:'.$site.'","root_label":"registed:'.$site.'","type":"registed","imageurl":"/img/icon/registed.png","title":"该邮箱可能注册 '.$site.',通常意味着邮箱主人使用火狐浏览器或者是一名开发者","raw_data":"","edge_color":"orange","edge_label":"注册枚举"}]';
}
else
{
    echo '[{}]';
}
}
}
// echo 'false';
?>