<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$username=$_GET['username'];
$url='https://www.freebuf.com/author/'.$username;
$header=array(
    'Host: www.freebuf.com',
    'User-Agent: Mozilla/5.0 (X11; CrOS x86_64 14794.0.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5045.0 Safari/537.36',
    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
    'Accept-Language: zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
    'Accept-Encoding: indentity',
    'Dnt: 1',
    'Upgrade-Insecure-Requests: 1',
    'Sec-Fetch-Dest: document',
    'Sec-Fetch-Mode: navigate',
    'Sec-Fetch-Site: none',
    'Sec-Fetch-User: ?1',
    'Sec-Ch-Ua-Platform: "Chromium OS"',
    'Sec-Ch-Ua: "Google Chrome";v="103", "Chromium";v="103", "Not=A?Brand";v="24"',
    'Sec-Ch-Ua-Mobile: ?0',
    'Te: trailers',
    'Connection: close',
    ''
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
$output = curl_exec($ch);
// echo $url;
if (curl_errno($ch)) {
    echo '[{}]';
    exit;
}
curl_close($ch);
preg_match('/userData:{ID:"(.*)",user_login:/',$output,$result);
$ID=$result[1];
// var_dump($result);
preg_match('/user_registered:"(.*)",nickname:"/',$output,$result);
$time=$result[1];
preg_match('/",nickname:"(.*)",is_company:/',$output,$result);
$nickname=$result[1];
preg_match('/,rmb:(.*),jb:"/',$output,$result);
$rmb=$result[1];
preg_match('/vip_time:"(.*)",skin:/',$output,$result);
$viptime=$result[1];
preg_match('/read_count:"(.*)",is_follow/',$output,$result);
$readcount=$result[1];
echo '[';
$title=$title."注册时间: $time;";
$title=$title."收益: $rmb;";
$title=$title."vip注册时间: $viptime;";
$title=$title."阅读量: $readcount;";
if(!empty($ID))
{
echo '{"from_id":"'.$username.'","root_id":"'.$ID.'","root_label":"'.$ID.'","type":"unknown","imageurl":"/img/icon/unknown.png","title":"Freebuf 用户UID主页信息,'.$title.'","raw_data":"","edge_color":"yellow","edge_label":"freebuf爬取"},';
}
echo '{}]';
?>