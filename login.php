<?php 
include_once __DIR__ . '/config.php';
$username=$_GET['username'];
$password=$_GET['password'];
function showlogin()
{
header("Location: /login.html");
}

function login($username,$password,$config)
{
if($username==getconfig('username',$config))
{
    if($password==getconfig('password',$config))
    { 
        $session=md5($username,$password);
        setcookie('username',$username);
        setcookie('password',$password);
        setcookie('session',$session); // 唬人的
        header("Location: /index.php");
        return 1;
    }
}
return 0;
}
if(!empty($username))
{
    if(!empty($password))
    {
        if(login($username,$password,$config)==0)
        {
            showlogin();
        } 
        else
        {
        header("Location: /index.php");   
        }
    }
}
else
{
    showlogin();
    exit;
}
?>