<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
$ip=$_GET['domain'];
# url 生成
$show_result=[];
$email=getconfig('fofa_email',$config);
$key=getconfig('fofa_key',$config);
$qbase=base64_encode($ip);
$url = "https://fofa.info/api/v1/search/all?qbase64=$qbase&$size=10000&email=$email&key=$key";
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
$headers[] = 'Host: fofa.info';
// $headers[] = 'X-Custom-Header: MyHeader';

# curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$output = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
    echo "<br>";
}
curl_close ($ch);

# 数据处理
$str_result=json_decode($output);
foreach($str_result as $name => $content)
{
if($name=="results")
{
 //   var_dump($content);
 foreach($content as $name1 => $content1)
{
   // var_dump($content1);
   // echo   '<br>';
    $show_result[]=$content1[0];
   // $show_result[]=$content1[1].':'.$content[2];
}
}
}
$show_result=array_unique($show_result);
foreach($show_result as $result)
{
    echo  ",$result";
   // echo  '<br>';
}
?>