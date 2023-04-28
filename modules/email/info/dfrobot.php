<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$email=$_GET['email'];
$email1=str_replace('@','%40',$_GET['email']);
$url="https://api.dfrobot.com.cn/user/simple_info?app_auth_token=&app_id=432809143856280&biz_content=%7B%22email%22%3A%22$email1%22%7D&sign_type=md5";
$header=array(
'Host: api.dfrobot.com.cn',
'Accept-Encoding: indentity',
'Origin: https://auth.dfrobot.com.cn',
'Dnt: 1',
'Referer: https://auth.dfrobot.com.cn/',
''
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
/* curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post); */
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
$output_data=curl_exec($ch);
if(curl_error($ch))
{
    echo '[{}]';
    exit;
}
curl_close($ch);
echo '[';
foreach(json_decode($output_data) as $a => $b)
{
    if($a=='data')
    {
        if(!empty($b))
        {
        foreach($b as $c => $d)
        {
            if(!empty($d))
            {
                if($c=='_id')
                {
                $id=$d;
                }
                else if($c=='created')
                {
                $time=$d;
                }
                else if($c=='fristname')
                {
                $fristname=$d;
                echo '{"from_id":"'.$email.'","root_id":"'.$fristname.'","root_label":"'.$fristname.'","type":"username","imageurl":"/img/icon/username.png","title":"dfrobot 注册接口,注册时间:'.$time.',uid:'.$id.'","raw_data":"","edge_color":"yellow","edge_label":"dfrobot 注册接口"},';
                }
                else if($c=='lastname')
                {
                $lastname=$d;
                echo '{"from_id":"'.$email.'","root_id":"'.$lastname.'","root_label":"'.$lastname.'","type":"username","imageurl":"/img/icon/username.png","title":"dfrobot 注册接口,注册时间:'.$time.',uid:'.$id.'","raw_data":"","edge_color":"yellow","edge_label":"dfrobot 注册接口"},';
                }
                else if($c=='username')
                {
                echo '{"from_id":"'.$email.'","root_id":"'.$d.'","root_label":"'.$d.'","type":"username","imageurl":"/img/icon/username.png","title":"dfrobot 注册接口,注册时间:'.$time.',uid:'.$id.'","raw_data":"","edge_color":"yellow","edge_label":"dfrobot 注册接口"},';           
                }
            }
        }
    }
    }
}
echo '{}]';
?>