<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
$phone=$_GET['phone'];
$name=$_GET['name'];
$email=$_GET['email'];
$idcard=$_GET['idcard'];
# url 生成
$url = "https://weibo.com/signup/v5/formcheck?type=mobilesea&zone=0086&value=".$phone;
#
# 数据包发送 post
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

$test_reg = '/{"code":"(.*)","data":/i';
preg_match_all($test_reg, $output, $result);

// echo $output;
# echo "<br>";
# echo $url;
# echo "<br>";
# echo "<br>";
$test=$result[1][0];
# echo "$phone";
# echo "<br>";
// echo "$test";
if($test=="600001")
{
echo "true";
}
else if($test=="100000")
{
echo "false";
}

# 结果输出
?>