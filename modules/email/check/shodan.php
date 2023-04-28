<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
function getfrist_s()
{
    $url='https://account.shodan.io/register';
    $header=array(
'Host: account.shodan.io'
    );
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_HEADER,1);
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0);
curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false); 
curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, false); 
$output_data=curl_exec($ch);
curl_close ($ch);

preg_match('/set-Cookie: session=(.*);/iU',$output_data,$str);
$session=$str[1];
echo "$session\n";
return $session;   
}
$email=str_replace('@','%40',$_GET['email']);
    $url='https://account.shodan.io/register';
  //  $session0=getfrist_s();
    $header=array(
'Host: account.shodan.io',
// "Cookie: session=$session0",
'',
    );
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_HEADER,1);
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0);
curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false); 
curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, false); 
$output_data=curl_exec($ch);
curl_close ($ch);

preg_match('/set-Cookie: session=(.*);/iU',$output_data,$str);
$session=$str[1];
preg_match('/csrf_token\"\ value=\"(.*)\" \//iU',$output_data,$str);
$csrf=$str[1];
function check($email1,$session1,$csrf1)
{
    $url='https://account.shodan.io/register';
    $header=array(
'Host: account.shodan.io',
"Cookie: session=$session1",
'Accept-Encoding: indentity',
'Content-Type: application/x-www-form-urlencoded',
''
    );
    $post="username=aefsdrgtfhfgdfvsdc&password=$email1&password_confirm=$email1&email=$email1&csrf_token=$csrf1";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false); 
curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, false); 
$output_data=curl_exec($ch);
curl_close($ch);
// echo $output_data;
preg_match('/(A user with that email address already exists)/',$output_data,$str);
if(!empty($str[1]))
{
    $site="shodan.com";
    echo '[{"from_id":"'.$email.'","root_id":"registed:'.$site.'","root_label":"registed:'.$site.'","type":"registed","imageurl":"/img/icon/registed.png","title":"该邮箱可能注册 '.$site.',通常意味着邮箱主人是红队或者渗透测试人员，其它网安从业者","raw_data":"","edge_color":"orange","edge_label":"注册枚举"}]';
}
else 
{
    echo '[{}]';
}
}
check($email,$session,$csrf);
?>