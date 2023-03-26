<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
$phone=$_GET['phone'];
$name=$_GET['name'];
$email=$_GET['email'];
$idcard=$_GET['idcard'];
# url 生成
$url = "https://passport.baidu.com/v2/?regphonecheck&tpl=sslxy&subpro=&apiver=v3&tt=1&phone=".$phone;
#
# 数据包发送 post
$ch = curl_init(); 
$post_data = array(
    'usermail' => $phone
);

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
# ssl 认证
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
# POST
// 我们在POST数据哦！
# curl_setopt($ch, CURLOPT_POST, 1);
// 把post的变量加上
# curl_setopt($ch, CURLOPT_POSTFIELDS, "usermail=".$phone);


$headers = array();
$headers[] = 'Host: www.hetianlab.com';
// $headers[] = 'X-Custom-Header: MyHeader';

# curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$output = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
    echo "<br>";
}
curl_close ($ch);

# 数据处理

$test_reg = '/"msg": "(.*)，/i';
preg_match_all($test_reg, $output, $result);

# echo $phone;
# echo "<br>";
# echo $url;
# echo "<br>";
# echo "<br>";
$test=$result[1][0];
# echo "$phone";
# echo "<br>";
# echo "$test";
if($test=="手机号已被注册")
{
echo "true";
}
else if($test!="手机号已被注册")
{
echo "false";
}

# 结果输出
?>