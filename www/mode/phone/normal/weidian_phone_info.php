<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
$phone=$_GET['phone'];
$url="https://sso.weidian.com/user/bindcheck";
$post="phone=$phone&countryCode=86&ua=1";
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
$output = curl_exec($ch);
curl_close ($ch);

// var_dump($output);
foreach(json_decode($output) as $a => $b)
{
    if($a=='result')
    {
    foreach($b as $c => $d)
    {
        if($d==1)
        {
        switch($c)
        {
        case 'alipayRegisted':
        echo ',registed:alipay';   
        break; 
        case 'registed':
        echo ',registed:weidian'; 
        break;
        case 'qqRegisted':
        echo ',registed:qq';     
        break;
        case 'touTiaoRegisted':
        echo ',registed:toutiao';     
        break;
        case 'weiboRegisted':
        echo ',registed:weibo';     
        break;
        case 'meituRegisted':
        echo ',registed:meitu';     
        break;
        case 'wechatRegisted':
        echo ',registed:wechat';     
        break;                                                   
        }    
        }
    }    
    }
}

?>