<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$email=$_GET['email'];
$url="https://auth.services.adobe.com/signin/v2/users/accounts";
$ch = curl_init();
$data=array(
    'username' => $email
);
$payload=json_encode($data);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Host: auth.services.adobe.com',
    'User-Agent: 1',
    'X-Ims-Clientid: SunbreakWebUI1',
    'Content-type: application/json',
));
// curl_setopt($ch, CURLOPT_HEADER,1);
$output_data = curl_exec($ch);
curl_close ($ch);
if(!empty($output_data))
{
    foreach(json_decode($output_data) as $a => $b)
{
       foreach($b as $c => $d)
       {
        if($c=='hasT2ELinked')
        {
        if($d==true)
        {
            echo ',registed:linked,';
        }
       }
    }
        foreach($b as $c => $d)
        {
if($c=='authenticationMethods')
{
    foreach($d as $e)
    {
        foreach($e as $id => $data)
        {
            if($data=='apple')
            {
                echo ',registed:apple,';   
            }
            if($data=='password')
            {
                echo ',registed:adobe,';   
            }
        }
    }
}
        }
    }
}
?>