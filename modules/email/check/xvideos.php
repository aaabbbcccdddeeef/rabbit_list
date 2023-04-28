<?php
include '../../../config.php';
// access_by_cookie($config,$_COOKIE);
$email=str_replace('@','%40',$_GET['email']);
$url="https://www.xvideos.com/account/checkemail?email=$email";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1); 
$output_data = curl_exec($ch);
curl_close ($ch);
foreach(json_decode($output_data) as $a => $b)
{
    if($a=='message')
    {
if($b=='This email is already in use or its owner has excluded it from our website.')
{
    $site="xvideos.com";
    $email1=$_GET['email'];
    echo '[{"from_id":"'.$email1.'","root_id":"registed:'.$site.'","root_label":"registed:'.$site.'","type":"registed","imageurl":"/img/icon/registed.png","title":"该邮箱可能注册 '.$site.',通常意味着邮箱主人注册了色情网站","raw_data":"","edge_color":"orange","edge_label":"注册枚举"}]';
exit;
}        
    }
}
echo '[{}]';
?>