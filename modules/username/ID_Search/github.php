<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$username=$_GET['username'];
$url="https://github.com/search?p=1&q=$username&type=users";
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$output_data = curl_exec($ch);
curl_close ($ch);
$showresult=[];
$username_reg='/(<em>)(.*)(<\/em>)/';
preg_match_all($username_reg, $output_data,$result);
foreach($result as $a => $b)
{
    if(!empty($b))
    {
        foreach($b as $item => $data)
        {
            if(!empty($data))
            {
                $showresult[]=$data;
            }
        }
    }
}
$c=array_unique($showresult);
echo '[';
if(empty($output_data))
{
    echo '{}]';
    exit;
}
foreach($c as $d)
{
    $s=str_replace('<em>','',$d);
    $t=str_replace('</em>','',$s);
    echo '{"from_id":"'.$username.'","root_id":"'.$t.'","root_label":"'.$t.'","type":"username","imageurl":"/img/icon/username.png","title":"Github 搜索用户名","raw_data":"","edge_color":"yellow","edge_label":"Github 搜索"},';
}
echo '{}]';
?>