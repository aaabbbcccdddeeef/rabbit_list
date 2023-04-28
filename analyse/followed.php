<?php
include '../config.php';
$openAI_key=getconfig('openAI_key',$config);
// access_by_cookie($config,$_COOKIE);
$followed=explode(',',$_GET['followed']);
$string="我关注了";
foreach($followed as $sb)
{
$string=$string.','.$sb;
}
$string=$string.'等，请你尝试推测我的兴趣爱好，年龄段，职业，政治立场，宗教信仰，性别，消费能力，教育水平，推测结果保存在json里，并且使用中文，不回答推理过程等内容，如果无法回答这个问题就回答一个json数组，且回答内容限定为json';
$url="https://api.openai.com/v1/chat/completions";
$header=array(
'Host: api.openai.com',
'Content-Type: application/json',
"Authorization: Bearer $openAI_key"    
);
$data='{"model":"gpt-3.5-turbo","messages":[{"role":"user","content":"'.$string.'"}],"temperature": 0.7}';
$ch=curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
$output_data=curl_exec($ch);
curl_close($ch);
// echo $output_data;
// echo "\n";
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
                    echo (json_encode($g));
                   // echo "<br>";
                   // echo $g;
                    break;
                    }
                }
            }
        }
        }
    }
}
?>