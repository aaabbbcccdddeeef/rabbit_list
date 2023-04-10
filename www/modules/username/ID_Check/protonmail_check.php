<?php
include '../../../config.php';
// access_by_cookie($config,$_COOKIE);
$username=$_GET['username'];
$email=$username.'@protonmail.ch';
$url="https://api.protonmail.ch/pks/lookup?op=index&search=$email";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$output_data = curl_exec($ch);
curl_close ($ch);
preg_match_all('/uid:(.*@protonmail.ch )/',$output_data,$result);
echo ",".(str_replace(' ','',$result[1][0]));
preg_match_all('/::([0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9])::/',$output_data,$result);
if(!empty($result))
{
    echo ",注册时间: ".$result[1][0];
}
?>