<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$username=$_GET['username'];
function checkusername($username)
{
    $url="https://vip.tom.com/webmail/register/checkname.action?userName=$username%40vip.tom.com";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    $output_data = curl_exec($ch);
    curl_close ($ch);
    // var_dump($output_data);
    foreach(json_decode($output_data) as $a => $b)
    {
        if($a=='isUserNameExist')
        {
            if($b)
            {
                echo ",$username@vip.tom.com,";
            }
        }
    }
}
checkusername($username);
?>