<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
$ip=$_GET['ip'];
# url 生成
$url = "https://api.webscan.cc/?action=query&ip=".$ip;
#
# 数据包发送 post
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
# ssl 认证
// curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
// curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
# POST
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
$output = curl_exec($ch);
curl_close ($ch);
if($output=='null')
{
    echo '[{}]';
    exit;
}
echo '[';
foreach(json_decode($output) as $i => $item)
{
foreach($item as $name => $content)
{
if(!empty($content))
switch($name)
{
case 'domain':
    $domain=$content;
    echo '{"from_id":"'.$ip.'","root_id":"'.$domain.'","root_label":"'.$domain.'","type":"domain","imageurl":"/img/icon/domain.png","title":"IP 反查域名","raw_data":"","edge_color":"orange","edge_label":"IP 反查"},';    
break;
case 'title':
    echo '{"from_id":"'.$domain.'","root_id":"'.$content.'","root_label":"'.$content.'","type":"unkonwn","imageurl":"/img/icon/unkonwn.png","title":"IP 反查域名,附加信息","raw_data":"","edge_color":"orange","edge_label":"IP 反查"},';
   break;                
}
}
}
echo '{}]';
?>