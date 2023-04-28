<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$email=$_GET['email'];
$url="https://lastpass.com/create_account.php";
$post=array(
    'check' => 'avail',
    'skipcontent' => '1',
    'mistype' => '1',
    'username' => $email
);
$header=array(
    'Accept: */*',
    'Accept-Language: en,en-US;q=0.5',
    'Referer: https://lastpass.com/',
    'X-Requested-With: XMLHttpRequest',
    'DNT: 1',
    'Connection: keep-alive',
    'TE: Trailers'
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
$output_data=curl_exec($ch);
curl_close($ch);
if($output_data=='no')
{
    $site="lastpass.com";
    echo '[{"from_id":"'.$email.'","root_id":"registed:'.$site.'","root_label":"registed:'.$site.'","type":"registed","imageurl":"/img/icon/registed.png","title":"该邮箱可能注册 '.$site.',通常意味着邮箱主人使用这个工具保存密码","raw_data":"","edge_color":"orange","edge_label":"注册枚举"}]';
}
else 
{
    echo '[{}]';
}
?>