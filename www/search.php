<?php
include_once __DIR__ . '/phpClickHouse/include.php';
include_once __DIR__ . '/config.php';
access_by_cookie($config,$_COOKIE);
$keyword_type=$_GET['keyword_type'];
$content=$_GET['content'];
$showtable=$_GET['showtable'];
#
$config = [
         'host' => '192.168.159.1',
         'port' => '8123',
         'username' => 'default',
         'password' => '123456'
        ];
# 配置
// $db->settings()->max_execution_time(200); //200s 最大请求执行时间
$db = new ClickHouseDB\Client($config);
$db->database('keyword');
$db->setTimeout(15);    // 1500 ms
$db->setTimeout(10);    // 10 seconds
$db->setConnectTimeOut(50); // 5 seconds 
// $db->ping();
if (!$db->ping()) echo 'Error connect';
# 测试
            $table_rows=$db->showTables();
           // print_r($table_rows);
           // echo '<br>';
            foreach($table_rows as $tbname=>$tb)
            {
                if(!$string)
                {
                    $string="$tbname";
                }
                else{
                    $string="$string".",$tbname";
                }
            }
if($showtable)
{
    echo "$string,";
    exit;
}
else{
    if(!$keyword_type)
{
    echo 'need keyword_type';
    exit;
}
if(!$content)
{
    echo 'need keyword_value';
    exit;
}
}
// echo "<script>console.log($string)</script>";            
$clickhouse_sql_result=$db->select("select tbname from keyword.$keyword_type")->rows();
// print_r($clickhouse_sql_result);
$tblist_lenth=count($clickhouse_sql_result);
for($x=0;$x<$tblist_lenth;$x++)
{
// print_r($clickhouse_sql_result[$x]);
// echo '<br>';   
$test=0;
foreach($clickhouse_sql_result[$x] as $nothing=>$tbname)
{
    $test++;
    if($test=1)
    {
    echo "tbname:$tbname";
    echo '<br>';
    echo '<br>';
    }
    $row_result=$db->select("select * EXCEPT(insert_time) from $tbname where $keyword_type like '%$content%' ")->rows();
    // print_r($row_result);
    $lenth_node=count($row_result);
    for($y=0;$y<$lenth_node;$y++)
    {
        $node=$row_result[$y];
        // print_r($node);
        foreach($node as $inuseful_node=>$nodename)
        {
            print_r($nodename); 
            echo '<br>';
        }
        echo '<br>';
    }
}
}
?>
