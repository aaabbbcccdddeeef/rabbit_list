<?php
include_once __DIR__ . '/config.php';
access_by_cookie($config,$_COOKIE);
if($_GET['input'])
{
    $input=$_GET['input'];
}
if($_POST['input'])
{
    $input=$_POST['input'];
}
if($_GET['type'])
{
    $type=$_GET['type'];
}
if($_POST['type'])
{
    $type=$_POST['type'];
}

function domain2uin($domain)
{
   $length=count(explode('.',$domain));
   for($i=0;$i<$length;$i++)
   {
   if($i>$length-3)
   {
    if(!empty($data))
    {
        $data=$data.'.'.explode('.',$domain)[$i];
    }
    else
    {
        $data=explode('.',$domain)[$i];
    }
   }
   }
   return $data;
}

function email2name($email)
{
    $name='';
    foreach(str_split($email) as $part)
    {
        if($part=='@')
        {
            return $name;
        }
        else
        {
        if(!empty($part))
        {
        $name=$name.$part;
        }    
        }
    }
    return $name;
}

function url2domain($url)
{
return (explode('/',$url)[2]);
}

// 输出结果
switch($type)
{
    case 'email':
        if(!empty($input))
        {
            // echo $input;
            $name=str_replace('.','-',email2name($input));
            echo ",$name";
            $domain=str_replace($name.'@','',$input);
            echo ",$domain";            
        }
    break;
    case 'url':
        if(!empty($input))
        {
            // echo $input;
            $domain=url2domain($input);
            echo ",$domain";
        }
    break; 
    case 'domain':
    if(!empty($input))
    {
        echo domain2uin($input);
    }
    break;     
    default:

}

exit;
?>