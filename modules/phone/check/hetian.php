<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
$phone=$_GET['phone'];
$name=$_GET['name'];
$email=$_GET['email'];
$idcard=$_GET['idcard'];
# url 生成
$url = "https://www.hetianlab.com/regist!checkUserPhone.action";
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
curl_setopt($ch, CURLOPT_POST, 1);
// 把post的变量加上
curl_setopt($ch, CURLOPT_POSTFIELDS, "usermail=".$phone);


$headers = array();
$headers[] = 'Host: www.hetianlab.com';
// $headers[] = 'X-Custom-Header: MyHeader';

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$output = curl_exec($ch);
if (curl_errno($ch)) {
    echo '[{}]';
    exit;
}
curl_close ($ch);

# 数据处理

$test_reg = '/"result":"(.*)","message"/i';
preg_match_all($test_reg, $output, $result);

# echo $phone;
# echo "<br>";
# echo $url;
# echo "<br>";
# echo "<br>";
$test=$result[1][0];
if($test=='notexist')
{
    echo "[{}]";
}
else if($test!='notexist')
{
    echo '[{"from_id":"'.$phone.'","root_id":"registed:hetianlab.com","root_label":"registed:hetianlab.com","type":"registed","imageurl":"/img/icon/registed.png","title":"该号码可能注册 hetianlab.com,通常意味着号主是个学生,或者正在学习网络空间安全","raw_data":"","edge_color":"yellow","edge_label":"注册枚举"}]';
}
# 结果输出
?>