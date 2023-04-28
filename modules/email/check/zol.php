<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
$email=$_GET['email'];
$url="https://my.zol.com.cn/index.php?c=Ajax_User&a=CheckEmail";
$header=array(
'Host: my.zol.com.cn',
'Cookie: Adshow=5; ip_ck=%3D; lv=1; vn=1; questionnaire_pv=1; z_pro_city=fuckyou; z_day=fuckyou',
''
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'email='.$email);
 $output = curl_exec($ch);
if (curl_errno($ch)) {
    echo '[{}]';
exit;
}
curl_close ($ch);
if($output=='[]')
{
    echo '[{}]';
}
else if($output=='{"info":"ok"}')
{
    echo '[{"from_id":"'.$email.'","root_id":"regsited:zol.com.cn","root_label":"regsited:zol.com.cn","type":"regsited","imageurl":"/img/icon/registed.png","title":"注册了 zol.com.cn","raw_data":"","edge_color":"orange","edge_label":"注册枚举"}]';
}