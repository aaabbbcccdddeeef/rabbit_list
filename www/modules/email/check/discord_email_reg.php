<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$email=$_GET['email'];
$url="https://discord.com/api/v8/auth/register";
$post='{"fingerprint":"","email":"'.$email.'","username":"username123","password":"p@sword233","invite":null,"consent":true,"date_of_birth":"","gift_code_sku_id":null,"captcha_key":null}';
$headers=array(
    'HOST: discord.com',
    'Accept: */*',
    'Accept-Language: en-US',
    'Content-Type: application/json',
    'Origin: https://discord.com',
    'DNT: 1',
    'Connection: keep-alive',
    'TE: Trailers'
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$output_data=curl_exec($ch);
curl_close($ch);
// echo $output_data;
foreach(json_decode($output_data) as $a => $b)
{
    if($a=='errors')
    {
        foreach($b as $c => $d )
        {
            if($c=='email')
            {
                foreach($d as $e => $f)
                {
                    if($e=='_errors')
                    {
                      foreach($f as $g)
                      {
foreach($g as $h => $i)
{
    if($h=='code')
    {
        if($i=='EMAIL_ALREADY_REGISTERED')
        {
            echo "ture";
            exit;
        }
    }
}
                      }  
                    }
                }
            }
        }
    }
}
echo 'false';
?>