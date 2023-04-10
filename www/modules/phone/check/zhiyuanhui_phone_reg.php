<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
$phone=$_GET['phone'];
# url 生成
$url = "https://m.zyh365.com/common/api-public?app_id=h5";
#
# 数据包发送 post
$ch = curl_init(); 
$post_data = "api=userCenter%2Flogin&username=".$phone."&password=".$phone."&apimode=vmsapi";

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
# ssl 认证
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
// 我们在POST数据哦！
curl_setopt($ch, CURLOPT_POST, 1);
// 把post的变量加上
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);


$headers = array();
$headers[] = 'Host: m.zyh365.com';
$headers[] = 'Cookie: HWWAFSESID=1; HWWAFSESTIME=1';

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$output = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
    echo "<br>";
}
curl_close ($ch);

# 数据处理

$test_reg = '/"message":"(.*)","success"/i';
preg_match_all($test_reg, $output, $result);

# echo $phone;
# echo "<br>";
# echo $output;
# echo "<br>";
# echo "<br>";
$test=$result[1][0];
if($test=='\u8d26\u53f7\u5bc6\u7801\u9519\u8bef')
{
    echo "true";
}
if($test=='\u8d26\u53f7\u5bc6\u7801\u9519\u8bef\u6216\u672a\u6ce8\u518c')
{
    echo "false";
}
# 结果输出
?>