<?php
include '../../../config.php';
// access_by_cookie($config,$_COOKIE);
# 输入变量
$email=$_GET['email'];
$email1=str_replace('@','%40',$_GET['email']);
$url="https://passport.baidu.com/v2/api/?logincheck&token=&tpl=netdisk&subpro=netdisk_web&apiver=v3&tt=&sub_source=leadsetpwd&username=$email1&loginversion=v4&dv=";
$header=array(
'Host: passport.baidu.com',
'Cookie: newlogin=1;',
'User-Agent: Mozilla/5.0 (X11; CrOS x86_64 14794.0.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5045.0 Safari/537.36',
'Accept: */*',
'Accept-Language: zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
'Accept-Encoding: indentity',
'Dnt: 1',
'Referer: https://pan.baidu.com/',
''
);
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
# ssl 认证
/* curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0); */
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
$output = curl_exec($ch);
if (curl_error($ch)) {
echo '[{}]';
exit;
}
curl_close ($ch);
foreach(json_decode($output) as $a => $b)
{
    if($a=='data')
    {
        foreach($b as $c => $d)
        {
            if($c=='isconnect')
            {
                if($d=='1')
                {
                echo '[{"from_id":"'.$email.'","root_id":"registed:baidu.com","root_label":"registed:baidu.com","type":"registed","imageurl":"/img/icon/registed.png","title":"test","raw_data":"","edge_color":"yellow","edge_label":"注册枚举"}]';
                exit;
                }
            }
        }
    }
}
echo '[{}]';