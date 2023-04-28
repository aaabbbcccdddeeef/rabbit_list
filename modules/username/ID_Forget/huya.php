<?php
include '../../../config.php';
// access_by_cookie($config,$_COOKIE);
$phone=$_GET['phone'];
$username=$_GET['username'];
$url='https://udblgn.huya.com/web/v2/passwordLogin';
$num=random_int(1,65535);
$header=array(
    'Host: udblgn.huya.com',
    "Cookie:  udb_deviceid=w_$num",
    'Accept-Encoding: indentity',
    'Content-Type: application/json;charset=UTF-8',
    ''   
);
$data='{"uri":"30001","version":"2.3","context":"","appId":"3001","lcid":"","byPass":"3","sdid":"","requestId":"","data":{"userName":"'.$username.'","password":"268e5c3f4d947ae95977b340b0aeb63fdb6b34b2","domainList":"","remember":"1","behavior":"","page":""}}';
$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
$output = curl_exec($ch);
if(curl_error($ch))
{
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
            if($c=='strategys')
            {
                foreach($d as $e)
                {
                    foreach($e as $f => $g)
                    {
                        if($f=='uid')
                        {
                            if($g!=0)
                            {
                                $uid=$g;
                            }
                            else 
                            {
                                echo '[{}]';
                                exit;
                            }
                        }
                        if($f=='data')
                        {
                            preg_match('/([0-9][0-9][0-9]\*\*\*\*[0-9][0-9][0-9][0-9])/',$g,$str);
                            $phone=$str[1];
                        }
                    }
                    if(!empty($uid))
                    {
                        echo '[';
                        echo '{"from_id":"'.$username.'","root_id":"'.$uid.'","root_label":"'.$uid.'","type":"unknown","imageurl":"/img/icon/unknown.png","title":"虎牙找回UID","raw_data":"","edge_color":"green","edge_label":"找回数据"},';
                        echo '{"from_id":"'.$username.'","root_id":"'.$phone.'","root_label":"'.$phone.'","type":"unknown","imageurl":"/img/icon/unknown.png","title":"虎牙找回手机号","raw_data":"","edge_color":"green","edge_label":"找回数据"},';
                        echo '{}]';
                    }
                    exit;
                }
            }
        }
    }
}