<?php
# 输入变量
$input=$_GET['input'];
# url 生成    
$realname_reg = '/"realname":"(.*)","tags":/i';
preg_match_all($realname_reg, $datanum,$result);
$realname=$result[1][0];
$email_reg='/","email":"(.*)","length_statis":/i';
preg_match_all($email_reg, $datanum,$result);
$email=$result[1][0];
$position_reg='/","position":"(.*)","biz_id":"/i';
preg_match_all($position_reg, $datanum,$result);
$position=$result[1][0];
$username_reg='/"username":"(.*)","eventView"/i';
preg_match_all($username_reg, $datanum,$result);
$username=$result[1][0];
if(strlen($username)>=4)
{
    echo "<newnode>,$username,$realname,$email,$position,";
    // $showresult[]=$str;
    // echo "<br>";
}
}


$page_reg='/"total_page":(.*)\.0,"js_insert_first":/i';
preg_match_all($page_reg, $output_data,$result);
$pageend=$result[1][0];
if($page==$pageend)
{
    break;    
}
$page++;
if($page>=10)
{
    break;
}
}
# 结果输出
?>