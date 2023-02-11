#!/bin/bash
curl -s -m 5 --retry 5 -H 'Host: b-api.speedtest.cn' -H 'User-Agent: Mozilla/5.0 (X11; CrOS x86_64 14794.0.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5045.0 Safari/537.36' -H 'Accept: application/json, text/plain, */*' -H 'Accept-Language: zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2' -H 'Accept-Encoding: gzip, deflate' -H 'Content-Type: application/x-www-form-urlencoded'  --data-binary "account=$1" 'https://b-api.speedtest.cn//login/checkPhoneMail' -o $1_speedtest
result=$(cat $1_speedtest | sed -e 's/,/ /g' -e 's/{/ /g' -e 's/}/ /g' | awk '{for(i=1;i<=NF;i++){print $i}}' | sed -e 's/"//g' | grep '^exist' | sed -e 's/exist://g')
if [ $result == 'false' ]
then 
# echo "# 测速网 $1 未注册"
rm -f  $1_speedtest
elif [ $result == 'true' ]
then 
# echo "# 测速网 $1 已注册" >> $1_score
echo "测速网:运维" >> $1_score
fi 
rm -f  $1_speedtest