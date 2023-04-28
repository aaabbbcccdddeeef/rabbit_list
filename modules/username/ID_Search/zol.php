<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
$username=$_GET['username'];
$url="https://bbs.zol.com.cn/index.php?c=search&kword=".$username;
$header=array(
'Host: bbs.zol.com.cn',
'Cookie: Adshow=5; ip_ck=%3D; lv=1; vn=1; questionnaire_pv=1; z_pro_city=fuckyou; z_day=fuckyou',
''
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
 $output = curl_exec($ch);
if (curl_errno($ch)) {
    echo '[{}]';
exit;
}
curl_close ($ch);
preg_match_all('/href="https:\/\/my.zol.com.cn\/bbs\/(.*)" title="/',$output,$result);

$reg="/(.*)($username)(.*)/";
echo '[';
foreach($result[1] as $part)
{
    if(preg_match($reg,$output,$nothing))
    {
    echo '{"from_id":"'.$username.'","root_id":"'.$part.'","root_label":"'.$part.'","type":"username","imageurl":"/img/icon/username.png","title":"ZOL 爬取用户名","raw_data":"","edge_color":"yellow","edge_label":"ZOL 爬取"},';
    }
}
echo '{}]';
?>