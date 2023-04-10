<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$gaode_apikey=getconfig('gaode_apikey',$config);
$ip=$_GET['ip'];
$url="https://restapi.amap.com/v3/ip?ip=$ip&output=json&key=$gaode_apikey";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);
foreach(json_decode($response) as $item => $data)
{
    if($item=='rectangle')
    {
      echo  ",<newnode>,gaode_ip:$ip,";
      echo  'location:['.str_replace(',',':',explode(';',$data)[0]).']';
      echo  ',';
      echo  'location:['.str_replace(',',':',explode(';',$data)[1]).']';
      echo  ",";
    }
}
?>