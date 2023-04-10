<?php
# 输入变量
$phone='+86'.$_GET['phone'];
# url 生成
$url = "https://www.xuetangx.com/api/v1/u/login/register/check_exists";
#
# 数据包发送 post
$ch = curl_init(); 
// "{\"type\":\"P\",\"name\":\"+86$phone\"}"
$post_data =array(
    'type' => '"P"',
    'name' => "\"$phone\""
);

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
# ssl 认证
// curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
// curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
# POST
curl_setopt($ch, CURLOPT_POST, 1);
// 把post的变量加上
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);


$headers = array();
$headers[] = 'Host: www.xuetangx.com';
$headers[] = 'Accept: application/json, text/plain, */*';
$headers[] = 'Accept-Encoding: gzip, deflate';
$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$output = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
    echo "<br>";
}
curl_close ($ch);

# 数据处理

$test_reg = '/"status":(.*),"msg"/i';
preg_match_all($test_reg, $output, $result);
echo $output;
exit;
# echo "<br>";
# echo $url;
# echo "<br>";
# echo "<br>";
$test=$result[1][0];
if($test=='10001')
{
    echo "false";
}
else if($test=='90010')
{
    echo "true";
}
# 结果输出
?>