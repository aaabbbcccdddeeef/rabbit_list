<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$email=$_GET['email'];
$url='https://bbs.huorong.cn/forum.php?mod=ajax&inajax=yes&infloat=register&handlekey=register&ajaxmenu=1&action=checkemail&email='.$email; 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Host: bbs.huorong.cn',
    'Accept-Encoding: identity',
    'X-Requested-With: XMLHttpRequest'
));
// curl_setopt($ch, CURLOPT_HEADER,1);
$output_data = curl_exec($ch);
curl_close ($ch);
// var_dump($output_data);
preg_match_all('/(<root>)(.*)(<\/root>)/',$output_data,$str);
foreach($str as $a => $b)
{
    if($a==2)
    {
foreach($b as $c => $d)
{
    if($d=='<![CDATA[该 Email 地址已被注册]]>')
    {
        $site="huorong.com";
        echo '[{"from_id":"'.$email.'","root_id":"registed:'.$site.'","root_label":"registed:'.$site.'","type":"registed","imageurl":"/img/icon/registed.png","title":"该邮箱可能注册 '.$site.',通常意味着邮箱主人使用火绒杀毒软件","raw_data":"","edge_color":"orange","edge_label":"注册枚举"}]';
        exit;
    }
}
    }
}
echo '[{}]';
?>