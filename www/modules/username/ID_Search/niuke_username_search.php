<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
if($_GET['username'])
{
$username=$_GET['username'];  
}
if($_GET['unknown'])
{
$username=$_GET['unknown'];  
}
# url 生成
$url = "https://gw-c.nowcoder.com/api/sparta/pc/search?_=1";
#
$page=1;
# 数据包发送 post
for($page=1;$page<=3;$page++)
{
$ch = curl_init(); 
$post_data ="{\"query\": \"$username\",\"type\":\"user\",\"page\":$page,\"pageSize\":15}";
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);


$headers = array();
$headers[] = 'Host: gw-c.nowcoder.com';
$headers[] = 'Content-Type: application/json';
$headers[] = 'Accept: application/json, text/plain, */*';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$output = curl_exec($ch);
if (curl_errno($ch)) {
echo 'Error:' . curl_error($ch);
echo "<br>";
}
curl_close ($ch);
$list=json_decode($output,true)['data'];
$total_page=$list['totalPage'];
// echo '总计'.$total_page.'页';
// echo '<br>';  
foreach($list['records'] as $partname => $partcontent)
{  
foreach($partcontent as $itemname => $itemcontent)
{
switch($itemname)
{
case 'nickname':
echo ",<newnode>,$itemcontent";
break;  
case 'workTime':
echo ",worktime:$itemcontent";    
break;  
case 'educationInfo':
echo ",$itemcontent,";    
break;
case 'identityList':
echo ",$itemcontent,";     
break;
case 'jobName':
echo ",$itemcontent,";     
break;
}
}
} 
if($page==$total_page)
{
break;
}
# 数据处理
}
?>