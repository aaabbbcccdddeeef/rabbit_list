<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
if($_GET['username'])
{
    $username=$_GET['username'];    
}
if($_GET['input'])
{
    $username=$_GET['input'];
}
# url 生成
$url = "https://api.bilibili.com/x/web-interface/wbi/search/type?__refresh__=true&_extra=&context=&page=1&page_size=36&order=&duration=&from_source=&from_spmid=1&platform=pc&highlight=1&single_column=0&keyword=".$username."&ad_resource=&source_tag=3&gaia_vtoken=&category_id=&search_type=bili_user&order_sort=0&user_type=0&dynamic_offset=0";
#
# 数据包发送 post
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$headers = array();
$headers[] = 'Host: api.bilibili.com';
$headers[] = 'Cookie: buvid3=1; buvid_fp=1; buvid4=1; _uuid=1; b_nut=100; CURRENT_FNVAL=4048; fingerprint3=1; fingerprint=1; sid=1; buvid_fp_plain=undefined; hit-dyn-v2=1; i-wanna-go-back=-1; b_ut=5; nostalgia_conf=-1; PVID=1; b_lsid=1';
$headers[] = 'User-Agent: 1';
$headers[] = 'Accept: application/json, text/plain, */*';
$headers[] = 'Accept-Language: zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2';
$headers[] = 'Accept-Encoding: identity';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
$output = curl_exec($ch);
if (curl_errno($ch)) {
echo 'Error:' . curl_error($ch);
echo "<br>";
}
curl_close ($ch);
echo '[';
if(empty($output))
{
    echo '{}]';
    exit;
}
if(empty(json_decode($output,true)['data']['result']))
{
    echo '{}]';
    exit;
}
foreach(json_decode($output,true)['data']['result'] as $i)
{
foreach($i as $itemname => $itemcontent)
{
switch($itemname)
{
case 'uname':
$username1=$itemcontent;
break;
case 'usign':  
break;   
case 'gender':
switch($itemcontent)
{
    case '1':
        $gender="性别:男";    
    break;    
    case '2':
        $gender='性别:女';    
    break;    
    case '3':
        $gender='性别:未知';
    break;    
}
break;
}
}
$gender='性别:未知';
echo '{"from_id":"'.$username.'","root_id":"'.$username1.'","root_label":"'.$username1.'","type":"username","imageurl":"/img/icon/username.png","title":"Bilibili 搜索用户名,性别'.$gender.'","raw_data":"","edge_color":"yellow","edge_label":"BiliBili"},';
}
echo '{}]';
?>