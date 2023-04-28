<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$email=$_GET['email'];
$url="https://login.live.com/login.srf";
$headers = array(
    'Host: login.live.com',
    'User-Agent: Mozilla/5.0 (X11; CrOS x86_64 14794.0.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5045.0 Safari/537.36',
    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
    'Accept-Language: zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
    'Accept-Encoding: indentity',
    'Dnt: 1',
    'Upgrade-Insecure-Requests: 1',
    'Sec-Fetch-Dest: document',
    'Sec-Fetch-Mode: navigate',
    'Sec-Fetch-Site: none',
    'Sec-Fetch-User: ?1',
    'Sec-Ch-Ua-Platform: "Chromium OS"',
    'Sec-Ch-Ua: "Google Chrome";v="103", "Chromium";v="103", "Not=A?Brand";v="24"',
    'Sec-Ch-Ua-Mobile: ?0',
    'Te: trailers',
    'Connection: close',
    ''
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_HEADER,1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$output_data=curl_exec($ch);
curl_close($ch);
preg_match('/Set-Cookie: MSPOK=(.*); /',$output_data,$str);
$mspok='MSPOK='.$str[1];
preg_match('/input type="hidden" name="PPFT" id="i0327" value="(.*)"\/>/',$output_data,$str);   
$flowToken=$str[1];
function check($email,$mspok,$flowToken)
{
    $url="https://login.live.com/GetCredentialType.srf?opid=1&id=1&cobrandid=&id=&mkt=ZH-CN&lc=2052&uaid=1&client_flight=ReservedFlight33,ReservedFligh";
$headers=array(
'Host: login.live.com',
"Cookie: $mspok",
'User-Agent: Mozilla/5.0 (X11; CrOS x86_64 14794.0.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5045.0 Safari/537.36',
'Accept: application/json',
'Accept-Language: zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
'Accept-Encoding: gzip, deflate',
'Referer: https://login.live.com/login.srf',
'Content-Type: application/json; charset=utf-8',
'Origin: https://login.live.com',
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
$post='{"username":"'.$email.'","uaid":"","isOtherIdpSupported":false,"checkPhones":false,"isRemoteNGCSupported":true,"isCookieBannerShown":false,"isFidoSupported":false,"forceotclogin":false,"otclogindisallowed":false,"isExternalFederationDisallowed":false,"isRemoteConnectSupported":false,"federationFlags":3,"isSignup":false,"flowToken":"'.$flowToken.'"}';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$output_data=curl_exec($ch);
curl_close($ch);
/* echo $output_data;
echo '<br>'; */
foreach(json_decode($output_data) as $a => $b)
{
    if($a=='IfExistsResult')
    {
        if($b==0)
        {
            $site='skype.com';
            echo '[{"from_id":"'.$email.'","root_id":"registed:'.$site.'","root_label":"registed:'.$site.'","type":"registed","imageurl":"/img/icon/registed.png","title":"该邮箱可能注册 '.$site.',通常意味着邮箱主人注册了Skype账号","raw_data":"","edge_color":"orange","edge_label":"注册枚举"}]'; 
        }
        else if($b==1) 
        {
            echo '[{}]';
        }
    }
}
}
check($email,$mspok,$flowToken);
?>