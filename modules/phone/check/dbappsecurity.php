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
    echo '[{}]';
    exit;
}
curl_close ($ch);

# 数据处理

$test_reg = '/"data":(.*)}/i';
preg_match_all($test_reg, $output, $result);

# echo $output;
# echo "<br>";
# echo $url;
# echo "<br>";
if($result[1][0]=='true')
{
    echo '[{"from_id":"'.$phone.'","root_id":"registed:ti.dbappsecurity.com.cn","root_label":"registed:ti.dbappsecurity.com.cn","type":"registed","imageurl":"/img/icon/registed.png","title":"该号码可能注册 ti.dbappsecurity.com.cn,通常意味着号主市蓝队,运维,安服等岗位","raw_data":"","edge_color":"yellow","edge_label":"注册枚举"}]';
}
else 
{
    echo '[{}]';
}
# echo "<br>";
# 结果输出
?>