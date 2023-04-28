<?php
include '../../../config.php';
// access_by_cookie($config,$_COOKIE);
$email=$_GET['email'];
$url="https://xluser-ssl.xunlei.com/aqinfo/v2/FindPwd?csrf_token=&appid=22003&fid=203&account=$email&VERIFY_CODE=&callback=";
$header=array(
    'Host: xluser-ssl.xunlei.com',
    'Cookie: XLA_CI=1; deviceid=1;  track=1; ; creditkey=1; page_source=',
    'Accept-Encoding: indentity',
    ''
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
$output_data=curl_exec($ch);
if(curl_error($ch))
{
    echo '[{}]';
    exit;
}
curl_close($ch);
// echo $output_data;
if(preg_match('/(user_not_exist)/',$output_data,$s))
{
echo '[{}]';
exit;
}
if(preg_match('/(input_verifycode)/',$output_data,$s))
{
    echo '[{}]';
    exit;
}
if(preg_match('/("error":"success")/',$output_data,$s))
{
    echo '[';
    foreach(json_decode($output_data) as $a => $b)
    {
        if($a=='data')
        {
            foreach($b as $c => $d)
            {
                if($c=='mail')
                {
                    if(!empty($d))
                    {
                    echo '{"from_id":"'.$email.'","root_id":"registed:xunlei.com","root_label":"registed:xunlei.com","type":"registed","imageurl":"/img/icon/registed.png","title":"迅雷找回 某下载软件","raw_data":"","edge_color":"yellow","edge_label":"注册枚举"},';    
                    echo '{"from_id":"'.$email.'","root_id":"'.$d.'","root_label":"'.$d.'","type":"unknown","imageurl":"/img/icon/unknown.png","title":"迅雷找回 email","raw_data":"","edge_color":"yellow","edge_label":"找回数据"},';
                    }
                }
                if($c=='mobile')
                {
                    if(!empty($d))
                    {
                    echo '{"from_id":"'.$email.'","root_id":"'.$d.'","root_label":"'.$d.'","type":"unknown","imageurl":"/img/icon/unknown.png","title":"迅雷找回 phone","raw_data":"","edge_color":"yellow","edge_label":"找回数据"},';
                    }
                }
                if($c=='userid')
                {
                    if(!empty($d))
                    {
                    echo '{"from_id":"'.$email.'","root_id":"'.$d.'","root_label":"'.$d.'","type":"unknown","imageurl":"/img/icon/unknown.png","title":"迅雷找回 uid","raw_data":"","edge_color":"yellow","edge_label":"找回数据"},';
                    }
                }
            }
        }
    }
    echo '{}]';
    exit;
}
