<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
$phone=$_GET['phone'];
function check($phone1,$mail1)
{
$url='https://passport.88.com/api/uc?func=uc%3Auser.resetPassPrep&sid';
$ch = curl_init(); 
$post_data ="{\"email\":\"$phone1$mail1\"}";

$headers = array();
$headers[] ='Host: passport.88.com';
$headers[] ='Content-Type: text/x-json';
$headers[] ='Build-Target: mail.88.com';
$headers[] ='';
$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
$output = curl_exec($ch);
curl_close ($ch);
foreach(json_decode($output,true) as $a => $b)
{
if($a=='message')
{
if($b=='Success')
{
    echo ",<newnode>,$phone1$mail1,";
}    
}
if($a=='var')
{
    foreach($b as $c => $d)
    {
      if($c=='mobile')
      {
      echo ",$d,";  
      }  
    }
}
}

}


$mail_list=['@email.cn','@111.com','@88.com'];
foreach($mail_list as $mail)
{
    check($phone,$mail); 
   //  echo '<br>';
}

?>
