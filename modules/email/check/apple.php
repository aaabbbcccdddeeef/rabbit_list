<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$email=$_GET['email'];
$url="https://appleid.apple.com/account";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_HEADER,1);
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Host: appleid.apple.com',
    ''
));
$output_data = curl_exec($ch);
curl_close ($ch);
preg_match("/scnt: (.*?)\n/",$output_data,$str);
$scnt=$str[1];
preg_match('/Set-Cookie: aidsp=(.*?);/',$output_data,$str);
$adisp=$str[1];
preg_match('/"apiKey": "(.*?)",/',$output_data,$str);
$key=$str[1];

$header1=array(
'Host: appleid.apple.com',
'User-Agent: Mozilla/5.0 (X11; CrOS x86_64 14794.0.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5045.0 Safari/537.36',
'Accept: application/json, text/javascript, */*; q=0.01',
'Accept-Language: zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
'Accept-Encoding: identity',
'Referer: https://appleid.apple.com/',
'Content-Type: application/json',
"Scnt: $scnt",
"X-Apple-Id-Session-Id: $adisp",
'X-Apple-Request-Context: create',
"X-Apple-Api-Key: $key",
'X-Apple-I-Fd-Client-Info: {"U":"","L":"zh-CN","Z":"GMT+08:00","V":"1.1","F":""}',
'X-Apple-I-Timezone: Asia/Shanghai',
'X-Requested-With: XMLHttpRequest',
'Origin: https://appleid.apple.com',
'Dnt: 1',
'Sec-Fetch-Dest: empty',
'Sec-Fetch-Mode: cors',
'Sec-Fetch-Site: same-origin',
'Sec-Ch-Ua-Platform: "Chromium OS"',
'Sec-Ch-Ua: "Google Chrome";v="103", "Chromium";v="103", "Not=A?Brand";v="24"',
'Sec-Ch-Ua-Mobile: ?0',
'Te: trailers',
'Connection: close',
''
);
$data='{"type":"IMAGE"}';
$url="https://appleid.apple.com/captcha";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_HEADER,1);
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$output_data = curl_exec($ch);
curl_close ($ch);
preg_match("/scnt: (.*?)\n/",$output_data,$str);
$scnt=$str[1];
$header=array(
    'Host: appleid.apple.com',
    "Cookie: aidsp=$adisp" ,
    'Accept: application/json',
    'Accept-Encoding:indentity',
    'Referer: https://appleid.apple.com/',
    'Content-Type: application/json',
    "Scnt:$scnt",
    'X-Requested-With: XMLHttpRequest',
    ''
    );
$post='{"emailAddress":"'.$email.'"}';
$url="https://appleid.apple.com/account/validation/appleid";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
// curl_setopt($ch, CURLOPT_HEADER,1);
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
// curl_setopt($ch, CURLOPT_HEADER,1);
$output_data = curl_exec($ch);
curl_close ($ch);
foreach(json_decode($output_data) as $a => $b)
{
    if($a=='used')
    {
        if($b)
        {
            echo '[{"from_id":"'.$email.'","root_id":"registed:apple.com","root_label":"registed:apple.com","type":"registed","imageurl":"/img/icon/registed.png","title":"啊氆氇工业垃圾，高消费的电子产品","raw_data":"","edge_color":"orange","edge_label":"注册枚举"}]';
        }
        else 
        {
            echo '[{}]';
        }
    }
}

?>