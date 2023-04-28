<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
$phone=$_GET['phone'];
# url 生成
$url = "https://www.kuaidaili.com/checkemailexist?mobile=".$phone."&op=fQfQfQfQfQwMYszYFzfQfQfQfQfQGzfQhXfQfQfQfQfQfQGzfQAgmZfQfQfQfQfQGzfQpDJyfQfQfQfQfQGzfQhXmZfQfQfQfQfQGzYsfQAgfQfQfQfQfQGzYswMzYfQfQfQfQfQGzYszYmZfQfQfQfQfQGzfQwMAgfQfQfQfQfQGzfQJyAgfQfQfQfQfQGzYsmZGzfQfQfQfQfQGzfQpDwMfQfQfQfQfQGzfQpDpDfQfQfQfQfQFzfQAgYsfQfQfQfQfQGzfQJyCxfQfQfQfQfQFzfQhXfQfQfQfQfQfQFzfQzYFzfQfQfQfQfQFzYsmZJyfQfQfQfQfQhXfQmZpDfQfQfQfQfQhXfQGzGzfQfQfQfQfQhXfQGzYsfQfQfQfQfQhXfQGzfQfQfQfQfQfQhXfQAgGzfQfQfQfQfQhXfQzYJyfQfQfQfQfQhXfQhXhXfQfQfQfQfQhXfQmZFzfQfQfQfQfQhXfQGzFzfQfQfQfQfQhXfQhXYsfQfQfQfQfQhXfQmZfQfQfQfQfQfQhXfQAgGzfQfQfQfQfQhXfQhXFzfQfQfQfQfQFzYsmZGzfQfQfQfQfQpDfQAgCxfQfQfQfQfQpDfQzYGzfQfQfQfQfQpDfQwMhXfQfQfQfQfQpDfQmZFzfQfQfQfQfQzYfQmZzYfQfQfQfQfQpDfQmZfQfQfQfQfQfQpDfQmZJyfQfQfQfQfQzYYsfQwMfQfQfQfQfQzYYshXGz";
#
# 数据包发送 post
$ch = curl_init(); 
$post_data = array(
    'usermail' => $phone
);

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
# ssl 认证
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);


$output = curl_exec($ch);
if (curl_errno($ch)) {
    echo '[{}]';
    exit;
}
curl_close ($ch);

# 数据处理

$test_reg = '/"msg": "(.*)", "code": /i';
preg_match_all($test_reg, $output, $result);

# echo $phone;
# echo "<br>";
# echo $url;
# echo "<br>";
# echo "<br>";
$test=$result[1][0];
# echo "$phone";
# echo "<br>";
# echo "$test";
if($test=="exist")
{
    echo '[{"from_id":"'.$phone.'","root_id":"registed:kuaidaili.com","root_label":"registed:kuaidaili.com","type":"registed","imageurl":"/img/icon/registed.png","title":"该号码可能注册 kuaidaili.com,通常意味着号主可能是黑灰产,红队,爬虫开发者等需要大量代理的岗位","raw_data":"","edge_color":"yellow","edge_label":"注册枚举"}]';
}
else if($test=="not exist")
{
echo "[{}]";
}

# 结果输出
?>