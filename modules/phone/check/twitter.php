<?php
include '../../../config.php';
// access_by_cookie($config,$_COOKIE);
$phone=$_GET['phone'];
function getmainjs()
{
    $header=array(
        'Host: twitter.com'
    );
    $url="https://twitter.com/i/flow/signup";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0);
    $output_data=curl_exec($ch);
    if(curl_error($ch))
{
    echo '[{}]';
    exit;
}
    curl_close($ch);
    preg_match('/crossorigin="anonymous" href="(https:\/\/abs\.twimg\.com\/responsive-web\/client-web-legacy\/main\..*\.js)" \/>/',$output_data,$str);
    $data[0]=$str[1];
    preg_match('/document.cookie="gt=(.*);/iU',$output_data,$str);
    $data[1]=$str[1];
    return $data;
}
$data=getmainjs();
// var_dump($data);
// echo $url;
$url=$data[0];
$time=$data[1];
function gettokens($url1)
{
    $header=array(
    'Host: abs.twimg.com'
    );
    $url=$url1;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0);
    $output_data=curl_exec($ch);
    if(curl_error($ch))
{
    echo '[{}]';
    exit;
}
    curl_close($ch);
    preg_match('/"(AAAAA.*)";/iU',$output_data,$str);
    return $str[1];    
}
$token=gettokens($url);
// var_dump($token);
$url="https://twitter.com/i/api/1.1/users/phone_number_available.json?raw_phone_number=%2B86$phone";
$header=array(
'Host: twitter.com',
"Authorization: Bearer $token",
"X-Guest-Token: $time",
''
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0);
$output_data=curl_exec($ch);
if(curl_error($ch))
{
    echo '[{}]';
    exit;
}
curl_close($ch);
// echo $output_data;
foreach(json_decode($output_data) as $a => $b)
{
if($a=='valid')
{
    if($b==false)
    {
    echo '[{"from_id":"'.$phone.'","root_id":"regsited:twitter.com","root_label":"regsited:twitter.com","type":"registed","imageurl":"/img/icon/registed.png","title":"推特接口 返回数据","raw_data":"","edge_color":"yellow","edge_label":"推特注册枚举"}]';
    }
    else 
    {
        echo '[{}]';
    }
}
}
?>