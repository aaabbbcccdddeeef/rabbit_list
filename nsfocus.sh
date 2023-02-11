#!/bin/bash
curl -s -m 5 --retry 5 -H 'Host: poma.nsfocus.com' -H 'Accept: application/json, text/plain, */*' -H 'Accept-Language: zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2' -H 'Accept-Encoding: gzip, deflate' -H 'X-Requested-With: XMLHttpRequest' -H 'Content-Type: application/json;charset=utf-8' -H 'Origin: https://poma.nsfocus.com' -H 'Dnt: 1' -H 'Referer: https://poma.nsfocus.com/'  --data-binary "{\"field\":\"mobile\",\"value\":\"$1\"}" 'https://poma.nsfocus.com/api/krosa/poma/v3/auth/checkUnique/' -o $1_nsfocus
result=$(cat ./$1_nsfocus | sed -e 's/,/ /g' | awk '{for(i=1;i<=NF;i++){print $i}}' | sed -e 's/"//g' -e 's/}//g' -e 's/{//g' | grep 'result:unique:' | sed -e 's/result:unique://g')
if [ $result == 'true' ]
then 
rm -f $1_nsfocus
# echo "# 绿盟 $1 未注册"
elif [ $result == 'false' ]
then 
# echo "# 绿盟 $1 已注册"
echo "绿盟:蓝队" >> $1_score
fi 
rm -f $1_nsfocus