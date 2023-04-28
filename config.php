<?php
     $config=array(
        'username' => 'admin', // #
        'password' => 'admin', // #
        'fofa_key' =>'',
        'fofa_email' =>'',
        'xbook_key' =>'',
        'github_api' =>'',     // #
        'gaode_apikey' => '',  
        'gitee_token' =>  '',  // #
        'openAI_key' => '',    
        'X-RapidAPI-Key' => '' // # 
         // # 为当前版本需要的，后续版本使用的api会更多
         // 
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
exit;
}


?>