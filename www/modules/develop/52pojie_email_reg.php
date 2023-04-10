<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$email=$_GET['email'];
$url='https://www.52pojie.cn/forum.php?mod=ajax&inajax=yes&infloat=register&handlekey=register&ajaxmenu=1&action=checkemail&email='.$email; 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Host: www.52pojie.cn',
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
    var_dump($b);
    echo '<br>';
    if($a==2)
    {
foreach($b as $c => $d)
{
    if($d=='<![CDATA[succeed]]>')
    {
        echo 'false';
        exit;
    }
}
    }
}
echo 'true';
?>