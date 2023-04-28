<?php
include '../../../config.php';
// access_by_cookie($config,$_COOKIE);
$phone=$_GET['phone'];
$url="https://www.114best.com/dh/114.aspx?w=$phone";
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
if (curl_errno($ch)) {
    echo '[{}]';
    exit;
}
/*
<div class="visit_list">
                        <p>
                            
                                    2023-03-24 23:56
                                    亚太地区（103.172.*.*）网友<br>
                                
                                    2023-03-19 17:15
                                    亚太地区（103.172.*.*）网友<br>
                                
                                    2023-03-05 12:45
                                    美国（50.7.*.*）网友<br>
                                
                        </p>
                        
                    </div>
*/
// echo $output;
// preg_match('/<div class="visit_list">(.*)/iU',$output,$result);
preg_match_all('/([0-9][0-9][0-9][0-9].*)\n(.*)（(.*)）网友/',$output,$str);
// var_dump($result);
// var_dump($str);
echo '[';
if(!empty($str))
{
$count=count($str[1]);
for($i=0;$i<$count;$i++)
{
$time=str_replace("\r",'',$str[1][$i]);    
$address=str_replace(' ','',$str[2][$i]);
$ip=$str[3][$i];
// echo '{"from_id":"'.$phone.'","root_id":"'.$time.'","root_label":"'.$time.'","type":"unknown","imageurl":"/img/icon/unknown.png","title":"该号码在 '.$time.'被搜索","raw_data":"","edge_color":"orange","edge_label":"111best页面爬取"},';
echo '{"from_id":"'.$phone.'","root_id":"'.$address.'","root_label":"'.$address.'","type":"address","imageurl":"/img/icon/address.png","title":"该号码在'.$time.'的'.$address.'被搜索","raw_data":"","edge_color":"orange","edge_label":"111best页面爬取"},';
echo '{"from_id":"'.$address.'","root_id":"'.$ip.'","root_label":"'.$ip.'","type":"ip","imageurl":"/img/icon/ip.png","title":"该号码在'.$time.'的'.$ip.'被搜索","raw_data":"","edge_color":"orange","edge_label":"111best页面爬取"},';
}
}
echo '{}]';
?>