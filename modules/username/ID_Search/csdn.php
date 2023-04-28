<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
function wash($wash)
{
$wash=str_replace('"','',$wash);
$wash=str_replace('abstract1:','',$wash);
$wash=str_replace('”','',$wash);
return $wash;
}
$username=$_GET['username'];
$from=$username;
$showresult="";
# url 生成
$page=1;
echo '[';
while(1)
{
$url ="https://so.csdn.net/api/v3/search?q=".$username."&t=userinfo&p=".$page."&s=0&tm=0&ft=0&platform=pc";
#
# 数据包发送 post
$ch = curl_init(); 
// $post_data ="username=".$phone."&password=12345678&key=&captcha=";

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
# ssl 认证
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
$headers = array();
$headers[] = 'Cookie: lang=en';
$output_data = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
    echo "<br>";
}
curl_close ($ch);

# 数据处理
if(empty($output_data))
{
    echo '{}]';
    exit;
}
$output=explode('{"birthday":',$output_data);
    foreach($output as $datanum )
    {
    // echo "$datanum";    
$realname_reg = '/"realname":"(.*)","tags":/i';
preg_match_all($realname_reg, $datanum,$result);
$realname=$result[1][0];
$email_reg='/","email":"(.*)","length_statis":/i';
preg_match_all($email_reg, $datanum,$result);
$email=$result[1][0];
$position_reg='/","position":"(.*)","biz_id":"/i';
preg_match_all($position_reg, $datanum,$result);
$position=$result[1][0];
$username_reg='/"username":"(.*)","eventView"/i';
preg_match_all($username_reg, $datanum,$result);
$username=$result[1][0];
$username=wash($username);
$realname=wash($realname);
$email=wash($email);
$position=wash($position);
if(strlen($username)>=4)
{
    //  echo "<newnode>,$username,$realname,$email,$position,";
    echo '{"from_id":"'.$from.'","root_id":"'.$username.'","root_label":"'.$username.'","type":"username","imageurl":"/img/icon/username.png","title":"CSDN 搜索接口返回数据","raw_data":"","edge_color":"yellow","edge_label":"用户名爬取信息"},';
    // echo "<br>";
}
if(strlen($realname)>=1)
{
    echo '{"from_id":"'.$username.'","root_id":"'.$realname.'","root_label":"'.$realname.'","type":"username","imageurl":"/img/icon/username.png","title":"CSDN 搜索接口返回数据","raw_data":"","edge_color":"yellow","edge_label":"用户名爬取信息"},';
}
if(strlen($position)>=3)
{
    echo '{"from_id":"'.$username.'","root_id":"'.$position.'","root_label":"'.$position.'","type":"username","imageurl":"/img/icon/username.png","title":"CSDN 搜索接口返回数据","raw_data":"","edge_color":"yellow","edge_label":"用户名爬取信息"},';
}
} 
// echo $showresult;

$page_reg='/"total_page":(.*)\.0,"js_insert_first":/i';
preg_match_all($page_reg, $output_data,$result);
$pageend=$result[1][0];
if($page==$pageend)
{
    break;    
}
$page++;
if($page>=10)
{
    break;
}
}
echo '{}]';
# 结果输出
?>