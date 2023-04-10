<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$username=$_GET['username'];
function test_exist($username)
{
    $url="https://gitee.com/check";
    $data="do=user_username&val=$username";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $output_data = curl_exec($ch);
    curl_close ($ch);
    if($output_data=='地址已存在')
    {
        return '123';
    }
    else
    {
        exit;
    }
}
function getdata($username)
{
    $url="https://gitee.com/$username";
    // $data="do=user_username&val=$username";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    // curl_setopt($ch, CURLOPT_POST, 1);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $output_data = curl_exec($ch);
    curl_close ($ch); 
    preg_match_all('/(<span title=\')(.*)(\'>)/',$output_data,$str);
    echo ",<newnode>,";
foreach($str as $a => $b)
{
    if($a==2)
    {
        foreach($b as $data)
        {
            echo "$data,";
        }
    }
}
    preg_match_all('/(<span>)(.*)(<\/span>)/',$output_data,$str);
// var_dump($str);
// echo '<br>';
foreach($str as $a => $b)
{
    if($a=2)
    {
foreach($b as $data)
{
        $newdata=str_replace('<span>','',$data);
        $data=str_replace('</span>','',$newdata);
        $len=strlen($data);
        if($len > 2)
        {
        if($len < 32)
        {
            if($data!='Git 命令在线学习'&&$data!='Gitee'&&$data!='私信'&&$data!='关注')
            {
                echo ",$data,";
            }
        }
    }
    }
}
    }
}


test_exist($username);
getdata($username);

?>