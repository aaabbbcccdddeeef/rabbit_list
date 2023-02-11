#!/bin/bash
curl -m 5 --retry 5 -s -k -X 'POST' -H 'Host: i.360.cn' -H 'Accept: */*' -H 'Accept-Language: zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2' -H 'Accept-Encoding: gzip, deflate' -H 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8' -H 'X-Requested-With: XMLHttpRequest' -H 'Origin: https://i.360.cn' -H 'Referer: https://i.360.cn/findpwdwap'  --data-binary "account=$(echo $1 | sed -e 's/%40/@/g')&src=pcw_i360&quc_lang=zh&captcha=8866&requestScema=https&vc=1&sms_channel=&_=" 'https://i.360.cn/findpwdwap/getUserSecInfo' -o 360_$1
result=$(cat 360_$1 | sed -e 's/ /+/g' -e 's/,/ /g' | awk '{for(i=1;i<=NF;i++){print $i}}' | grep 'errmsg' | sed -e 's/"//g' -e 's/}//g' -e 's/errmsg://g' -e 's/The+account+does+not+exist/未注册/g' -e 's/Invalid+request/已注册/g' | sed -e "s/^/# 360 $1 /g")
rm 360_$1
test=$(echo $result | grep '已注册')
test_test=${#test}
if [ $test_test != 0 ]
then 
echo "360:红蓝队" >> $1_score
fi 
# echo "$result"