<?php
# 输入变量
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$phone=$_GET['phone'];
# url 生成
$url = "https://user.skyeye.qianxin.com/user/check_phone?next=https%3A//hunter.qianxin.com/api/uLogin";
#
# 数据包发送 post
$ch = curl_init(); 
$post_data = array(
    'phone' => $phone
);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER,1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
$headers = array();
$headers[] = 'Host: user.skyeye.qianxin.com';
$headers[] = 'Cookie: csrf_token=1; User-Center=1';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$output = curl_exec($ch);
curl_close ($ch);
preg_match_all('/(Set-Cookie:)(.*);/iU',$output,$str); //这里采用正则匹配来获取cookie并且保存它到变量$str里，这就是为什么上面可以发送cookie变量的原因
$cookie ='Cookie:';
foreach($str as $a =>$b )
{
    if($a==2)
    {
        foreach($b as $c => $d)
        {
        $cookie=$cookie.$d.';';
        }
    }
}
// echo $cookie;
function getresult($phone,$cookie)
{
    $url = "https://user.skyeye.qianxin.com/user/check_phone?next=https%3A//hunter.qianxin.com/api/uLogin";
    #
    # 数据包发送 post
    $ch = curl_init(); 
    $post_data = array(
        'phone' => $phone
    );
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    $headers = array();
    $headers[] = 'Host: user.skyeye.qianxin.com';
    $headers[] = "$cookie";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $output = curl_exec($ch);
    curl_close ($ch);
   // echo $output;
foreach(json_decode($output,true) as $a => $b)
{
        if($b=='手机号已存在')
        {
            // echo $b;
            echo '[{"from_id":"'.$phone.'","root_id":"registed:qianxin.com","root_label":"registed:qianxin.com","type":"registed","imageurl":"/img/icon/registed.png","title":"该号码可能注册 qianxin.com,通常意味着号主可能是红队,渗透测试岗位等等","raw_data":"","edge_color":"orange","edge_label":"注册枚举"}]';
            exit;
        }
}
echo '[{}]';
}
getresult($phone,$cookie);
exit;
?>