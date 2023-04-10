<?php
include '../../../config.php';
// access_by_cookie($config,$_COOKIE);
$email=$_GET['email'];
function gettoken()
{
$headers=array(
    'Host: signup.ebay.com',
    'User-Agent: Mozilla/5.0 (X11; CrOS x86_64 14794.0.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5045.0 Safari/537.36',
    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
    'Accept-Language: zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
    'Accept-Encoding: identity',
    'Referer: https://www.ebay.com/',
   // 'Dnt: 1',
   // 'Upgrade-Insecure-Requests: 1',
   // 'Sec-Fetch-Dest: document',
   // 'Sec-Fetch-Mode: navigate',
   // 'Sec-Fetch-Site: same-site',
   // 'Sec-Fetch-User: ?1',
   // 'Sec-Ch-Ua-Platform: "Chromium OS"',
   // 'Sec-Ch-Ua: "Google Chrome";v="103", "Chromium";v="103", "Not=A?Brand";v="24"',
   // 'Sec-Ch-Ua-Mobile: ?0',
   // 'Te: trailers'
   ''
);    
// $url="https://enevijs9metm.x.pipedream.net";
 $url="https://signup.ebay.com/pa/crte?ru=https%3A%2F%2Fwww.ebay.com%2F";
 $ch=curl_init();
 curl_setopt($ch, CURLOPT_URL, $url);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
 // curl_setopt($ch, CURLOPT_POST, 1);
 // curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
 // curl_setopt($ch, CURLOPT_HEADER,1);
 // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0);
 curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
 $output_data=curl_exec($ch);
 curl_close($ch);
 $reg='/\"fieldValidationCSRFToken\":(.*)\"fieldValidationCSRFToken\":/iU';
preg_match_all($reg,$output_data,$str);
// var_dump($str[1][4]);
preg_match_all('/\"(.*)\",\"submitCSRFToken\":\"/iU',$str[1][4],$result);
return $result[1][0];
}
function check($email)
{
    $url='https://signup.ebay.com/ajax/validatefield';
    $headers=array(
    'Host: signup.ebay.com',
    'User-Agent: Mozilla/5.0 (X11; CrOS x86_64 14794.0.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5045.0 Safari/537.36',
    'Accept: application/json',
    'Accept-Language: zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
    'Accept-Encoding: gzip, deflate',
    'Content-Type: application/json',
    'X-Ebay-Requested-With: XMLHttpRequest',
    'Origin: https://signup.ebay.com',
    'Dnt: 1',
    'Referer: https://signup.ebay.com/pa/crte?ru=https%3A%2F%2Fwww.ebay.com%2F',
    'Sec-Fetch-Dest: empty',
    'Sec-Fetch-Mode: cors',
    'Sec-Fetch-Site: same-origin',
    'Sec-Ch-Ua-Platform: "Chromium OS"',
    'Sec-Ch-Ua: "Google Chrome";v="103", "Chromium";v="103", "Not=A?Brand";v="24"',
    'Sec-Ch-Ua-Mobile: ?0',
    'Te: trailers'
    );
    $token=gettoken();
    $data=array(
        "fieldName" => "email",
        "email" => "$email",
        "srt" => "$token",
        "moduleName" => "PARTIAL_REG_PERSONAL_EMAIL"
    );
    $ch=curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    // curl_setopt($ch, CURLOPT_HEADER,1);
    // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $output_data=curl_exec($ch);
    curl_close($ch);
    echo $output_data;
}
check($email);
?>