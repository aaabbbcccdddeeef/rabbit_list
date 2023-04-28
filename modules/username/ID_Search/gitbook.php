<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$username=$_GET['username'];
$url='https://gitbook.cn/searchV2?type=customer&keyword='.$username.'&page=1';
$header=array(
    'Host: gitbook.cn',
    'Accept-Encoding: identity',
    'Content-Type: application/json; charset=utf-8',
    'X-Requested-With: XMLHttpRequest',
    ''
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
$output = curl_exec($ch);
if (curl_errno($ch)) {
    echo '[{}]';
    exit;
}
curl_close($ch);
echo '[';
foreach(json_decode($output) as $a => $b)
{
if($a=='data')
{
foreach($b as $c => $d)
{
if($c=='customers')
{
    foreach($d as $e)
    {
        foreach($e as $f => $g)
        {
            if(!empty($g))
            {
            if($f=='id')
            {
                $id=$g;
            }
            if($f=='nickname')
            {
                $name=str_replace('<mark>','',$g);
                $nickname=str_replace('</mark>','',$name);
            }
            if($f=='title')
            {
                $job=$g;
            }
            if($f=='background')
            {
                $background=$g;
            }
            if($f=='createdAt')
            {
                $time=$g;
            }
        }
        }
        echo '{"from_id":"'.$username.'","root_id":"'.$id.'","root_label":"'.$id.'","type":"unknown","imageurl":"/img/icon/unknown.png","title":"Gitbook 信息,注册时间:'.$time.'","raw_data":"","edge_color":"orange","edge_label":"Gitbook 爬取"},';
        echo '{"from_id":"'.$id.'","root_id":"'.$nickname.'","root_label":"'.$nickname.'","type":"username","imageurl":"/img/icon/username.png","title":"Gitbook 信息,注册时间:'.$time.'","raw_data":"","edge_color":"orange","edge_label":"Gitbook 爬取"},';
        echo '{"from_id":"'.$nickname.'","root_id":"'.$job.'","root_label":"'.$job.'","type":"unknown","imageurl":"/img/icon/unknown.png","title":"Gitbook 信息,注册时间:'.$time.'","raw_data":"","edge_color":"orange","edge_label":"Gitbook 爬取"},';
   $time='';
   $job='';
   $background='';
    }
}
}
}
}
echo '{}]';
?>