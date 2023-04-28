<?php
include '../../../config.php';
// access_by_cookie($config,$_COOKIE);
$XRapidAPIKey=getconfig('X-RapidAPI-Key',$config);
$datafrom=$_GET['dataleak'];
$data1=str_replace('@','%40',$_GET['dataleak']);
$curl = curl_init();
curl_setopt_array($curl, [
	CURLOPT_URL => "https://breachdirectory.p.rapidapi.com/?func=auto&term=".$data1,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"X-RapidAPI-Host: breachdirectory.p.rapidapi.com",
		"X-RapidAPI-Key: $XRapidAPIKey"
	],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "[{}]";
} 
else
{
    echo '[';
	foreach(json_decode($response) as $a => $b)
    {
    if($a=='result')
    {
        foreach($b as $c)
        {
            if(!empty($c))
            {
                foreach($c as $d => $e)
                {
                    if($d=='line')
                    {
                        $data=$e;
                    }
                    else if($d=='last_breach')
                    {
                        $time=$e;
                    }
                }
                echo '{"from_id":"'.$datafrom.'","root_id":"'.$data.'","root_label":"'.$data.'","type":"unknown","imageurl":"/img/icon/unknown.png","title":"清洗泄漏数据,事件时间:'.$time.'","raw_data":"","edge_color":"yellow","edge_label":"breachdirectory"},';
                $pass=explode(':',$data);
                $password=$pass[1];
                if(!empty($password))
                {
                echo '{"from_id":"'.$data.'","root_id":"'.$password.'","root_label":"'.$password.'","type":"unknown","imageurl":"/img/icon/unknown.png","title":"泄露密码,泄漏事件时间:'.$time.'","raw_data":"","edge_color":"yellow","edge_label":"breachdirectory"},';
                }
            }
        }
    }
    }
    echo '{}]';
}

?>