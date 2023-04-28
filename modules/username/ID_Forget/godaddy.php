<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
$username=$_GET['username'];
$url="https://sso.godaddy.com/v1/api/idp/recovery/password/?username=$username&app=dashboard.api";
$ch = curl_init(); 
$headers = array();
$headers[] ='Host: sso.godaddy.com';
$headers[] ='Accept-Encoding: deflate';
$headers[] ='Content-Type: application/json';
$headers[] ='';
$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
$output = curl_exec($ch);
curl_close ($ch);
/* echo $output;
echo "\n"; */
foreach(json_decode($output) as $x => $z)
{
  if($x=='data')  
  {
foreach($z as $a => $b)
{
if($a=='user_id')
{
    $uid=$b;
}
    if($a=='recovery_contacts')
    {
        foreach($b[0] as $c => $d)
        {
            if($c=='value')
            {
            $email=$d;   
            }
        }
    }
}
}
}
if(!empty($uid))
{
echo '[{"from_id":"'.$username.'","root_id":"'.$email.'","root_label":"'.$email.'","type":"unknown","imageurl":"/img/icon/unknown.png","title":"Godaddy 找回接口返回数据\n,uid:'.$uid.'","raw_data":"","edge_color":"green","edge_label":"用户名找回信息"}]';
}
?>