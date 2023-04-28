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
if (curl_error($ch)) {
    echo '[]';
    exit;
}
curl_close ($ch);
// var_dump($output);
echo '[';
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
            echo '{"from_id":"'.$phone.'","root_id":"registed:支付宝","root_label":"registed:支付宝","type":"registed","imageurl":"/img/icon/registed.png","title":"该号码可能注册了 微店 并 绑定了 支付宝","raw_data":"","edge_color":"yellow","edge_label":"注册枚举"},';   
        break; 
        case 'registed':
            echo '{"from_id":"'.$phone.'","root_id":"registed:微店","root_label":"registed:微店","type":"registed","imageurl":"/img/icon/registed.png","title":"该号码可能注册了 微店 并 绑定了 支付宝","raw_data":"","edge_color":"yellow","edge_label":"注册枚举"},';  
        break;
        case 'qqRegisted':
            echo '{"from_id":"'.$phone.'","root_id":"registed:QQ","root_label":"registed:QQ","type":"registed","imageurl":"/img/icon/registed.png","title":"该号码可能注册了 微店 并 绑定了 QQ","raw_data":"","edge_color":"yellow","edge_label":"注册枚举"},';       
        break;
        case 'touTiaoRegisted':
            echo '{"from_id":"'.$phone.'","root_id":"registed:今日头条","root_label":"registed:今日头条","type":"registed","imageurl":"/img/icon/registed.png","title":"该号码可能注册了 微店 并 绑定了 今日头条","raw_data":"","edge_color":"yellow","edge_label":"注册枚举"},';     
        break;
        case 'weiboRegisted':
            echo '{"from_id":"'.$phone.'","root_id":"registed:微博","root_label":"registed:微博","type":"registed","imageurl":"/img/icon/registed.png","title":"该号码可能注册了 微店 并 绑定了 微博","raw_data":"","edge_color":"yellow","edge_label":"注册枚举"},';     
        break;
        case 'meituRegisted':
            echo '{"from_id":"'.$phone.'","root_id":"registed:美图秀秀","root_label":"registed:美图秀秀","type":"registed","imageurl":"/img/icon/registed.png","title":"该号码可能注册了 微店 并 绑定了 美图秀秀","raw_data":"","edge_color":"yellow","edge_label":"注册枚举"},';     
        break;
        case 'wechatRegisted':
            echo '{"from_id":"'.$phone.'","root_id":"registed:微信","root_label":"registed:微信","type":"registed","imageurl":"/img/icon/registed.png","title":"该号码可能注册了 微店 并 绑定了 微信","raw_data":"","edge_color":"yellow","edge_label":"注册枚举"},';     
        break;                                                   
        }    
        }
    }    
    }
}
echo '{}]';
?>