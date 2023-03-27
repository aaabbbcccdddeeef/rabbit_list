<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$username=$_GET['username'];
$list=['vip.163.com','vip.126.com','188.com'];
function testemail($username,$domain)
{
$url="https://reg1.vip.163.com/newReg1/api/checkUsername.m";
$data="username=$username&domain=$domain";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$headers = array();
$headers[] = 'Host: reg1.vip.163.com';
$headers[] = 'Accept: application/json, text/plain, */*';
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$output_data = curl_exec($ch);
curl_close ($ch);
// echo $output_data;
// echo '<br>';
foreach(json_decode($output_data) as $a => $b)
{
    if($a=='result')
    {
        foreach($b as $c => $d)
        {
            if($c=='valid')
            {
               //  var_dump($d);
                if($d==false)
                {
                    echo ",$username@$domain,";
                }
            }
        }
    }
}
}
foreach($list as $domain)
{
    testemail($username,$domain);
}

?>