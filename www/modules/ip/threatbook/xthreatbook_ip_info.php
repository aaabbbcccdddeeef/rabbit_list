<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$domain=$_GET['ip'];
$apikey=getconfig('xbook_key',$config);
// get cURL resource
$ch = curl_init();
// set url
curl_setopt($ch, CURLOPT_URL, "https://api.threatbook.cn/v3/scene/ip_reputation?apikey=$apikey&resource=$domain");
// set method
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
// return the transfer as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// send the request and save response to $response
$response = curl_exec($ch);
// var_dump($response);
// echo '<br>';
// close curl resource to free up system resources
curl_close($ch);
echo ",<newnode>,xbook:$domain,";
foreach(json_decode($response,true) as $i => $part)
{
foreach($part as $itemname => $itemdata)
{
foreach($itemdata as $m => $n )
{
switch($m)
{
case 'judgments':
    foreach($n as $a => $b )
    {
        echo ",$b,";
    }
break;  
case 'tags':
    echo $b;
break;
case 'basic':
    foreach($n as $a => $b )
    {
        if($a=='location')
        {
            foreach($b as $a1 => $b1 )
            {
                switch($a1)
                {
        case 'lng':
            $lng=$b1;
        break; 
        case 'lat':
            $lat=$b1;
        break; 
        case 'country_code':
            $country_code=$b1;
        break;  
        case 'city':
            $city=$b1;
        break;      
        case 'province':
            $province=$b1;
        break;     
        case 'country':
            $country=$b1;
        break;    
                }
            }
        echo ",$country_code-$country-$province-$city,location:[$lat:$lng],";
        }
        else
        {
            echo ",$b,";
        }
    }    
break;
case 'asn':
    foreach($n as $a => $b)
    {
        if($a=='info')
        {
            echo ",$b,";
        }
    }
break; 
case 'scene':
    echo ",$b,";
break;          
case 'is_malicious':
if($n==true)
{
    echo ',恶意,';
}    
break; 
}
}
}
break;
}
?>