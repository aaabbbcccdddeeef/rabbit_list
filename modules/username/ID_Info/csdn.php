<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
$phone=$_GET['phone'];
$username=$_GET['username'];
$email=$_GET['email'];
$idcard=$_GET['idcard'];
# url 生成
$url = "https://blog.csdn.net/".$username;
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
# ssl 认证
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
$headers = array();
$headers[] = 'Cookie: lang=en';
$output = curl_exec($ch);
if (curl_errno($ch)) {
    echo '[{}]';
    exit;
}
curl_close ($ch);
$usefuldata_reg='/INITIAL_STATE__=(.*)};/i';
preg_match_all($usefuldata_reg, $output, $result);
$usefuldata=$result[1][0];
//
//echo $usefuldata;
$ip_reg='/{"ip":"(.*)","region":"/i';
preg_match_all($ip_reg, $usefuldata, $result);
$usefuldata_ip=$result[1][0];
//echo $usefuldata_ip;
# 结果输出
$city_reg='/属地：(.*)","msg":"/i';
preg_match_all($city_reg, $usefuldata, $result);
$usefuldata_city=$result[1][0];
// echo $usefuldata_city;

$desc_reg='/"registrationTime":"(.*)","codeAge":/i';
preg_match_all($desc_reg, $usefuldata, $result);
$usefuldata_desc=$result[1][0];
// echo "$usefuldata_desc";
preg_match('/"nickname":"(.*)"/iU', $usefuldata, $str);
$username_id=$str[1];

preg_match_all('/\"gender\":(.*),\"defaultBackgroundImg\"/',$usefuldata,$result);

if($result[1][0]==1)
{
    $gender='男';
}
else if($result[1][0]==0)
{
    $gender='女';
}

echo '[';
if(!empty($usefuldata_desc))
{
    if($username_id)
    {
    $title="注册时间:$usefuldata_desc,性别:$gender";  
    echo '{"from_id":"'.$username.'","root_id":"'.$username_id.'","root_label":"'.$username_id.'","type":"username","imageurl":"/img/icon/username.png","title":"CSDN 爬虫返回数据,'.$title.'","raw_data":"","edge_color":"yellow","edge_label":"用户名爬取信息"},';
    }
    if($usefuldata_ip)
    {
        echo '{"from_id":"'.$username.'","root_id":"'.$usefuldata_ip.'","root_label":"'.$usefuldata_ip.'","type":"ip","imageurl":"/img/icon/ip.png","title":"CSDN 爬虫返回数据","raw_data":"","edge_color":"yellow","edge_label":"用户名爬取信息"},';
    }
    if($usefuldata_city)
    {
        echo '{"from_id":"'.$username.'","root_id":"'.$usefuldata_city.'","root_label":"'.$usefuldata_city.'","type":"address","imageurl":"/img/icon/address.png","title":"CSDN 爬虫返回数据","raw_data":"","edge_color":"yellow","edge_label":"用户名爬取信息"},';
    }
}
echo '{}]';
?>