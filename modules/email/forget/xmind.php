<?php
include '../../../config.php';
// access_by_cookie($config,$_COOKIE);
$email1=str_replace('@','%40',$_GET['email']);
$email=$_GET['email'];
$url="https://xmind.app/_res/password/$email1/forgot";
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
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$output_data = curl_exec($ch);
if(curl_error($ch))
{
    echo '[{}]';
    exit;
}
curl_close ($ch);
foreach(json_decode($output_data) as $a => $b)
{
    if($a=='username')
    {
    if(empty($b))
    {
        exit;
    }
    else 
    {
        $username=$b;
        echo '{"from_id":"'.$email.'","root_id":"'.$username.'","root_label":"'.$username.'","type":"username","imageurl":"/img/icon/username.png","title":"xmind 找回接口","raw_data":"","edge_color":"yellow","edge_label":"xmind 找回接口"},';
    }
    }
    if($a=='verified_email')
    {
        $email=$b;
        echo '{"from_id":"'.$username.'","root_id":"'.$email.'","root_label":"'.$email.'","type":"email","imageurl":"/img/icon/email.png","title":"xmind 找回接口","raw_data":"","edge_color":"yellow","edge_label":"xmind 找回接口"},';
    }
}
echo '[{}]';
?>
