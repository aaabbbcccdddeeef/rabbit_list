<?php
include '../../../config.php';
// access_by_cookie($config,$_COOKIE);
$email=str_replace('@','%40',$_GET['email']);
$url="https://www.bitcoinwhoswho.com/login";
$header=array(
    'Host: www.bitcoinwhoswho.com',
    'Accept-Encoding: indentity',
    'Content-Type: application/x-www-form-urlencoded',
    ''    
);
$data="email=$email&password=esvfd23rbasvdfkvn&submit=Login";
$ch=curl_init();
// echo "start: \n";
 curl_setopt($ch, CURLOPT_URL, $url);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
 curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
 // curl_setopt($ch, CURLOPT_HEADER,1);
 curl_setopt($ch, CURLOPT_POST, 1);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
 curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0);
 $output_data=curl_exec($ch);
// echo "end: \n";
if(curl_error($ch))
{
    echo '[{}]';
    exit;
}
curl_close($ch);
if(preg_match('/(No account exists with this email.)/',$output_data,$str))
{
    echo '[{}]';
    exit;
}
else if(preg_match('/(Incorrect password.)/',$output_data,$str))
{
    $email1=$_GET['email'];
    echo '[{"from_id":"'.$email1.'","root_id":"registed:bitcoinwhoswho.com","root_label":"registed:bitcoinwhoswho.com","type":"registed","imageurl":"/img/icon/regsited.png","title":"注册了这个网站，可能是开源情报工作者，调查人员，或者币圈","raw_data":"","edge_color":"yellow","edge_label":"注册枚举"}]';
    exit;
}
?>