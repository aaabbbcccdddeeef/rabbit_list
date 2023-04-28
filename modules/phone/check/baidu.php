<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
$phone=$_GET['phone'];
$email=$_GET['email'];
# url 生成
$url = "https://passport.baidu.com/v2/?regphonecheck&tpl=sslxy&subpro=&apiver=v3&tt=1&phone=".$phone;
#
# 数据包发送 post
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
# ssl 认证
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
$output = curl_exec($ch);
if (curl_error($ch)) {
echo '[{}]';
exit;
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
    echo '[{"from_id":"'.$phone.'","root_id":"registed:baidu.com","root_label":"registed:baidu.com","type":"registed","imageurl":"/img/icon/registed.png","title":"该号码可能注册 baidu.com","raw_data":"","edge_color":"yellow","edge_label":"注册枚举"}]';
}
else if($test!="手机号已被注册")
{
echo '[{}]';
}

# 结果输出
?>