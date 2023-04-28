<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
$phone=$_GET['phone'];
$name=$_GET['name'];
$email=$_GET['email'];
$idcard=$_GET['idcard'];
# url 生成
$url = "https://b-api.speedtest.cn//login/checkPhoneMail";
# 数据包发送 post
$ch = curl_init(); 
$post_data = "account=".$phone;

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
# ssl 认证
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
# POST
// 我们在POST数据哦！
# curl_setopt($ch, CURLOPT_POST, 1);
// 把post的变量加上
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);


$headers = array();
$headers[] = 'Host: b-api.speedtest.cn';
// $headers[] = 'X-Custom-Header: MyHeader';

# curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$output = curl_exec($ch);
if (curl_errno($ch)) {
    echo '[{}]';
    exit;
}
curl_close ($ch);

# 数据处理

foreach(json_decode($output) as $a => $b)
{
if($a=='data')
{
    foreach($b as $c => $d)
    {
        if($c=='exist')
        {
            if($d)
            {
            echo '[{"from_id":"'.$phone.'","root_id":"registed:speedtest.cn","root_label":"registed:speedtest.cn","type":"registed","imageurl":"/img/icon/registed.png","title":"该号码可能注册 speedtest.cn,通常意味着号主可能是网工,电子发烧友等等","raw_data":"","edge_color":"yellow","edge_label":"注册枚举"}]';
            exit;
            }
            else
            {
                echo '[{}]';
                exit;
            }
        }
    }
}
}
?>