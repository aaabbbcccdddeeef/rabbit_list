<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$username=$_GET['username'];
$cookie=getconfig('aiqicha_cookie',$config);
$headers[]='User-Agent: Mozilla/5.0 (X11; CrOS x86_64 14794.0.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5045.0 Safari/537.36';
$headers[]='Accept: application/json, text/plain, */*';
$headers[]='Accept-Language: zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2';
$headers[]='Accept-Encoding: identity';
$headers[]='X-Requested-With: XMLHttpRequest';
$headers[]='Referer: https://aiqicha.baidu.com/s?q=%0';
$headers[]='Sec-Fetch-Dest: empty';
$headers[]='Sec-Fetch-Mode: cors';
$headers[]='Sec-Fetch-Site: same-origin';
$headers[]='Sec-Ch-Ua-Platform: "Chromium OS"';
$headers[]='Sec-Ch-Ua: "Google Chrome";v="103", "Chromium";v="103", "Not=A?Brand";v="24"';
$headers[]='Sec-Ch-Ua-Mobile: ?0';
$headers[]='Te: trailers';
$headers[]='Connection: close';
$q=urlencode($username);
$url="https://aiqicha.baidu.com/person/relevantPersonalAjax?q=$q&page=1&size=64";
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$output = curl_exec($ch);
curl_close ($ch);
foreach(json_decode($output) as $a => $b)
{
    if($a=='data')
    {
        foreach($b as $c => $d)
        {
            if($c=='list')
            {
foreach($d as $person)
{
   foreach($person as $e => $f)
   {
        switch($e)
        {
case 'positionTitle':
$z=$f;
break;   
case 'entName':
echo ",<newnode>,$f,$z";
break;                    
        }
   // var_dump($f);
   // echo '<br>';
   } 
}
            }
        }
    }
}
?>