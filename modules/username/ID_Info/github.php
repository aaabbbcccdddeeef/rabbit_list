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
echo '[';
foreach(json_decode($output) as $item => $data)
{
    if(!empty($data))
    {
switch($item)
{
case 'email':
    echo '{"from_id":"'.$username.'","root_id":"'.$data.'","root_label":"'.$data.'","type":"email","imageurl":"/img/icon/email.png","title":"Github官方API获取到的结果","raw_data":"","edge_color":"yellow","edge_label":"Github API"},';                      
    break;
case 'company':
    echo '{"from_id":"'.$username.'","root_id":"'.$data.'","root_label":"'.$data.'","type":"company","imageurl":"/img/icon/company.png","title":"Github官方API获取到的结果","raw_data":"","edge_color":"yellow","edge_label":"Github API"},';
    break;
case 'create_at':
    echo '{"from_id":"'.$username.'","root_id":"'.$data.'","root_label":"'.$data.'","type":"unknown","imageurl":"/img/icon/unknown.png","title":"Github官方API获取到的创建时间","raw_data":"","edge_color":"yellow","edge_label":"Github API"},';
    break;
case 'location':
    echo '{"from_id":"'.$username.'","root_id":"'.$data.'","root_label":"'.$data.'","type":"address","imageurl":"/img/icon/address.png","title":"Github官方API获取到的结果","raw_data":"","edge_color":"yellow","edge_label":"Github API"},';
case 'blog':  
    echo '{"from_id":"'.$username.'","root_id":"'.$data.'","root_label":"'.$data.'","type":"url","imageurl":"/img/icon/url.png","title":"Github官方API获取到的结果","raw_data":"","edge_color":"yellow","edge_label":"Github API"},';
    break;
case 'twitter_username':    
case 'name':
case 'login':  
    echo '{"from_id":"'.$username.'","root_id":"'.$data.'","root_label":"'.$data.'","type":"username","imageurl":"/img/icon/username.png","title":"Github官方API获取到的结果","raw_data":"","edge_color":"yellow","edge_label":"Github API"},';
break;  
}
}
}
echo '{}]';
?>