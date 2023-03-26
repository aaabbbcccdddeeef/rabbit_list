<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
$ip=$_GET['ip'];
# url 生成
$url = "https://www.cz88.net/api/cz88/ip/base?ip=$ip";
#
# 数据包发送 post

function wash($wash)
{
    $wash=str_replace('"','',$wash);
    $wash=str_replace('”','',$wash);
    $wash=str_replace('“','',$wash);
    return $wash;
}



$ch = curl_init(); 
// $post_data ="username=".$phone."&password=12345678&key=&captcha=";

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
# ssl 认证
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
# POST
// 我们在POST数据哦！
# curl_setopt($ch, CURLOPT_POST, 1);
// 把post的变量加上
// curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);


$headers = array();
$headers[] = 'Host: www.cz88.net';
// $headers[] = 'X-Custom-Header: MyHeader';

# curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$output = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
    echo "<br>";
}
curl_close ($ch);

# 数据处理


$asn_reg = '/","asn":"(.*)","iana":"/i';
preg_match_all($asn_reg, $output, $result);
$asn=$result[1][0];
$provience_reg='/","province":"(.*)","city":"/i';
preg_match_all($provience_reg, $output, $result);
$provience=$result[1][0];
$city_reg='/","city":"(.*)","districts":"/i';
preg_match_all($city_reg, $output, $result);
$city=$result[1][0];
$districts_reg='/","districts":"(.*)","isp":"/i';
preg_match_all($districts_reg, $output, $result);
$districts=$result[1][0];
$isp_reg= '/","isp":"(.*)","geocode":"/i';
preg_match_all($isp_reg, $output, $result);
$isp=$result[1][0];
$networktype_reg='/","netWorkType":"(.*)","mbRate":"/i';
preg_match_all($networktype_reg, $output, $result);
$networktype=$result[1][0];
$action_reg='/","actionAddress":\["(.*)"\],"company":"/i';
preg_match_all($action_reg, $output, $result);
$action=$result[1][0];
$company_reg='/"\],"company":"(.*)","locations":/i';
preg_match_all($company_reg, $output, $result);
$company=$result[1][0];
$domain_reg='/,"domains":\["(.*)"\],"breadRateMap":/i';
preg_match_all($domain_reg, $output, $result);
$domain=$result[1][0];
$ip=wash($ip);
$asn=wash($asn);
$provience=wash($provience);
$city=wash($city);
$districts=wash($districts);
$isp=wash($isp);
$networktype=wash($networktype);
$action=wash($action);
$company=wash($company);
$domain=wash($domain);
if($company=='暂未发现');
{
    $company='';
}
echo "<newnode>,cz:$ip,$asn,$provience,$city,$districts,$isp,$networktype,$action,$company,$domain,";

// echo '<br>';
// echo $output;
# 结果输出
?>