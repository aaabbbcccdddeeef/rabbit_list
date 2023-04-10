<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$email=$_GET['email'];
function getcsrf()
{
$url="https://www.instagram.com/accounts/emailsignup/";
$headers=array(
    'Host: www.instagram.com',
    'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.9999.0 Safari/537.36',
    'Accept: application/json, text/plain, */*',
    'Accept-Language: en-US,en;q=0.5',
    'Origin: https://www.instagram.com',
    'DNT: 1',
    'Connection: keep-alive'
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
// curl_setopt($ch, CURLOPT_HEADER,1);
$output_data=curl_exec($ch);
curl_close($ch);
// echo $output_data;
preg_match_all('/\"raw\":\"{\\\"config\\\":{\\\"csrf_token\\\":\\\"(.*)\\\",\\\"viewer\\\":null,\\\"viewerId\\\":null},\\\"country_code\\\":\\\"/',$output_data,$result);
return $result[1][0];
}

function check($email)
{
    $token=getcsrf();
    $url="https://www.instagram.com/api/v1/web/accounts/web_create_ajax/attempt/";
    $post="email=$email&username=&first_name=&opt_into_one_tap=false";
    $headers=array(
        'Host: www.instagram.com',
        "X-Csrftoken: $token",
        'Content-Type: application/x-www-form-urlencoded',
        'Accept-Encoding: identity'
    );
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0);
// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
// curl_setopt($ch, CURLOPT_HEADER,1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
$output_data=curl_exec($ch);
curl_close($ch);
// echo $output_data;
// echo "\n";
foreach(json_decode($output_data) as $a => $b )
{
    if($a=='errors')
    {
        foreach($b as $c => $d)
        {
            if($c=='email')
            {
    foreach($d as $z)
    {
        foreach($z as $e => $f) 
        {
            if($f=='email_is_taken')
            {
            echo 'true';
            return ;    
            }    
        }    
    }   
            }
        }
    }
}
echo 'false';
}
// getcsrf();
check($email);
?>