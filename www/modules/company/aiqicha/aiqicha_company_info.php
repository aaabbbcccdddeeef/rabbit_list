<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$company=$_GET['company'];
$q=urlencode($company);
$cookie=getconfig('aiqicha_cookie',$config);
$headers[]='Host: aiqicha.baidu.com';
$headers[]="Cookie: $cookie";
$headers[]='User-Agent: Mozilla/5.0 (X11; CrOS x86_64 14794.0.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5045.0 Safari/537.36';
$headers[]='Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8';
$headers[]='Accept-Language: zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2';
$headers[]='Accept-Encoding: identity';
// $headers[]='Content-Type: application/x-www-form-urlencoded';
// $headers[]='X-Requested-With: XMLHttpRequest';
$headers[]="Referer: https://aiqicha.baidu.com/s?q=$q&t=0";
// $headers[]='Origin: https://aiqicha.baidu.com';
$headers[]='Dnt: 1';
$headers[]='Upgrade-Insecure-Requests: 1';
$headers[]='Sec-Fetch-Dest: document';
$headers[]='Sec-Fetch-Mode: navigate';
$headers[]='Sec-Fetch-Site: same-origin';
$headers[]='Sec-Ch-Ua-Platform: "Chromium OS"';
$headers[]='Sec-Ch-Ua: "Google Chrome";v="103", "Chromium";v="103", "Not=A?Brand";v="24"';
$headers[]='Sec-Ch-Ua-Mobile: ?0';
$headers[]='Te: trailers';
$headers[]='Connection: close';
$headers[]="\r\n";
$headers[]='';
// https://aiqicha.baidu.com/s?q=%E6%B2%B3%E5%8D%97%E8%BF%9C%E4%B8%9C%E5%87%BF%E4%BA%95%E5%B7%A5%E7%A8%8B%E6%9C%89%E9%99%90%E5%85%AC%E5%8F%B8&t=0
$url="https://aiqicha.baidu.com/s/advanceFilterAjax?q=$q&t=&p=1&s=100&o=0&f=%7B%22searchtype%22:[%221%22]%7D";
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
// curl_setopt($ch, CURLOPT_POST, 1);
// curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
$output = curl_exec($ch);
curl_close ($ch);
function getcontact($pid,$headers)
{
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, "https://aiqicha.baidu.com/company_detail_$pid");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    // curl_setopt($ch, CURLOPT_POST, 1);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    $output = curl_exec($ch);
    curl_close ($ch);
    
}
foreach(json_decode($output) as $a => $a1)
{
if($a=='data')
{
    foreach($a1 as $b =>$b1)
{
if($b=='resultList')
{
    foreach($b1 as $c)
    {
        foreach($c as $name => $d)
        {
            if(is_string($d))
            {
                switch($name)
                {
                 case 'pid':
                 echo ",<newnode>,$d,"; 
                 break;    
                 case 'domicile':
                 case 'entType':
                 case 'validityFrom':
                 case 'domicile':
                 case 'entLogo':
                 case 'openStatus': 
                 case 'legalPerson':
                 case 'logoWord':
                 case 'titleName':
                 case 'titleLegal':
                 case 'titleDomicile': 
                 case 'regCap':
                 case 'personTitle':              
                 case 'text':                      
                 echo ",$d,";  
                // echo '<br>';
                 break;                     
                }
            }
        }
    }
}
}
}
}
?>