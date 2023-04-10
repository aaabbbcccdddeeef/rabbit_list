<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
# 输入变量
if($_GET['username'])
{
$username=$_GET['username'];
}
if($_GET['unkonwn'])
{
$username=$_GET['unkonwn'];
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
    exit;
}
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
echo ",<newnode>,$data";
break;
case 'realName':
echo ",$data";
break;
case 'aboutMe':
break;  
case 'asciiCode':
break; 
case 'gender':
if($data!='None')
{
echo ",$data";
}  
break; 
case 'ipRegion':
if($data!='未知归属地')
{
echo ",$data";
}    
break; 
case 'birthday':
echo ",$data";
break; 
case 'location':
if($data!='0%0'&&$data!='None%None')
{
echo ",$data";
}
break;
case 'github':
echo ",$data";
break;
case 'school':
    if($data!='')
    {
        foreach($data as $itemname => $itemdata)
        {
        switch($itemname)
        {
        case 'id':
        case 'logo':
        case 'name':
        echo ",$itemdata";    
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
        case 'id':
        case 'logo':
        case 'name':
        echo ",$itemdata";    
        break;
        }
        }
    }
break;  
case 'job':
echo ",$data";
break; 
case 'globalLocation':
foreach($data as $itemname => $itemdata)
{
switch($itemname)
{
case 'country':
case 'province':
case 'city':
echo ",$itemdata";    
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
    echo ",$itemname:$itemdata,";
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
        echo ",$itemdata,";
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
        echo ",$itemdata,";
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
        echo ",$itemdata,";
        }
    }
    }
break;  
}
}
?>