<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
$phone=$_GET['username'];
$show_result=[];
$url ='https://whois.chinaz.com/reverseapi/list';
$ch = curl_init();
$ts=1679216936775;
$token='87c83e8b9390cc8ad678e5a5347228ad'; 
$post_string='{"module":"phone","keyword":"{\"host\":\"'.$phone.'\",\"domain\":\"\"}","params":{"host":"'.$phone.'","domain":"",},"ts":'.$ts.',"token":"'.$token.'"}';
//  ts,token  这个过期了就自己改 
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
# ssl 认证
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0);
curl_setopt($ch, CURLOPT_POSTFIELDS,$post_string);


$headers = array();
$headers[] = 'Content-Type: application/json';
$headers[] = 'Host: whois.chinaz.com';  
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$output_data = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
    echo "<br>";
}
curl_close ($ch);
$result_json=json_decode($output_data,true);
// var_dump($result_json['data']['data']['list']);
if(!empty($result_json['data']['data']['list']))
{
    foreach($result_json['data']['data']['list'] as $part=>$data)
    {  
        //  var_dump($data);
        //  echo '<br>';  
    foreach($data as $part => $content)
    {
        // echo "$part:$content<br>";
        if($content!='')
        {
            switch($part)
            {

                case 'domain':
                echo ",<newnode>,$content";   
                break; 
                case '"city"':
                case 'company':
                case 'contactEmail':
                case 'contactPerson':
                case 'contactPhone':
                case 'country':                
                case 'id':
                case 'province':
                case 'registrar':
                case 'registrarEmail':
                case 'registrarPhone':  
                echo  ",$content";          
                break;
            }
        }
    }       
    //  echo '<br>'; 
    }
}
/* 
$show_result=array_unique($show_result);
foreach($show_result as $show)
{
    if($show!='')
    {
    echo ",$show";    
    }
} 
*/
# 数据处理


?>