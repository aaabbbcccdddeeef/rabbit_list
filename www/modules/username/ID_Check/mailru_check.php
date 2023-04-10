<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$username=$_GET['username'];
$domainlist=['@mail.ru','@bk.ru','@inbox.ru','@list.ru','@internet.ru'];
function checkmail($username1,$domain1)
{
     $url="https://account.mail.ru/api/v1/user/exists";
    $header=array(
     //   'Host: account.mail.ru',
        'Sec-Fetch-Dest: empty',
        'Sec-Fetch-Mode: cors',
        'Content-Type: multipart/form-data'
    );
$data=$username1.$domain1;
$post=array("email" => $data,);
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
        if($c=='exists')
        {
            if($d)
            {
                echo ",$data,";
            }
            break;
        }
    }
}
}
}
}
foreach($domainlist as $domain)
{
    checkmail($username,$domain);
}
?>