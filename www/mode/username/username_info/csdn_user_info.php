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
#
# 数据包发送 post
$ch = curl_init(); 
// $post_data ="username=".$phone."&password=12345678&key=&captcha=";

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
# ssl 认证
//curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
//curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
# POST
// 我们在POST数据哦！
# curl_setopt($ch, CURLOPT_POST, 1);
// 把post的变量加上
// curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);


$headers = array();
$headers[] = 'Cookie: lang=en';
// $headers[] = 'X-Custom-Header: MyHeader';

# curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$output = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
    echo "<br>";
}
curl_close ($ch);

# 数据处理

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

$username_reg='/"\],"username":\["(.*)"\],"hostname":\["/i';
preg_match_all($username_reg, $usefuldata, $result);
$usename_reg=$result[1][0];

if(!empty($usefuldata_desc))
{
    echo "$usename_reg".",".$usefuldata_ip.",".$usefuldata_city.",注册时间:".$usefuldata_desc;

}
?>