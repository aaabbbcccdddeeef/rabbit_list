<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$email=$_GET['email'];
$url='https://www.ctyun.cn/services/self/RegisterCheck?email='.$email.'&locale=zh-cn';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
$output_data = curl_exec($ch);
curl_close ($ch);
foreach(json_decode($output_data) as $a =>$b)
{
    if($a=='data')
    {
        if($b=='data')
        {
            foreach($b as $c => $d)
            {
                if($c=='msg')
                {
                    if($d=='该邮箱已注册，您可直接登录或更换注册邮箱')
                    {
                        echo '[{"from_id":"'.$email.'","root_id":"registed:ctyun.com","root_label":"registed:ctyun.com","type":"registed","imageurl":"/img/icon/registed.png","title":"注册了天翼云","raw_data":"","edge_color":"orange","edge_label":"注册枚举"}]';
                        exit;
                    }
                }
            }
        }
    }
}
echo '[{}]';
?>