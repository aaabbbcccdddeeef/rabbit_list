<?php
include '../../../config.php';
$openAI_key=getconfig('openAI_key',$config);
// access_by_cookie($config,$_COOKIE);
$username=$_GET['username'];
$string='某个字符串';
$string=$string.$username;
$string=$string.'是一某名字的拼音，请猜测可能的名字，回答可能的名字组成的数组，不附带别的信息';
$url="https://api.openai.com/v1/chat/completions";
$header=array(
'Host: api.openai.com',
'Content-Type: application/json',
"Authorization: Bearer $openAI_key"    
);
$data='{"model": "gpt-3.5-turbo","messages": [{"role": "user", "content": "'.$string.'"}],"temperature":0.7}';
$ch=curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
$output_data=curl_exec($ch);
curl_close($ch);
/* echo $output_data;
echo "\n"; */
echo '[';
foreach(json_decode($output_data) as $a => $b)
{
    if($a=='choices')
    {
        foreach($b as $c)
        {
            foreach($c as $d => $e)
            {
            if($d=='message')
            {
                foreach($e as $f => $g)
                {
                    if($f=='content')
                    {
                    foreach(json_decode($g) as $z)
                    {
                    echo '{"from_id":"'.$username.'","root_id":"'.$z.'","root_label":"'.$z.'","type":"username","imageurl":"/img/icon/username.png","title":"Chat-gpt 猜测的中国人名","raw_data":"","edge_color":"yellow","edge_label":"GPT-主观推测"},';
                    }
                    break;
                    }
                }
            }
        }
        }
    }
}
echo '{}]';
?>