<?php
$url=$_GET['url'];

function str_encode($input_data)
{
    // $output_data='';
    $icon_base64=$input_data;
    for($i=0;$i<strlen($icon_base64);$i++)
    {
    $add=str_split($icon_base64)[$i];    
    $output_data=$output_data.$add;   
   
    if(($i+1)%76===0)
    {
    $output_data=$output_data."\n";
    } 
    
    }
    return $output_data;
}
$ch = curl_init(); 
// $post_data ="username=".$phone."&password=12345678&key=&captcha=";
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
# ssl 认证
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
# POST
# curl_setopt($ch, CURLOPT_POST, 1);
// 把post的变量加上
// curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
// $headers = array();
// $headers[] = 'Cookie: lang=en';
// $headers[] = 'X-Custom-Header: MyHeader';
# curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$output_data=base64_encode(curl_exec($ch));
$output=str_encode($output_data);
$result=hash('murmur3a',$output);
echo $result;
exit;
?>