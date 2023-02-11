#!/bin/bash
curl -s -m 5 --retry 3 -H 'Host: user.skyeye.qianxin.com' -H 'User-Agent: Mozilla/5.0 (X11; CrOS x86_64 14794.0.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5045.0 Safari/537.36' -H 'Accept: application/json, text/plain, */*' -H 'Accept-Language: zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2' -H 'Accept-Encoding: gzip, deflate' -H 'Content-Type: application/json' -H 'Origin: https://user.skyeye.qianxin.com' -H 'Dnt: 1' -H 'Referer: https://user.skyeye.qianxin.com/user/sign-in?next=https%3A//hunter.qianxin.com/api/uLogin' -b 'csrf_token=1; User-Center=1'  --data-binary "{\"phone\":\"$1\"}"  'https://user.skyeye.qianxin.com/user/check_phone?next=https%3A//hunter.qianxin.com/api/uLogin' -c cookie_$1 -o null
rm -f null
curl -s -m 5 --retry 3 -b @cookie_$1 -H 'Host: user.skyeye.qianxin.com' -H 'User-Agent: Mozilla/5.0 (X11; CrOS x86_64 14794.0.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5045.0 Safari/537.36' -H 'Accept: application/json, text/plain, */*' -H 'Accept-Language: zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2' -H 'Accept-Encoding: gzip, deflate' -H 'Content-Type: application/json' -H 'Origin: https://user.skyeye.qianxin.com' -H 'Dnt: 1' -H 'Referer: https://user.skyeye.qianxin.com/user/sign-in?next=https%3A//hunter.qianxin.com/api/uLogin'  --data-binary "{\"phone\":\"$1\"}"  'https://user.skyeye.qianxin.com/user/check_phone?next=https%3A//hunter.qianxin.com/api/uLogin' -o $1_result
result=$(cat $1_result  | sed -e 's/"//g' -e 's/,//g' -e 's/://g' | grep 'message' | awk '{print $2}')
if [ $result == '\u624b\u673a\u53f7\u5df2\u5b58\u5728' ]
then 
# echo "# 奇安信 $1 已注册"
echo "奇安信:红队" >> $1_score
else 
# echo "# 奇安信 $1 未注册"
rm -f cookie_$1 $1_result
fi 
rm -f cookie_$1 $1_result