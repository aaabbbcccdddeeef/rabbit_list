<?php
include '../../../config.php';
access_by_cookie($config,$_COOKIE);
$username=$_GET['username'];
$token=getconfig('gitee_token',$config);
$url='https://gitee.com/api/v5/users/'.$username.'?access_token='.$token;
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$output = curl_exec($ch);
if(curl_error($ch))
{
    echo '[{}]';
    exit;
}
curl_close ($ch);
echo '[';
foreach(json_decode($output) as $name => $data)
{
    if($name=='message')
    {
        if($data=='404 Not Found')
        {
            echo '{}]';
            exit;
        }
    }
    if($name=='id')
    {
        if(!empty($data))
        {
            $id=$data;
            echo '{"from_id":"'.$username.'","root_id":"'.$id.'","root_label":"'.$id.'","type":"unknown","imageurl":"/img/icon/unknown.png","title":"Gitte 唯一ID","raw_data":"","edge_color":"yellow","edge_label":"Gitte 接口"},';
        }
    }
    if($name=='login')
    {
        if(!empty($data))
        {
            $login=$data;
            echo '{"from_id":"'.$id.'","root_id":"'.$login.'","root_label":"'.$login.'","type":"username","imageurl":"/img/icon/username.png","title":"Gitte 的登录名","raw_data":"","edge_color":"yellow","edge_label":"Gitte 接口"},';
        }
    }   
    if($name=='name')
    {
        if(!empty($data))
        {
            $nickname=$data;
           //       echo '{"from_id":"'.$id.'","root_id":"'.$nickname.'","root_label":"'.$nickname.'","type":"username","imageurl":"/img/icon/username.png","title":"Gitte 的用户名,注册时间:'.$time.'","raw_data":"","edge_color":"yellow","edge_label":"Gitte 接口"},';
        }
    }
    if($name=='blog')
    {
        if(!empty($data))
        {
            $blog=$data;
            echo '{"from_id":"'.$id.'","root_id":"'.$blog.'","root_label":"'.$blog.'","type":"url","imageurl":"/img/icon/url.png","title":"Gitte 填写的博客","raw_data":"","edge_color":"yellow","edge_label":"Gitte 接口"},';
        }
    }
    if($name=='weibo')
    {
        if(!empty($data))
        {
            $weibo=$data;
            echo '{"from_id":"'.$id.'","root_id":"'.$weibo.'","root_label":"'.$weibo.'","type":"url","imageurl":"/img/icon/url.png","title":"Gitte 填写的微博URL","raw_data":"","edge_color":"yellow","edge_label":"Gitte 接口"},';
        }
    }
    if($name=='bio')
    {
        if(!empty($data))
        {
            $bio=$data;
            if(strlen($bio)>16)
            {
            echo '{"from_id":"'.$id.'","root_id":"'.$bio.'","root_label":"'.$bio.'","type":"unknown","imageurl":"/img/icon/unknown.png","title":"Gitte 填写的BIO","raw_data":"","edge_color":"yellow","edge_label":"Gitte 接口"},';
        }
    }
    }
    if($name=='created_at')
    {
        if(!empty($data))
        {
            $time=$data;
            echo '{"from_id":"'.$id.'","root_id":"'.$nickname.'","root_label":"'.$nickname.'","type":"username","imageurl":"/img/icon/username.png","title":"Gitte 的用户名,注册时间:'.$time.'","raw_data":"","edge_color":"yellow","edge_label":"Gitte 接口"},';
        }
    }
    if($name=='company')
    {
        if(!empty($data))
        {
            $company=$data;
            echo '{"from_id":"'.$id.'","root_id":"'.$company.'","root_label":"'.$company.'","type":"unknown","imageurl":"/img/icon/unknown.png","title":"Gitte 填写的公司","raw_data":"","edge_color":"yellow","edge_label":"Gitte 接口"},';
        }
    }
    if($name=='profession')
    {
        if(!empty($data))
        {
            $profession=$data;
            echo '{"from_id":"'.$id.'","root_id":"'.$profession.'","root_label":"'.$profession.'","type":"unknown","imageurl":"/img/icon/unknown.png","title":"Gitte 填写的职业","raw_data":"","edge_color":"yellow","edge_label":"Gitte 接口"},';
        }
    }
    if($name=='wechat')
    {
        if(!empty($data))
        {
            $wechat=$data;
            echo '{"from_id":"'.$id.'","root_id":"'.$wechat.'","root_label":"'.$wechat.'","type":"unknown","imageurl":"/img/icon/unknown.png","title":"Gitte 填写的微信","raw_data":"","edge_color":"yellow","edge_label":"Gitte 接口"},'; 
        }
    }
    if($name=='qq')
    {
        if(!empty($data))
        {
            $qq=$data;
            echo '{"from_id":"'.$id.'","root_id":"'.$qq.'","root_label":"'.$qq.'","type":"unknown","imageurl":"/img/icon/unknown.png","title":"Gitte 填写的QQ","raw_data":"","edge_color":"yellow","edge_label":"Gitte 接口"},'; 
        }
    }
    if($name=='linkedin')
    {
        if(!empty($data))
        {
            $linkedin=$data;
            echo '{"from_id":"'.$id.'","root_id":"'.$linkedin.'","root_label":"'.$linkedin.'","type":"unknown","imageurl":"/img/icon/unknown.png","title":"Gitte 填写的Linkedin","raw_data":"","edge_color":"yellow","edge_label":"Gitte 接口"},'; 
        }
    }
    if($name=='email')
    {
        if(!empty($data))
        {
            $email=$data;
            echo '{"from_id":"'.$id.'","root_id":"'.$email.'","root_label":"'.$email.'","type":"email","imageurl":"/img/icon/email.png","title":"Gitte 填写的邮箱","raw_data":"","edge_color":"yellow","edge_label":"Gitte 接口"},'; 
        }
    }
}

echo '{}]';
?>