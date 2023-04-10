<?php
include '../../../config.php';
// access_by_cookie($config,$_COOKIE);
$email=$_GET['email'];
$url="https://github.com/signup?return_to=https%3A%2F%2Fgithub.com%2Fsignup_check%2Femail&source=login";
$header=array(
    'Host: github.com',
    'Accept-Encoding: gzip, deflate',
    'Referer: https://github.com/login?return_to=https%3A%2F%2Fgithub.com%2Fsignup_check%2Femail',
    'Dnt: 1',
    'Upgrade-Insecure-Requests: 1'
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_HEADER,1);
$output_data=curl_exec($ch);
curl_close($ch);
preg_match('/Set-Cookie:(.*);/iU',$output_data,$str);
$cookie=$str[1]; 
preg_match('/<input type=\"hidden\" data-csrf=\"true\" name=\"authenticity_token\" value=\"(.*)\" \/>/iU',$output_data,$str);
$token=$str[1];
function check($email,$token,$cookie)
{
    $url="https://github.com/email_validity_checks"; 
  $header=array(
        'Host: github.com',
        "Cookie: $cookie",
        "Content-Type: multipart/form-data",
        'Referer: https://github.com/login?return_to=https%3A%2F%2Fgithub.com%2Fsignup_check%2Femail',
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
        'authenticity_token' => $token,
        'email' => $email
    );
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
// curl_setopt($ch, CURLOPT_HEADER,1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$output_data=curl_exec($ch);
curl_close($ch);
echo $output_data;
}
check($email,$token,$cookie);
?>