<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
$username=$_GET['username'];
# url 生成
$url = "https://passport.csdn.net/v1/service/usernames/".$username."?comeFrom=0";
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

$email_reg = '/,"email":"(.*)"},"/i';
preg_match_all($email_reg, $output, $result);
$email=$result[1][0];
$phone_reg = '/"data":{"mobile":"(.*)","email":/i';
preg_match_all($phone_reg, $output, $result);
$phone=$result[1][0];
echo $phone.','.$email;
# 结果输出
// echo $output;
?>