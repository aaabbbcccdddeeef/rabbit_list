<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$email=$_GET['email'];
$url="https://login.microsoftonline.com/common/GetCredentialType?mkt=zh-CN";
$headers = array(
    'Host: login.microsoftonline.com',
    'Content-Type: application/json;'
);

$post='{"username":"'.$email.'","isOtherIdpSupported":true,"checkPhones":false,"isRemoteNGCSupported":true,"isCookieBannerShown":false,"isFidoSupported":false,"originalRequest":"","country":"CN","forceotclogin":false,"isExternalFederationDisallowed":false,"isRemoteConnectSupported":false,"federationFlags":0,"isSignup":false,"flowToken":"","isAccessPassSupported":true}';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$output_data=curl_exec($ch);
curl_close($ch);
foreach(json_decode($output_data) as $a => $b)
{
    if($a=='IfExistsResult')
    {
        if($b=='1')
        {
            echo '[{}]';
            exit;
        }
        else if($b=='5')
        {
            $site="mircosoft.com";
            echo '[{"from_id":"'.$email.'","root_id":"registed:'.$site.'","root_label":"registed:'.$site.'","type":"registed","imageurl":"/img/icon/registed.png","title":"该邮箱可能注册 '.$site.',通常意味着邮箱主人注册了微软账号","raw_data":"","edge_color":"orange","edge_label":"注册枚举"}]'; 
            /*  echo '<br>';
            echo $output_data; */
            exit;
        }
    }
}

?>