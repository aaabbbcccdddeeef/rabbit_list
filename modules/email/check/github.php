<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$email=$_GET['email'];

$url="https://github.com/signup?return_to=https%3A%2F%2Fgithub.com%2Fsignup_check%2Femail&source=login";
$header=array(
    'Host: github.com',
   // "Cookie: $cookie1",
   // "Content-Type: multipart/form-data",
    'Referer: https://github.com/signup',
    'Origin: https://github.com',
    'Dnt: 1',
    'Upgrade-Insecure-Requests: 1',
    'Sec-Fetch-Dest: document',
    'Sec-Fetch-Mode: navigate',
    'Sec-Fetch-Site: same-origin',
    'Sec-Fetch-User: ?1',
    'Sec-Ch-Ua-Platform: "Chromium OS"',
    'Sec-Ch-Ua: "Google Chrome";v="103", "Chromium";v="103", "Not=A?Brand";v="24"',
    'Sec-Ch-Ua-Mobile: ?0',
    'Te: trailers',
    ''
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_HEADER,1);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
$output_data=curl_exec($ch);
curl_close($ch);
preg_match('/Set-Cookie:(.*);/iU',$output_data,$str);
$cookie=$str[1]; 
preg_match('/<input type=\"hidden\" data-csrf=\"true\" value=\"(.*)\" \/>/iU',$output_data,$str);
$token=$str[1];
/* echo "frist_cookie: $cookie";
echo "\n";
echo "frist_token: $token";
echo "\n"; */
// $cookie2=getfrist_token($cookie);

function check($email,$token1,$cookie1)
{
    $url="https://github.com/email_validity_checks"; 
  $header=array(
        'Host: github.com',
        "Cookie: $cookie1",
        "Content-Type: multipart/form-data",
        'Referer: https://github.com/signup',
        'Origin: https://github.com',
        'Dnt: 1',
        'Upgrade-Insecure-Requests: 1',
        'Sec-Fetch-Dest: document',
        'Sec-Fetch-Mode: navigate',
        'Sec-Fetch-Site: same-origin',
        'Sec-Fetch-User: ?1',
        'Sec-Ch-Ua-Platform: "Chromium OS"',
        'Sec-Ch-Ua: "Google Chrome";v="103", "Chromium";v="103", "Not=A?Brand";v="24"',
        'Sec-Ch-Ua-Mobile: ?0',
        'Te: trailers',
        ''
    );
    $data=array(
        'authenticity_token' => $token1,
        'value' => $email
    );
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
 curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
 curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
// curl_setopt($ch, CURLOPT_HEADER,1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$output_data=curl_exec($ch);
curl_close($ch);
/* echo "cookie: $cookie1";
echo "\n";
echo "token: $token1";
echo "\n"; */
preg_match('/(Email is invalid or already taken)/',$output_data,$str);
if($str[1])
{
    $site="github.com";
    echo '[{"from_id":"'.$email.'","root_id":"registed:'.$site.'","root_label":"registed:'.$site.'","type":"registed","imageurl":"/img/icon/registed.png","title":"该邮箱可能注册 '.$site.',通常意味着邮箱主人是个开发者,懂IT","raw_data":"","edge_color":"orange","edge_label":"注册枚举"}]';
}
else 
{
    echo '[{}]';
}
}
check($email,$token,$cookie);
?>