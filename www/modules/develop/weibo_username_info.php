<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
$username=$_GET['username'];
# url 生成
$cookie='Cookie: '.getconfig('weibo_cookie',$config);
function getuid($username,$cookie)
{
$url = "https://weibo.com/ajax/side/search?q=".urlencode($username);
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$headers = array();
$headers[] = $cookie;
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$output = curl_exec($ch);
curl_close ($ch);
foreach(json_decode($output) as $a => $b)
{
if($a=='users')
{
foreach($b as $user)
{
for($username as $item => $data)
{
switch($item)
{
case 'id':
echo ",<newnode>,$data,";    
break; 
case 'insecurity':
foreach($data as $d => $e)
{
    if($d=='sexual_content')
    {
   if($e==true)
   {
    echo ",色情内容,";
   }     
    }
}    
break; 
case 'screen_name':
case 'name':
case 'location':
case 'description':
case 'verified_reason':
case 'verified_contact_name':
case 'verified_contact_email':
case 'verified_contact_mobile':
case 'ability_tags':
case 'verified_reason_url':
case 'verified_source_url':
case 'verified_source':
case 'domain':
case 'weihao':
echo ",$data,";
break;
}
}
}
}

}
}


function getinfo($uid,$cookie)
{
$url = "https://weibo.com/ajax/profile/detail?uid=".$uid;
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$headers = array();
$headers[] = $cookie;
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$output = curl_exec($ch);
curl_close ($ch);
foreach(json_decode($output) as $a => $b)
{
 switch($a)
 {
 case 'gender':
if($b=='m')
{
echo ',男,';
}
else if($b=='w')
{
echo ',女,';   
} 
  break;
  case 'location':
if($b!='其它'){
echo ",$b,";
}
  break;
  case 'birthday': 
  case 'ip_location':
  echo ",$b,";
 }  
}
}
 getuid($username,$cookie);
// getinfo($uid,$cookie);
exit;





?>