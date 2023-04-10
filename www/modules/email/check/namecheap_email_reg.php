<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$email=str_replace('@','%40',$_GET['email']);
$url="https://www.namecheap.com/Cart/ajax/Validation.ashx";
$ch = curl_init();
$data="emailToValidate=$email&actionName=nc_signup";
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Host: www.namecheap.com',
    'User-Agent: Mozilla/5.0 (X11; CrOS x86_64 14794.0.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5045.0 Safari/537.36',
    'Accept: application/json, text/javascript, */*; q=0.01',
    'Accept-Language: zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
    'Accept-Encoding:  deflate',
    'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
    'X-Requested-With: XMLHttpRequest',
    'Origin: https://www.namecheap.com',
    'Dnt: 1',
    'Referer: https://www.namecheap.com/myaccount/signup/',
    'Sec-Fetch-Dest: empty',
    'Sec-Fetch-Mode: cors',
    'Sec-Fetch-Site: same-origin',
    'Sec-Ch-Ua-Platform: "Chromium OS"',
    'Sec-Ch-Ua: "Google Chrome";v="103", "Chromium";v="103", "Not=A?Brand";v="24"',
    'Sec-Ch-Ua-Mobile: ?0',
    'Te: trailers'
));
// curl_setopt($ch, CURLOPT_HEADER,1);
$output_data = curl_exec($ch);
curl_close ($ch);
// echo $output_data;
foreach(json_decode($output_data) as $a => $b)
{
    if($a=='IsValid')
    {
    if($b)
    {
        echo 'false';
    }
    else 
    {
        echo 'true';
    }    
    }
}
?>