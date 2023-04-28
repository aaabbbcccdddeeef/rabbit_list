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
if (curl_errno($ch)) {
    echo '[{}]';
    exit;
}
curl_close ($ch);
if($output_data==1)
{
    echo '[{}]';
}
else if($output_data=='此手机号已被使用')
{
    echo '[{"from_id":"'.$phone.'","root_id":"registed:gitee.com","root_label":"registed:gitee.com","type":"registed","imageurl":"/img/icon/registed.png","title":"该号码可能注册 gitee.com,通常意味着号主市IT工作者,并很可能有自己的开源项目","raw_data":"","edge_color":"yellow","edge_label":"注册枚举"}]';
}
?>