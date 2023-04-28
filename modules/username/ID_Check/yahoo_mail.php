<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$username=$_GET['username'];
function getcookie()
{
$url="https://login.yahoo.com/account/create?";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_HEADER,1);
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0); 
$output_data = curl_exec($ch);
curl_close ($ch);
preg_match('/Set-Cookie:(.*);/iU',$output_data,$str);
return $str[1];
}
// getcookie();
function check($username,$domain)
{
    $url="https://login.yahoo.com/account/module/create?validateField=userId";
    $cookie=getcookie();
    preg_match('/AS=v=1&s=(.*)$/iU',$cookie,$str);
    $s=$str[1];
    $header=array(
        'Host: login.yahoo.com',
        "Cookie: $cookie",
        'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
        'X-Requested-With: XMLHttpRequest'
    );
    $post="&specId=yidregsimplified&cacheStored=&crumb=&acrumb=$s&sessionIndex=&done=&googleIdToken=&authCode=&attrSetIndex=0&specData=&multiDomain=&tos0=oath_freereg%7Ctw%7Czh-Hant-TW&firstName=&lastName=&userid-domain=yahoo&userId=$username&yidDomainDefault=$domain&yidDomain=$domain&password=&birthYear=&signup=";
    $ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
$output_data=curl_exec($ch);
if (curl_error($ch)) {
    echo '{}]';
    exit;
}
curl_close($ch);
// echo $output_data;
foreach(json_decode($output_data) as $a => $b)
{
    if($a=='errors')
    {
        foreach($b as $c)
        {
            foreach($c as $d => $e)
            {
                if($e=='IDENTIFIER_EXISTS')
                {
                    echo '{"from_id":"'.$username.'","root_id":"'.$username.'@'.$domain.'","root_label":"'.$username.'@'.$domain.'","type":"email","imageurl":"/img/icon/email.png","title":"通过yahoomail的接口枚举证实存在该邮箱","edge_color":"blue","edge_label":"用户名枚举邮箱"},';    
               // echo ",$username@$domain,";    
                return;
                }
            }
{

}       
 }
    }
}
}
$list=['yahoo.com','myyahoo.com'];
echo '[';
foreach($list as $z)
{
    check($username,$z);
}
echo "{}]";
?>