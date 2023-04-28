<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$username=$_GET['username'];
$url="https://api.zhihu.com/people/$username";
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$output = curl_exec($ch);
curl_close ($ch);
echo '[';
foreach(json_decode($output) as $item => $data)
{
switch($item)
{
case 'name':
// echo "$data";
echo '{"from_id":"'.$username.'","root_id":"'.$data.'","root_label":"'.$data.'","type":"username","imageurl":"/img/icon/username.png","title":"Zhihu页面爬取的结果","raw_data":"","edge_color":"yellow","edge_label":"Zhihu 爬取"},';
break;    
case 'headline':
$title=$title.$data;
break;    
case 'gender':
if($data==1)
{
    $title=$title.",性别:男";
}
else if($data==0)
{ 
    $title=$title.",性别:女";
}
break;
case 'ip_info':
if($data!='IP 属地未知')
{
    echo '{"from_id":"'.$username.'","root_id":"'.$data.'","root_label":"'.$data.'","type":"address","imageurl":"/img/icon/address.png","title":"Zhihu页面爬取的结果","raw_data":"","edge_color":"yellow","edge_label":"Zhihu 爬取"},';
}
break;
case 'business': 
foreach($data as $a => $b)
{
if($a=='name')
{
    if($b)
    {
        echo '{"from_id":"'.$username.'","root_id":"'.$b.'","root_label":"'.$b.'","type":"unkonw","imageurl":"/img/icon/unkonw.png","title":"Zhihu页面爬取的结果,可能是职业,'.$title.'","raw_data":"","edge_color":"yellow","edge_label":"Zhihu 爬取"},';
    }
}
}
break;
case 'location':
        foreach($data as $c)
    {
        foreach($c as $a => $b)
        {
            if($a=='name')
            {
                echo '{"from_id":"'.$username.'","root_id":"'.$b.'","root_label":"'.$b.'","type":"address","imageurl":"/img/icon/address.png","title":"Zhihu页面爬取的结果,可能是地理位置信息","raw_data":"","edge_color":"yellow","edge_label":"Zhihu 爬取"},';
            }
        }
    }
break;
case 'sina_weibo_name':
    echo '{"from_id":"'.$username.'","root_id":"'.$data.'","root_label":"'.$data.'","type":"username","imageurl":"/img/icon/username.png","title":"Zhihu页面爬取的结果,'.$title.'","raw_data":"","edge_color":"yellow","edge_label":"Zhihu 爬取"},';
break;
    }
}
echo '{}]';
?>