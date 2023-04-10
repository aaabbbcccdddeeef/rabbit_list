<?php
# 输入变量
$ip=$_GET['ip'];
# url 生成
$url = "https://api.webscan.cc/?action=query&ip=".$ip;
#
# 数据包发送 post
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
# ssl 认证
// curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
// curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
# POST
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
$output = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
    echo "<br>";
}
curl_close ($ch);

foreach(json_decode($output) as $i => $item)
{
foreach($item as $name => $content)
{
    switch($name)
    {
case 'domain':
echo ",<newnode>,$content";    
break;
case 'title':
echo ",$content,";    
break;                
    }
}
}

?>