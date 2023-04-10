<?php
# 输入变量
$keywords=$_GET['username'];
$show_result=[];
$url ='https://www.kuaishou.com/graphql';
for($i=1;$i<=1;$i++)
{
    $ch = curl_init();
    $post_string='{"operationName":"graphqlSearchUser","variables":{"keyword":"'.$keywords.'","pcursor":"'.$i.'","searchSessionId":""},"query":"query graphqlSearchUser($keyword: String, $pcursor: String, $searchSessionId: String) {\n  visionSearchUser(keyword: $keyword, pcursor: $pcursor, searchSessionId: $searchSessionId) {  users {\n   user_id\n       user_text\n      user_name\n      verified\n      verifiedDetail {\n        description\n        }\n    }\n    }\n}\n"}';
    //$post_string=1;
    //var_dump($post_string); 
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    # ssl 认证
    //  curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
    //  curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
    // curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$post_string);
    $headers = array();
    $headers[] = 'Cookie: kpf=PC_WEB; kpn=KUAISHOU_VISION; clientid=30; did=web_1; client_key=1; _did=web_1; soft_did=1; didv=1';
    $headers[] = 'Content-Type: application/json'; 
    //  $headers[] = 'Host: www.kuaishou.com'; 
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $output_data = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
        echo "<br>";
    }
    curl_close ($ch);
    $result_json=json_decode($output_data,true);
    var_dump($result_json);
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