<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
$domain_name=$_GET['username'];
$domains=[".集团",".企业",".商店",".网店",".网站",".网址",".我爱你",".移动",".游戏",".娱乐",".在线",".中国",".中文网",".ac.cn",".ah.cn",".archi",".art",".asia",".band",".beer",".bio",".biz",".bj.cn",".black",".blue",".cab",".cafe",".cash",".cc",".center",".chat",".city",".cloud",".club",".cn",".co",".com",".com.cn",".company",".cool",".cq.cn",".design",".email",".fan",".fans",".fashion",".fit",".fj.cn",".fun",".fund",".fyi",".games",".gd.cn",".gold",".green",".group",".gs.cn",".guru",".gx.cn",".gz.cn",".ha.cn",".hb.cn",".he.cn",".hi.cn",".hk",".hk.cn",".hl.cn",".hn.cn",".host",".icu",".info",".ink",".jl.cn",".js.cn",".jx.cn",".kim",".la",".law",".life",".link",".live",".ln.cn",".lotto",".love",".ltd",".luxe",".market",".mba",".me",".media",".mobi",".mo.cn",".name",".net",".net.cn",".news",".nm.cn",".nx.cn",".online",".org",".organic",".org.cn",".pet",".pink",".plus",".poker",".press",".pro",".promo",".pub",".pw",".qh.cn",".red",".ren",".run",".sale",".sc.cn",".sd.cn",".sh.cn",".shop",".shopping",".show",".site",".ski",".sn.cn",".so",".social",".space",".store",".studio",".sx.cn",".tax",".team",".tech",".technology",".tj.cn",".today",".top",".tv",".tw.cn",".video",".vin",".vip",".vote",".voto",".wang",".website",".wiki",".work",".world",".xj.cn",".xyz",".xz.cn",".yn.cn",".yoga",".zj.cn",".zone"];
$time=0;
foreach($domains as $part)
{
if($time>=1)
{
$domain_list.=','."\"$domain_name$part\"";
$time++;
}
if($time>=99)
{
break;
}
if($time==0)
{
if(!empty($domain_name))
{
if(!empty($part))
{
$domain_list="\"$domain_name$part\"";
$time++;
}
}
}
}
$url = "https://qcwss.cloud.tencent.com/capi/ajax-v3?action=BatchCheckDomain&from=domain_buy&_format=json";
$ch = curl_init(); 
$post_data ="{\"DomainList\":[$domain_list],\"Period\":1}";

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
// 把post的变量加上
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);


$headers = array();
$headers[] = 'Host: qcwss.cloud.tencent.com';
$headers[] = 'Accept: application/json, text/javascript, */*; q=0.01';
$headers[] = 'Accept-Encoding: gzip, deflate';
$headers[] = 'Content-Type: application/json; charset=UTF-8';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
 $output = curl_exec($ch);
if (curl_errno($ch)) {
echo 'Error:' . curl_error($ch);
echo "<br>";
}
curl_close ($ch);
// var_dump($post_data);
// echo "<br>";
foreach(json_decode($output) as $i => $m){
if($i=='result')
{
  foreach($m as $part => $data)
  {
if($part=='data')
{
foreach($data as $name => $data1)
{
if($name=='DomainList')
{
foreach($data1 as $data2)
{
foreach($data2 as $itemname => $itemdata)
{
switch($itemname)
{
case 'DomainName':
$domainname=$itemdata;    
break;
case 'Reason':
if($itemdata=='该域名已被注册。')
{
echo ",$domainname,";
break;    
}    
break;            
}
}
}
}
}
}
  }
}
}
?>