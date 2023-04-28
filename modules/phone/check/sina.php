<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$url="https://login.sina.com.cn/signup/check_user.php";
$phone=$_GET['phone'];
$header=array(
'Host: login.sina.com.cn',
'Accept-Encoding: indentity',
'Content-Type: application/x-www-form-urlencoded',
'X-Requested-With: XMLHttpRequest',
'Origin: https://login.sina.com.cn',
'Referer: https://login.sina.com.cn/signup/signup?entry=homepage',
''
);
$data="name=$phone&format=json&from=mobile";
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
/* echo $output_data;
exit; */

foreach(json_decode($output_data) as $a => $b)
{
    if($a=='retcode')
    {
        if($b=='100001')
        {
        echo '[{"from_id":"'.$phone.'","root_id":"registed:sina.com","root_label":"registed:sina.com","type":"registed","imageurl":"/img/icon/registed.png","title":"sina注册枚举，sina是个国内老牌社交媒体","raw_data":"","edge_color":"yellow","edge_label":"注册枚举"}]';
        }
        else
        {
            echo '[{}]';
        } 
        exit;
    }
}
echo '[{}]';


?>