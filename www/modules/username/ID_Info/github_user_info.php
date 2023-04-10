<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$github_api=getconfig('github_api',$config);
$username=$_GET['username'];
$url = "https://api.github.com/users/$username";
#
# 数据包发送 post
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
// curl_setopt($ch, CURLOPT_POST, 1);
// curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
$headers = array();
$headers[] = "Authorization: token $github_api";
$headers[] = 'User-Agent: Mozilla/5.0';
$headers[] = 'Content-Type:application/json';
$headers[] = 'method:GET';
$headers[] = 'Accept:application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$output = curl_exec($ch);
curl_close ($ch);
foreach(json_decode($output) as $item => $data)
{
switch($item)
{
case 'email':
case 'company':
case 'twitter_username':
case 'create_at':
case 'location':
case 'blog':  
case 'name':
case 'login':  
echo ",$data,";  
break;  
}
}

?>