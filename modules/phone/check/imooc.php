<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
$phone=$_GET['phone'];
# url 生成
$url = "https://www.imooc.com/passport/user/checkphone?phone=".$phone;
#
# 数据包发送 post
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
# ssl 认证
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
$headers = array();
$headers[] = 'Host: www.imooc.com';
$headers[] = 'Referer: https://www.imooc.com/';

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$output = curl_exec($ch);
if (curl_errno($ch)) {
    echo '[{}]';
    exit;
}
curl_close ($ch);
# 数据处理
$test_reg = '/"status":(.*),"msg"/i';
preg_match_all($test_reg, $output, $result);
foreach(json_decode($output) as $a => $b)
{
    if($a=='status')
    {
if($b=='10001')
{
    echo "[{}]";
}
else if($b=='90010')
{
    echo '[{"from_id":"'.$phone.'","root_id":"registed:imooc.com","root_label":"registed:imooc.com","type":"registed","imageurl":"/img/icon/registed.png","title":"该号码可能注册 imooc.com,通常意味着号主是个学生或者讲师","raw_data":"","edge_color":"yellow","edge_label":"注册枚举"}]';
}
else 
{
    echo '[{}]';
}
    }
}
# 结果输出
?>