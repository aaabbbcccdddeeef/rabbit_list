<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$email=str_replace('@','%40',$_GET['email']);
$url="https://account.mail.ru/api/v1/user/password/restore";
$header=array(
    'Host: account.mail.ru',
    'Accept: application/json, text/plain, */*'
);
$post="email=$email&htmlencoded=false";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
$output_data=curl_exec($ch);
curl_close($ch);
foreach(json_decode($output_data) as $a => $b)
{
    if($a=='body')
    {
        if($b)
        {
            foreach($b as $c => $d)
            {
                if($c=='phones')
                {
foreach($d as $e)
{
    echo ",$e,";
}
                }
            }
        }
    }
}


?>