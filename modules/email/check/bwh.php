<?php
include '../../../config.php';
// access_by_cookie($config,$_COOKIE);
$url="https://bwh81.net/register.php";
$header=array(
    'Host: bwh81.net'
);
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_HEADER,1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
$output = curl_exec($ch);
curl_close ($ch);
preg_match('/Set-Cookie: WHMCSSQgkVapT0KwS=(.*?);/',$output,$str);
$cookie=$str[1];
preg_match('/type="hidden" name="token" value="(.*?)" \/>/',$output,$str);
$token=$str[1];
$email=$_GET['email'];
$header=array(
    'Host: bwh81.net',
    "Cookie: AUTO_TRANSLATE=; WHMCSSQgkVapT0KwS=$cookie",
    'Accept-Encoding: indentity',
    'Referer: https://bwh81.net/register.php',
    'Content-Type: application/x-www-form-urlencoded',
    ''
    );
$email1=str_replace('@','%40',$_GET['email']);
$data='token='.$token.'&register=true&firstname=fuck&lastname=you&companyname=fuckyou&email='.$email1.'&password=fuckyou&password2=fuckyou&address1=fuckyou&address2=fuckyou&city=fuckyou&state=Louisiana&postcode=fuckyou&country=US&phonenumber=111000111&accepttos=on&g-recaptcha-response=';
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER,1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
$output = curl_exec($ch);
curl_close ($ch);
/* echo $output;
echo '<br>'; */
if(preg_match_all('/(A user already exists with that email address)/',$output,$str))
{
    echo '[{"from_id":"'.$email.'","root_id":"registed:bwh.com","root_label":"registed:bwh.com","type":"registed","imageurl":"/img/icon/registed.png","title":"注册了搬瓦工，一个便宜的VPS购买网站","raw_data":"","edge_color":"orange","edge_label":"注册枚举"}]';

}
else 
{
  echo '[{}]';
}
?>