<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$email=str_replace('@','%40',$_GET['email']);
$url="https://cn.pornhub.com/signup";
$header=array(
    'User-Agent: Mozilla/5.0 (X11; CrOS x86_64 14794.0.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5045.0 Safari/537.36'
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_HEADER,1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0); 
$output_data = curl_exec($ch);
curl_close ($ch);
preg_match('/Set-Cookie: ss=(.*);/iU',$output_data,$str);
$ss=$str[1];
preg_match('/token.*"(.*)";/iU',$output_data,$str);
$token=$str[1];
function check($email,$ss,$token)
{
    $url="https://cn.pornhub.com/user/create_account_check?token=$token";
    $header=array(
        "Host: cn.pornhub.com",
        "Cookie: ss=$ss",
        'User-Agent: 233',
        'X-Requested-With: XMLHttpRequest',
        'Content-Type: application/x-www-form-urlencoded; charset=UTF-8'
    );
    $post="&check_what=email&email=$email";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    $output_data=curl_exec($ch);
    curl_close($ch);
    // echo $ss;
    // echo "\n";
    // echo $token;
    // echo "\n";
    // echo $output_data;
    foreach(json_decode($output_data) as $a => $b)
    {
        if($a=='email')
        {
            if($b=='create_account_failed')
            {
                $site="pronhub.com";
                $email1=$_GET['email'];
                echo '[{"from_id":"'.$email1.'","root_id":"registed:'.$site.'","root_label":"registed:'.$site.'","type":"registed","imageurl":"/img/icon/registed.png","title":"该邮箱可能注册 '.$site.',通常意味着邮箱主人使用此邮箱浏览色情网站","raw_data":"","edge_color":"orange","edge_label":"注册枚举"}]';
            exit;    
            }
        }
    }
    echo '[{}]';
}
check($email,$ss,$token);
?>