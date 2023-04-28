<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
if($_GET['username'])
{
$username=$_GET['username'];
}
if($_GET['unknown'])
{
$username=$_GET['unknown'];
}
# url 生成
$url = "https://leetcode.cn/graphql/";
#
# 数据包发送 post
$ch = curl_init();
$post_string='{"query":"\nquery userProfilePublicProfile($userSlug: String!) {\n  userProfilePublicProfile(userSlug: $userSlug) {\n profile {\n  userSlug\n  realName\n  aboutMe\n  asciiCode\n   gender\n  websites\n  skillTags\n  ipRegion\n  birthday\n  location\n  useDefaultAvatar\n  github\n  school: schoolV2 {\nschoolId\nlogo\nname\n  }\n  company: companyV2 {\nid\nlogo\nname\n  }\n  job\n  globalLocation {\ncountry\nprovince\ncity\noverseasCity\n  }\n  socialAccounts {\nprovider\nprofileUrl\n  }\n  skillSet {\nlangLevels {\n  langName\n  langVerboseName\n  level\n}\ntopics {\n  slug\n  name\n  translatedName\n}\ntopicAreaScores {\n  score\n  topicArea {\nname\nslug\n  }\n}\n  }\n}\neducationRecordList {\n  unverifiedOrganizationName\n}\noccupationRecordList {\n  unverifiedOrganizationName\n  jobTitle\n}\n  }\n}\n","variables":{"userSlug":"'.$username.'"}}';
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
# ssl 认证
// curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
// curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
# POST
// 我们在POST数据哦！
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$post_string);
$headers = array();
$headers[] = 'Host: leetcode.cn';
$headers[] = 'Accept-Language: zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2';
$headers[] = 'Accept-Encoding: identity';
$headers[] = 'Content-Type: application/json';

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$output = curl_exec($ch);
if (curl_errno($ch)) {
echo 'Error:' . curl_error($ch);
echo "<br>";
}
curl_close ($ch);
$result_list=json_decode($output,true);
if($result_list['data']['userProfilePublicProfile']==null)
{
    echo '[{}]';
    exit;
}
echo '[';
foreach($result_list['data']['userProfilePublicProfile'] as $part => $content)
{
switch($part)
{
case 'profile':
foreach($content as $name => $data)
{
switch($name)
{
case 'userSlug':
$username1='leetcode:'.$data;
break;
case 'realName':
$realname=$data;
if(strlen($realname)>1)
{
echo '{"from_id":"'.$username1.'","root_id":"'.$realname.'","root_label":"'.$realname.'","type":"username","imageurl":"/img/icon/username.png","title":"LeetCode爬取对方填写的实名信息","raw_data":"","edge_color":"yellow","edge_label":"Leetcode爬虫"},';
}
break; 
case 'gender':
if($data!='None')
{
    if($data==1)
    {
        $gender='男';
    }
    else if($data==2)
    {
        $gender='女';
    }
    else
    {
        $gender='未知';
    }
$title=$title.' 性别: '.$gender.'; ';
}  
break; 
case 'ipRegion':
if($data!='未知归属地')
{
$address=$data;
}    
break; 
case 'birthday':
    if(strlen($data)>1)
    {
    $title=$title.'生日 :'.$data.';';
    }     
break; 
case 'location':
if($data!='0%0'&&$data!='None%None')
{
    if(strlen($data)>1)
    {
    echo '{"from_id":"'.$username1.'","root_id":"'.$data.'","root_label":"'.$data.'","type":"address","imageurl":"/img/icon/address.png","title":"LeetCode爬取的地理位置信息","raw_data":"","edge_color":"yellow","edge_label":"Leetcode爬虫"},';
    }    
}
break;
case 'github':
if(strlen($data)>1)
{
echo '{"from_id":"'.$username1.'","root_id":"'.$data.'","root_label":"'.$data.'","type":"address","imageurl":"/img/icon/address.png","title":"LeetCode爬取的地理位置信息","raw_data":"","edge_color":"yellow","edge_label":"Leetcode爬虫"},';
}
break;
case 'school':
    if($data!='')
    {
        foreach($data as $itemname => $itemdata)
        {
        switch($itemname)
        {
        // case 'id':
        // case 'logo':
        case 'name':
        if(strlen($itemdata)>1)
        {
            echo '{"from_id":"'.$username1.'","root_id":"'.$itemdata.'","root_label":"'.$itemdata.'","type":"address","imageurl":"/img/icon/address.png","title":"LeetCode爬取的学历信息","raw_data":"","edge_color":"yellow","edge_label":"Leetcode爬虫"},';            
        }    
        break;
        }
        }
    }
break;
case 'company':
    if($data!='')
    {
        foreach($data as $itemname => $itemdata)
        {
        switch($itemname)
        {
      //  case 'id':
      //  case 'logo':
        case 'name':
        if(strlen($itemdata)>1) 
        {
        echo '{"from_id":"'.$username1.'","root_id":"'.$itemdata.'","root_label":"'.$itemdata.'","type":"company","imageurl":"/img/icon/company.png","title":"LeetCode爬取的企业信息","raw_data":"","edge_color":"yellow","edge_label":"Leetcode爬虫"},';    
        }    
        break;
        }
        }
    }
break;  
case 'job':
if(strlen($data)>1)
{
    echo '{"from_id":"'.$username1.'","root_id":"'.$data.'","root_label":"'.$data.'","type":"company","imageurl":"/img/icon/company.png","title":"LeetCode爬取的工作信息","raw_data":"","edge_color":"yellow","edge_label":"Leetcode爬虫"},';
}
break; 
case 'globalLocation':

    foreach($data as $itemname => $itemdata)
{
switch($itemname)
{
case 'country':
case 'province':
case 'city':
    if(strlen($itemdata)>1)
    {
    echo '{"from_id":"'.$username1.'","root_id":"'.$itemdata.'","root_label":"'.$itemdata.'","type":"address","imageurl":"/img/icon/address.png","title":"LeetCode爬取的地理位置信息","raw_data":"","edge_color":"yellow","edge_label":"Leetcode爬虫"},';
}    
break;
}
}
break; 
case 'socialAccounts':
foreach($data as $no => $itemnum)
{
foreach($itemnum as $itemname => $itemdata)
{
    if(!empty($itemdata))
    {
    $title=$title.' social_account:'.$itemname.':'.$itemdata.';';
    }
}
}
break; 
case 'websites':
    foreach($data as $no => $itemnum)
    {
    foreach($itemnum as $itemname => $itemdata)
    {
        if(!empty($itemdata))
        {
            echo '{"from_id":"'.$username1.'","root_id":"'.$itemdata.'","root_label":"'.$itemdata.'","type":"domain","imageurl":"/img/icon/domain.png","title":"LeetCode爬取的博客信息","raw_data":"","edge_color":"yellow","edge_label":"Leetcode爬虫"},';
        }
    }
    }
break; 
}
}
break;  
case 'educationRecordList':
    foreach($content as $no => $itemnum)
    {
    foreach($itemnum as $itemname => $itemdata)
    {
        if(!empty($itemdata))
        {
        // echo ",$itemdata,";
        echo '{"from_id":"'.$username1.'","root_id":"'.$itemdata.'","root_label":"'.$itemdata.'","type":"unknown","imageurl":"/img/icon/unknown.png","title":"LeetCode爬取的学历信息","raw_data":"","edge_color":"yellow","edge_label":"Leetcode爬虫"},';
    }
    }
    }
break;
case 'occupationRecordList':
    foreach($content as $no => $itemnum)
    {
    foreach($itemnum as $itemname => $itemdata)
    {
        if(!empty($itemdata))
        {
            echo '{"from_id":"'.$username1.'","root_id":"'.$itemdata.'","root_label":"'.$itemdata.'","type":"unknown","imageurl":"/img/icon/unknown.png","title":"LeetCode爬取的就业信息","raw_data":"","edge_color":"yellow","edge_label":"Leetcode爬虫"},';
        }
    }
    }
break;  
}
echo '{"from_id":"'.$username.'","root_id":"'.$username1.'","root_label":"'.$username1.'","type":"username","imageurl":"/img/icon/username.png","title":"LeetCode爬取'.$title.'","raw_data":"","edge_color":"yellow","edge_label":"Leetcode爬虫"},';
$gender='';
$job='';
$school='';
$company='';
$opu='';
$title='';
$realname='';
}
echo '{}]';
?>