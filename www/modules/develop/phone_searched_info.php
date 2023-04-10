<?php
# 输入变量
$phone=$_GET['phone'];
# url 生成
$url = "https://www.114best.com/dh/114.aspx?w=$phone";
#
# 数据包发送 post
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
# ssl 认证
// curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
// curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
# POST
// 我们在POST数据哦！
curl_setopt($ch, CURLOPT_POST, 1);

$headers = array();
$headers[] = 'Host: www.114best.com';
$headers[] = 'Accept-Encoding: gzip, deflate';
$headers[] = 'X-Requested-With: XMLHttpRequest';

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$output = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
    echo "<br>";
}
curl_close ($ch);

# 数据处理

$test_reg = '/"status":"(.*)","message"/i';
preg_match_all($test_reg, $output, $result);

# echo $phone;
# echo "<br>";
 echo $output;
# echo "<br>";
# echo "<br>";
# 结果输出
?>