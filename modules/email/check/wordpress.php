<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$email=$_GET['email'];
$url="https://public-api.wordpress.com/rest/v1.1/users/$email/auth-options";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$output_data = curl_exec($ch);
curl_close ($ch);
// echo $output_data;
foreach(json_decode($output_data) as $a => $b)
{
    if($a=='message')
{
    if($b=='User does not exist.')
    {
        echo '[{}]';
    }
    else 
    {
        $site="wordpress.com";
        echo '[{"from_id":"'.$email.'","root_id":"registed:'.$site.'","root_label":"registed:'.$site.'","type":"registed","imageurl":"/img/icon/registed.png","title":"该邮箱可能注册 '.$site.',通常意味着邮箱主人是站长或者开发者，黑客","raw_data":"","edge_color":"orange","edge_label":"注册枚举"}]';
    }
}

}