<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
$phone=$_GET['phone'];
# url 生成
$url = "https://passport.zhihuishu.com/user/validateMobileIsExists";
#
# 数据包发送 post
$ch = curl_init(); 
$post_data = "account=".$phone."&flag=0";

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
# ssl 认证
// curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
// curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
# POST
// 我们在POST数据哦！
curl_setopt($ch, CURLOPT_POST, 1);
// 把post的变量加上
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);


$headers = array();
$headers[] = 'Host: passport.zhihuishu.com';
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
echo $output;
echo '<br>';

$test_reg = '/{"status":(.*)}/i';
preg_match_all($test_reg, $output, $result);
$test=$result[1][0];
if($test==1)
{
    echo 'false';
}
else if($test==-2)
{
    echo 'true';
}
# echo "<br>";
# echo "<br>";
# 结果输出
?>