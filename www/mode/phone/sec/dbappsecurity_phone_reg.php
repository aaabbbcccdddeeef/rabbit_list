<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
$phone=$_GET['phone'];
$name=$_GET['name'];
$email=$_GET['email'];
$idcard=$_GET['idcard'];
# url 生成
$url = "https://ti.dbappsecurity.com.cn/web/system/user/hasLoginName?username=".$phone."&type=2";
#
# 数据包发送
$ch = curl_init(); 

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
# ssl 认证
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
#

$headers = array();
$headers[] = 'Host: ti.dbappsecurity.com.cn';
$headers[] = 'X-Custom-Header: MyHeader';

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$output = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
    echo "<br>";
}
curl_close ($ch);

# 数据处理

$test_reg = '/"data":(.*)}/i';
preg_match_all($test_reg, $output, $result);

# echo $output;
# echo "<br>";
# echo $url;
# echo "<br>";
echo $result[1][0];
# echo "<br>";
# 结果输出
?>