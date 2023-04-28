<?php
include '../config.php';
$openAI_key=getconfig('openAI_key',$config);
// access_by_cookie($config,$_COOKIE);
$liked=explode(',',$_GET['liked']);
$string="我点赞了";
foreach($liked as $sb)
{
$string=$string.','.$sb;
}
$string=$string.'等，请推测我的年龄，爱好，性别，政治立场，宗教信仰，职业，学历，结果保存在json里面，必须使用中文，且请不要回答json以外的任何内容';
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