<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$email=$_GET['email'];
$url="https://gitee.com/check";
$data="do=user_email&val=$email&entrance=register";
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
else if($output_data=='邮箱已经注册')
{
    $email1=$_GET['email'];
    echo '[{"from_id":"'.$email1.'","root_id":"registed:gitee.com","root_label":"registed:gitee.com","type":"registed","imageurl":"/img/icon/registed.png","title":"该邮箱可能注册 gitee.com,通常意味着号主市IT工作者,并很可能有自己的开源项目","raw_data":"","edge_color":"orange","edge_label":"注册枚举"}]';
}
else 
{
    echo '[{}]';
}
?>