<?php
include '../../../config.php';
// access_by_cookie($config,$_COOKIE);
$username=$_GET['username'];
$email=$username.'@protonmail.ch';
$url="https://api.protonmail.ch/pks/lookup?op=index&search=$email";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$output_data = curl_exec($ch);
if (curl_error($ch)) {
    echo '[{}]';
    exit;
}
curl_close ($ch);
preg_match_all('/uid:(.*@protonmail.ch )/',$output_data,$result);
$email=str_replace(' ','',$result[1][0]);
preg_match_all('/::([0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9])::/',$output_data,$result);
if(!empty($result[1][0]))
{
    $title=$result[1][0];
}
if(strlen($email)>3)
{
echo '[{"from_id":"'.$username.'","root_id":"'.$email.'","root_label":"'.$email.'","type":"email","imageurl":"/img/icon/email.png","title":"注册时间:'.$title.'","edge_color":"blue","edge_label":"用户名枚举邮箱"}]'; 
}
else 
{
    echo '[{}]';
}
?>