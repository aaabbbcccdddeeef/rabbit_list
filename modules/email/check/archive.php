<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$email=$_GET['email'];
$url="https://archive.org/account/signup";
$headers = array(
    'Host: archive.org',
    'Content-Type: multipart/form-data'
);

// $post='-----------------------------\r\nContent-Disposition: form-data; name="input_name"\r\n\r\nusername\r\n-----------------------------\r\nContent-Disposition: form-data; name="input_value"\r\n\r\n'.$email.'\r\n-----------------------------\r\nContent-Disposition: form-data; name="input_validator"\r\n\r\ntrue\r\n-----------------------------\r\nContent-Disposition: form-data; name="submit_by_js"\r\n\r\ntrue\r\n-------------------------------\r\n';
 
$post=array(
    'input_name'=>'username',
    'input_value'=>$email,
    'input_validator'=>'true',
    'submit_by_js'=>'true'
);


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$output_data=curl_exec($ch);
if(empty($output_data))
{
    echo '[{}]';
    exit;
}
curl_close($ch);
foreach(json_decode($output_data) as $a)
{
foreach($a as $c => $d)
{
    if($c=='status')
    {
        if($d)
        {
            echo '[{}]';
        }
        else
        {
           $site="archive.com";
           echo '[{"from_id":"'.$email.'","root_id":"registed:'.$site.'","root_label":"registed:'.$site.'","type":"registed","imageurl":"/img/icon/registed.png","title":"该邮箱可能注册 '.$site.',通常意味着邮箱主人可能是网安从业者或者开源情报调查人员","raw_data":"","edge_color":"orange","edge_label":"注册枚举"}]';
        }
    }
}
}
?>
