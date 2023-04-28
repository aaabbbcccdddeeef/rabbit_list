<?php
include 'config.php';
access_by_cookie($config,$_COOKIE);
$dir = opendir('./img/icon/');
while($file_name = readdir($dir)) 
{
if($file_name !='.' && $file_name !='..')
{
    echo "$file_name#";
}
}
?>