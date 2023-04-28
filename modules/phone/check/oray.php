<?php
include '../../../config.php';
// access_by_cookie($config,$_COOKIE);
# 输入变量
$phone=$_GET['phone'];
$header=array(
    'Host: user-api-passport.oray.com',
    'Accept: application/json, text/plain, */*',
    'Accept-Encoding: gzip, deflate',
    'Content-Type: application/json',
    ''
    );
$data='{"target":"'.$phone.'","mode":0,"send_voice_confirm":1}';
$url="https://user-api-passport.oray.com/passport/send?_t=";
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER,1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
$output = curl_exec($ch);
if(curl_error($ch))
{
    echo '[{}]';
    exit;
}
// echo $output;
$code=curl_getinfo($ch,CURLINFO_HTTP_CODE);
if($code=='500')
{
    echo '[{"from_id":"'.$phone.'","root_id":"registed:oray.com","root_label":"registed:oray.com","type":"registed","imageurl":"/img/icon/registed.png","title":"该手机注册了 oray.com 通常是个大冤种，才会买这种内网穿透","raw_data":"","edge_color":"orange","edge_label":"注册枚举"}]';
}
else 
{
    echo '[{}]';
}
curl_close ($ch);
?>