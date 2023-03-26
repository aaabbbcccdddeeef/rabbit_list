<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$gaode_apikey=getconfig('gaode_apikey',$config);
$raw_location=str_replace('location:','',$_GET['location']);
$str1=str_replace('[','',$raw_location);
$str2=str_replace(']','',$str1);
$lat=explode(':',$str2)[0];
$lon=explode(':',$str2)[1];
$url="https://restapi.amap.com/v3/place/around?key=$gaode_apikey&location=$lat,$lon&radius=1000";
// echo $url;
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
$output = curl_exec($ch);
curl_close ($ch);
foreach(json_decode($output) as $a => $b)
{
if($a==='pois')
{
    if(!empty($b))
    {
        foreach($b as $item)
        {
        foreach($item as $c => $d)
        {
            switch($c)
            {
                case 'address':
                echo ",<newnode>,$d,";
                break;
                case 'tel':
                foreach($d as $tel)
                {
                    if(!empty($tel))
                    {
                    echo ",$tel,";    
                    }
                }
                break;
                case 'location':
                $location='location:['.str_replace(',',':',$d).']';
                echo ",$location,";
                break;    
                case 'name':  
              //  case 'distance':          
                echo ",$d,";
                break;    
            }
        }
        }
    }
}
}
?>