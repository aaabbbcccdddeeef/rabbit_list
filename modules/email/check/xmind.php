<?php
include '../../../config.php';
// access_by_cookie($config,$_COOKIE);
$email1=str_replace('@','%40',$_GET['email']);
$email=$_GET['email'];
$url="https://xmind.app/_res/check_account/$email1";
$ua=random_int(1,65535);
$header=array(
'Host: xmind.app',
"User-Agent: $ua",
'Accept: */*',
'Accept-Encoding: gzip, deflate',
'X-Requested-With: XMLHttpRequest',
''
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0); 
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
$output_data = curl_exec($ch);
if(curl_error($ch))
{
    echo '[{}]';
    exit;
}
curl_close ($ch);
foreach(json_decode($output_data) as $a => $b)
{
    if($a=='_code')
    {
        if($b==200)
        {
            echo '[{"from_id":"'.$email.'","root_id":"registed:xmind.com","root_label":"registed:xmind.com","type":"registed","imageurl":"/img/icon/registed.png","title":"xmind 注册接口,思维导图软件","raw_data":"","edge_color":"yellow","edge_label":"注册枚举"}]';
            exit;
        }
    }
}
echo '[{}]';
?>
