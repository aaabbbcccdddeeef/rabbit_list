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
if (curl_errno($ch)) {
    echo '{}]';
    exit;
}
// echo $output_data;
// echo '<br>';
foreach(json_decode($output_data) as $a => $b)
{
    if($a=='result')
    {
        if($b)
        {
        foreach($b as $c => $d)
        {
            if($c=='valid')
            {
               //  var_dump($d);
                if($d==false)
                {
                    $email=$username.'@'.$domain;
                    echo '{"from_id":"'.$username.'","root_id":"'.$email.'","root_label":"'.$email.'","type":"email","imageurl":"/img/icon/email.png","title":"通过网易的接口枚举证实存在该邮箱","edge_color":"blue","edge_label":"用户名枚举邮箱"},';
                }
            }
        }
    }
    }
}
}
echo '[';
foreach($list as $domain)
{
    testemail($username,$domain);
}
echo '{}]';
?>