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
// echo $output;
foreach(json_decode($output) as $x => $z)
{
  if($x=='data')  
  {
foreach($z as $a => $b)
{
if($a=='user_id')
{
    echo ",<newnode>,$b,";
}
    if($a=='recovery_contacts')
    {
        foreach($b[0] as $c => $d)
        {
            if($c=='value')
            {
            echo ",$d,";   
            }
        }
    }
}
}
}
?>