<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$email=$_GET['email'];
$url="https://yun.ikuai8.com/api/v3/register";
$header=array(
'Host: yun.ikuai8.com',
'Accept-Encoding: identity',
'Content-Type: application/json;charset=utf-8',
''
);
$data='{"mobile":"","password":"admin@qq.com","password_confirmation":"admin@qq.com","email":"'.$email.'","qq":"10000","sms_code":""}';
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
// curl_setopt($ch, CURLOPT_HEADER,1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
$output = curl_exec($ch);
if(curl_error($output))
{
    echo '[{}]';
    exit;
}
curl_close ($ch);
if($output=='{"errors":{"email":["\u6b64\u90ae\u7bb1\u5df2\u6ce8\u518c\uff01"]}}')
{
echo '[{"from_id":"'.$email.'","root_id":"registed:yun.ikuai8.com","root_label":"registed:yun.ikuai8.com","type":"registed","imageurl":"/img/icon/registed.png","title":"路由厂商，通常意味着此人电子发烧友或者网工","raw_data":"","edge_color":"orange","edge_label":"注册枚举"}]';
}
else 
{
    echo '[{}]';
    
}
?>