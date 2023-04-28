<?php
include '../config.php';
$openAI_key=getconfig('openAI_key',$config);
// access_by_cookie($config,$_COOKIE);
$registed=explode(',',$_GET['registed']);
$string="现在你是一个开源情报调查人员,你知道罪犯张三注册了";
foreach($registed as $site)
{
$string=$string.','.$site;
}
$string=$string.',请你猜测描述张三的兴趣爱好,可能的职业,专业,年龄段,教育,宗教,政治立场等信息，用几个词简单概括，不回答推断的过程和依据,将结果以一个json的格式输出,结果使用中文';
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
                    break;
                    }
                }
            }
        }
        }
    }
}
?>