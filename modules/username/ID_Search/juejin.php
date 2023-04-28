<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$username=$_GET['username'];
$url='https://api.juejin.cn/search_api/v1/search?aid=1&uuid=1&spider=0';
$header=array(
   // 'Host: api.juejin.cn',
    'Accept-Encoding: identity',
    'Referer: https://juejin.cn/',
    'Content-Type: application/json',
    'Origin: https://juejin.cn',
    ''
);
$payload='{
    "key_word": "'.$username.'",
    "id_type": 1,
    "cursor": "0",
    "limit": 20,
    "search_type": 0,
    "sort_type": 0,
    "version": 1,
    "uuid": "1",
    "ab_info": "{}"
  }';
$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
$output = curl_exec($ch);
// echo $output;
// exit;
if (curl_errno($ch)) {
    echo '[{}]';
    exit;
}
curl_close($ch);
// echo $output;
// exit;
echo '[';
foreach(json_decode($output) as $z => $y)
{
if($z=='data')
{
    foreach($y as $f)
    {
    foreach($f as $j => $k)
    {
        if($j=='result_model')
        {
            foreach($k as $a => $b)
        {
            switch($a)
        {
            case 'user_id':
            $id=$b;
            echo '{"from_id":"'.$username.'","root_id":"'.$id.'","root_label":"'.$id.'","type":"unknown","imageurl":"/img/icon/unknown.png","title":"稀土掘金 爬取UID","raw_data":"","edge_color":"yellow","edge_label":"Juejin 爬取"},';
            break;
            case 'user_name':
            $nickname=$b;
            echo '{"from_id":"'.$id.'","root_id":"'.$nickname.'","root_label":"'.$nickname.'","type":"username","imageurl":"/img/icon/username.png","title":"稀土掘金 爬取用户名","raw_data":"","edge_color":"yellow","edge_label":"Juejin 爬取"},';
            break;
            case 'company':
            $company=$b;
            if(!empty($company))
            {
            echo '{"from_id":"'.$id.'","root_id":"'.$company.'","root_label":"'.$company.'","type":"address","imageurl":"/img/icon/address.png","title":"稀土掘金 爬取UID的企业名","raw_data":"","edge_color":"yellow","edge_label":"Juejin 爬取"},';
            }
            break;    
            case 'job_title':
            $job=$b;
            if(!empty($job))
            {
            echo '{"from_id":"'.$id.'","root_id":"'.$job.'","root_label":"'.$job.'","type":"unknown","imageurl":"/img/icon/unknown.png","title":"稀土掘金 爬取UID的工作名","raw_data":"","edge_color":"yellow","edge_label":"Juejin 爬取"},';
            }
            break;
            case 'university':
            foreach($b as $c => $d)
            {
                if($c=='name')
                {
                    $school=$d;
                    if(!empty($school))
                    {
                    echo '{"from_id":"'.$id.'","root_id":"'.$school.'","root_label":"'.$school.'","type":"address","imageurl":"/img/icon/address.png","title":"稀土掘金 爬取UID的学校名","raw_data":"","edge_color":"yellow","edge_label":"Juejin 爬取"},';
                    }
                }
            } 
            break;
            case 'major':
                foreach($b as $c => $d)
                {
                    if($c=='name')
                    {
                        $major=$d;
                        if(!empty($major))
                        {
                        echo '{"from_id":"'.$id.'","root_id":"'.$major.'","root_label":"'.$major.'","type":"unknown","imageurl":"/img/icon/unknown.png","title":"稀土掘金 爬取UID的专业名","raw_data":"","edge_color":"yellow","edge_label":"Juejin 爬取"},';
                        }
                    }
                }   
                break;                    
        }
    }
    $school='';
    $company='';
    $major='';
    $job='';
}
}
}
}
}
echo '{}]';
?>