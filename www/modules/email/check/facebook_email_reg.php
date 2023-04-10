<?php
include '../../../config.php';
// access_by_cookie($config,$_COOKIE);
$email=str_replace('@','%40',$_GET['email']);
// echo "loading...";
function get_datr()
{
    $url="https://mbasic.facebook.com/login/identify/?ctx=recover&c&multiple_results=0&from_login_screen=0&_rdr";
    $header=array(
        'Host: mbasic.facebook.com',
        ''
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_HEADER,1);
    curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0);
    $output_data=curl_exec($ch);
    curl_close($ch);
    preg_match('/Set-Cookie:(.*);/iU',$output_data,$str); 
    // echo $str[1];
    // echo "1";
    return $str[1];
}
function get_lsd($email,$cookie8)
{
    // echo 'cookie='.$cookie;
    $url="https://mbasic.facebook.com/login/identify/?ctx=recover&c=%2Flogin%2F&search_attempts=1&alternate_search=0&show_friend_search_filtered_list=0&birth_month_search=0&city_search=0";
    $header=array(
    'Host: mbasic.facebook.com',
    "Cookie: $cookie8",
    'User-Agent: Mozilla/5.0 (X11; CrOS x86_64 14794.0.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5045.0 Safari/537.36',
    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
    'Accept-Language: zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
    'Accept-Encoding: identity',
    'Referer: https://mbasic.facebook.com/login/identify/?ctx=recover&c&multiple_results=0&from_login_screen=0&_rdr',
    'Content-Type: application/x-www-form-urlencoded',
    'Origin: https://mbasic.facebook.com',
    'Dnt: 1',
    'Upgrade-Insecure-Requests: 1',
    'Sec-Fetch-Dest: document',
    'Sec-Fetch-Mode: navigate',
    'Sec-Fetch-Site: same-origin',
    'Sec-Fetch-User: ?1',
    'Sec-Ch-Ua-Platform: "Chromium OS"',
    'Sec-Ch-Ua: "Google Chrome";v="103", "Chromium";v="103", "Not=A?Brand";v="24"',
    'Sec-Ch-Ua-Mobile: ?0',
    'Te: trailers',
    ''
    );
    $post="lsd=&email=$email&did_submit=%E6%90%9C%E7%B4%A2";
    $ch=curl_init();
   // echo "start: \n";
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_HEADER,1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0);
    $output_data=curl_exec($ch);
   // echo "end: \n";
    curl_close($ch);
    preg_match('/<input type=\"hidden\" name=\"lsd\" value=\"(.*)\" autocomplete=\"off\" \/>/iU',$output_data,$str); 
   // echo '2';
    return $str[1];
}
function get_cookie($email,$cookie9,$lsd)
{
    // echo 'cookie='.$cookie;
    $url="https://mbasic.facebook.com/login/identify/?ctx=recover&c=%2Flogin%2F&search_attempts=1&alternate_search=0&show_friend_search_filtered_list=0&birth_month_search=0&city_search=0";
    $header=array(
    'Host: mbasic.facebook.com',
    "Cookie: $cookie9",
    'User-Agent: Mozilla/5.0 (X11; CrOS x86_64 14794.0.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5045.0 Safari/537.36',
    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
    'Accept-Language: zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
    'Accept-Encoding: identity',
    'Referer: https://mbasic.facebook.com/login/identify/?ctx=recover&c&multiple_results=0&from_login_screen=0&_rdr',
    'Content-Type: application/x-www-form-urlencoded',
    'Origin: https://mbasic.facebook.com',
    'Dnt: 1',
    'Upgrade-Insecure-Requests: 1',
    'Sec-Fetch-Dest: document',
    'Sec-Fetch-Mode: navigate',
    'Sec-Fetch-Site: same-origin',
    'Sec-Fetch-User: ?1',
    'Sec-Ch-Ua-Platform: "Chromium OS"',
    'Sec-Ch-Ua: "Google Chrome";v="103", "Chromium";v="103", "Not=A?Brand";v="24"',
    'Sec-Ch-Ua-Mobile: ?0',
    'Te: trailers',
    ''
    );
    $post="lsd=$lsd&email=$email&did_submit=%E6%90%9C%E7%B4%A2";
    $ch=curl_init();
   // echo "start: \n";
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_HEADER,1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0);
    $output_data=curl_exec($ch);
   // echo "end: \n";
    curl_close($ch);
    preg_match_all('/Set-Cookie:(.*);/iU',$output_data,$str); 
   // echo $output_data;
   // var_dump($str);
    $result=$str[1][0]."; ".$str[1][1];
   //  echo "Cookie: ".$result;
   // echo "3";
    return $result;
}

function check_email($email)
{
$cookie0=get_datr();
$lsd1=get_lsd($email,$cookie0);
// $url="https://enevijs9metm.x.pipedream.net";
$url="https://mbasic.facebook.com/login/device-based/ar/login/?ldata=F&refsrc=deprecated&_rdr";
$cookie1=get_cookie($email,$cookie0,$lsd1);
$header=array(
'Host: mbasic.facebook.com',
"Cookie: $cookie1",
'User-Agent: Mozilla/5.0 (X11; CrOS x86_64 14794.0.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5045.0 Safari/537.36',
'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
'Accept-Language: zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
'Accept-Encoding: identity',
'Referer: https://mbasic.facebook.com/login/identify/?ctx=recover',
'Dnt: 1',
'Upgrade-Insecure-Requests: 1',
'Sec-Fetch-Dest: document',
'Sec-Fetch-Mode: navigate',
'Sec-Fetch-Site: same-origin',
'Sec-Fetch-User: ?1',
'Sec-Ch-Ua-Platform: "Chromium OS"',
'Sec-Ch-Ua: "Google Chrome";v="103", "Chromium";v="103", "Not=A?Brand";v="24"',
'Sec-Ch-Ua-Mobile: ?0',
'Te: trailers',
''
);
$ch=curl_init();
 curl_setopt($ch, CURLOPT_URL, $url);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
 curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
 curl_setopt($ch, CURLOPT_HEADER,1);
 curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0);
 $output_data=curl_exec($ch);
 curl_close($ch);
 // echo "4";
 if(preg_match_all('/(请选择获取密码重置验证码的方式。)/',$output_data,$str))
 {
   // var_dump($str);
   echo 'true';
 }
 else 
 {
    echo 'false';
 } 
}
echo (check_email($email,$cookie));
?>