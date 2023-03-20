#!/bin/bash
function config()
{
    cat ./config.ini | grep -v '^#' | grep "$1" | sed -e 's/=/ /g' | awk '{print $2}'
}
# 配置文件读取
host=$(config clickhouse_host)
port=$(config clickhouse_port)
username=$(config clickhouse_username)
password=$(config clickhouse_password)
dbname=$(config clickhouse_dbname)
tbname=$(echo $1 | sed -e 's/_/ /g' -e 's/\./ /g' | awk '{print $1}')
# sed -e 's/,,/,?,/g' -i $1
need=$(head -n 1 $1 | sed -e 's/,/ String default null,/g' -e 's/$/ String default null/g')
echo "$need"
# 如果没有字段库，创建字段库 
echo "create database IF NOT EXISTS keyword" | clickhouse-client --password $password -m --host $host -u $username --port $port
# 是否执行导入
while((1))
do 
read -p '数据是否符合要求(y/n)' char
if [ $char == 'y' ]
then 
break
fi 
done
function check()
{
result=$(echo "show tables" | clickhouse-client --password $password -d $dbname -m --host $host -u $username --port $port | grep "$tbname")
test=${#result}
if [ $test != 0 ]
then 
echo "# 表 $tbname 已存在!"
echo "# 如需上传,请重命名"
exit
fi 
}
check
# 遍历keyword,添加对应表名到keyword下
for keyword in $(head -n 1 $1 | sed -e 's/,/ /g')
do
# 创建对应表的字段
echo "create table IF NOT EXISTS keyword.$keyword(tbname String,insert_time Date default now())ENGINE =MergeTree() PARTITION BY toYYYYMM(insert_time) PRIMARY KEY (intHash32(insert_time)) ORDER BY intHash32(insert_time) SAMPLE BY intHash32(insert_time) SETTINGS index_granularity= 8192" | clickhouse-client --password $password -d $dbname -m --host $host -u $username --port $port
echo "insert into keyword.$keyword(tbname) Values('$dbname.$tbname')" | clickhouse-client --password $password -d $dbname -m --host $host -u $username --port $port
echo "# 添加 $tbname 到 $keyword 表"
done 
echo "# 上传数据 $1"
create="create table IF NOT EXISTS $tbname($need,insert_time Date default now())ENGINE =MergeTree() PARTITION BY toYYYYMM(insert_time) PRIMARY KEY (intHash32(insert_time)) ORDER BY intHash32(insert_time) SAMPLE BY intHash32(insert_time) SETTINGS index_granularity= 8192"
echo $create | clickhouse-client --password $password -d $dbname -m --host $host -u $username --port $port
cat $1 | clickhouse-client --password $password -d $dbname -m --host $host -u $username --port $port --ignore-error --input_format_allow_errors_num 100000000000000 --format_csv_delimiter="," --query="INSERT INTO default.$tbname FORMAT CSV"
echo "# 数据导入完成"
