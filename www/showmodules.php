<?php 
include_once __DIR__ . '/config.php';
access_by_cookie($config,$_COOKIE);
$err='Warning: opendir';
$mode=$_GET['mode'];
if(!$mode)
{
	$dir_path = './modules/';
}
else
{
	$dir_path='./modules/'.$mode;
}
    try{
		
	
	$dir = opendir($dir_path);
	echo "#";
	while($file_name = readdir($dir)) 
	{
		if($file_name != '.' && $file_name != '..') {
			if($file_name=='develop')
			{
			continue;	
			}
			echo $file_name."#";
		}
	}
	closedir($dir);
}
catch(Exception $nothing){
exit;
}
?>