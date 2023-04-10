<?php
// clickhouse 数据库配置在 search.php 
// sgk 功能目前没开发完善，而且不是重点，可以忽略
     $config=array(
        'username' => 'admin', //登录帐号
        'password' => 'admin', // 登录密码
        'fofa_key' =>'',
        'fofa_email' =>'', // 目前用处不大
        'xbook_key' =>'', // 微步api，后续会开发不少基于这个的，建议搞一个
        'github_api' =>'', // github api 免费，涉及一个功能
        'aiqicha_cookie' => '', // 爱企查 cookie 涉及两个功能
        'gaode_apikey' => '' //白嫖，最好整一个 涉及两个功能
         
    );
function getconfig($type,$config)
{
    foreach($config as $keyname => $key)
    {
        if($type==$keyname)
        {
            return $key;
        }
    }
    return null;
}
function access_by_cookie($config,$COOKIE)
{
if(getconfig('username',$config)==$COOKIE['username'])
{
    if(getconfig('password',$config)==$COOKIE['password'])
    {
            return 1;
    }
}
setcookie('username','');
setcookie('password','');
header("Location: /login.html");
}


?>