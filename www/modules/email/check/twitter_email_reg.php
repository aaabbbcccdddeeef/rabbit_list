<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$email=$_GET['email'];
$url="https://api.twitter.com/i/users/email_available.json?email=$email";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$output_data = curl_exec($ch);
curl_close ($ch);
foreach(json_decode($output_data) as $a => $b)
{
    if($a=='valid')
    {
        if($b)
        {
            echo 'false';
        }
        else 
        {
            echo 'true';
        }
    }
}
?>