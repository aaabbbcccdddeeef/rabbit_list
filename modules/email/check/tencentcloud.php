<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$email=$_GET['email'];
$header=array(
'Host: cloud.tencent.com',
'Accept-Encoding: identity',
'Content-Type: application/json; charset=UTF-8',
'X-Requested-With: XMLHttpRequest',
''
);
$data='{"action":"checkAccountExist","username":"'.$email.'"}';
$url="https://cloud.tencent.com/register/ajax/";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0);
// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$output_data=curl_exec($ch);
if(curl_error($ch))
{
echo '[{}]';
exit;
}
curl_close($ch);
foreach(json_decode($output_data) as $a => $b)
{
    if($a=='code')
    {
    if($b=='102')
    {
    echo '[{"from_id":"'.$email.'","root_id":"registed:tencentcloud","root_label":"registed:tencentcloud","type":"registed","imageurl":"/img/icon/registed.png","title":"腾讯云注册枚举，该邮箱注册了腾讯云","raw_data":"","edge_color":"orange","edge_label":"注册枚举"}]';
    }
    else
    {
        echo '[{}]';
    }
    exit;
    }
}
?>