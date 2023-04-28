<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$phone=$_GET['phone'];
$header=array(
'Host: weibo.com',
'Accept: */*',
'Accept-Encoding: indentity',
'Content-Type: application/x-www-form-urlencoded',
'X-Requested-With: XMLHttpRequest',
'Dnt: 1',
'Referer: https://weibo.com/signup/signup.php',
''
);
$url="https://weibo.com/signup/v5/formcheck?type=mobilesea&zone=0086&value=$phone&from=";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
// curl_setopt($ch, CURLOPT_HEADER,1);
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0);
$output_data=curl_exec($ch);
/* echo $output_data;
exit; */
if(curl_error($ch))
{
    echo '[{}]';
    exit;
}
curl_close($ch);
if($output_data=='{"code":"600001","data":{"id":"","state":true,"type":"err","code":"600001","action":"io","msg":"\u8be5\u624b\u673a\u53f7\u5df2\u6ce8\u518c\uff0c\u53ef<a href=\"javascript:void(0)\" action-type=\"btn_login\">\u76f4\u63a5\u767b\u5f55<\/a>","iodata":""},"msg":""}')
{
    echo '[{"from_id":"'.$phone.'","root_id":"registed:weibo.com","root_label":"registed:weibo.com","type":"registed","imageurl":"/img/icon/registed.png","title":"微博注册接口枚举","raw_data":"","edge_color":"yellow","edge_label":"注册枚举"}]';
}
else
{
    echo '[{}]';
}

?>