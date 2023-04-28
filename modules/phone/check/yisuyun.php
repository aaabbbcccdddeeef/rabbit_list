<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
$phone=$_GET['phone'];
$header=array(
    'Host: yisuapi.yisu.com',
'User-Agent: Mozilla/5.0 (X11; CrOS x86_64 14794.0.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5045.0 Safari/537.36',
'Accept: */*',
'Accept-Language: zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
'Accept-Encoding: indentity',
'Dnt: 1',
'Referer: https://www.yisu.com/',
'Sec-Fetch-Dest: script',
'Sec-Fetch-Mode: no-cors',
'Sec-Fetch-Site: same-site',
'Sec-Ch-Ua-Platform: "Chromium OS"',
'Sec-Ch-Ua: "Google Chrome";v="103", "Chromium";v="103", "Not=A?Brand";v="24"',
'Sec-Ch-Ua-Mobile: ?0',
'Te: trailers',
'Connection: close',
'',
);
$url='https://yisuapi.yisu.com/index.php/Speed/Uc/checkExistsUser/?callback=&name='.$phone;
$ch = curl_init();
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$output = curl_exec($ch);
curl_close ($ch);
if($output=='(0);')
{
echo '[{}]';
}
else if($output=='(1);')
{
    echo '[{"from_id":"'.$phone.'","root_id":"registed:yisuyun.com","root_label":"redsited:yisuyun.com","type":"registed","imageurl":"/img/icon/registed.png","title":"该号码注册了yisuyun,可能是个站长,开发者等等","raw_data":"","edge_color":"orange","edge_label":"注册枚举"}]';
}

?>