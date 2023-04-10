<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$github_api=getconfig('github_api',$config);
$username=$_GET['username'];
$url="https://api.zhihu.com/people/$username";
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$output = curl_exec($ch);
curl_close ($ch);
foreach(json_decode($output) as $item => $data)
{
switch($item)
{
case 'name':
echo ",<newnode>,zhihu:$username,$data,";
break;    
case 'headline':
echo ",$data,";
break;    
case 'gender':
if($data==1)
{
    echo ",男,";
}
else if($data==0)
{ 
echo ",女,";
}
break;
case 'ip_info':
if($data!='IP 属地未知')
{
    echo ",$data,";
}
break;
case 'business': 
foreach($data as $a => $b)
{
if($a=='name')
{
    echo ",$b,";
}
}
break;
case 'location':
        foreach($data as $c)
    {
        foreach($c as $a => $b)
        {
            if($a=='name')
            {
             echo ",$b,";
            }
        }
    }
break;
case 'sina_weibo_name':
    echo ",$data,";
break;
    }
}
?>