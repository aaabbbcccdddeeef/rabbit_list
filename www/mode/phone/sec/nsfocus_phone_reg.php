<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
$phone=$_GET['phone'];
# url 生成
$url = "https://poma.nsfocus.com/api/krosa/poma/v3/auth/checkUnique/";
#
# 数据包发送 post
$ch = curl_init(); 
$post_data = array(
    'field' => 'mobile',
    'value' => $phone
);

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
# ssl 认证
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
# POST
curl_setopt($ch, CURLOPT_POST, 1);
// 把post的变量加上
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);


$headers = array();
$headers[] = 'Host: poma.nsfocus.com';
// $headers[] = 'X-Custom-Header: MyHeader';

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$output = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
    echo "<br>";
}
curl_close ($ch);

# 数据处理

$test_reg = '/"unique":(.*)},"module"/i';
preg_match_all($test_reg, $output, $result);

# echo $phone;
# echo "<br>";
# echo $url;
# echo "<br>";
$test=$result[1][0];
if($test='true')
{
   echo "false";
}
else if($test='false')
{
    echo "true";
}
# echo "<br>";
# echo $output;
# 结果输出
?>