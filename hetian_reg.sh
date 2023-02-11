#!/bin/bash
# email phone 
# curl -s -H "Host: www.hetianlab.com" --data-binary $'phoneNo=$phone' "https://www.hetianlab.com/forget!forPwdSendCode.action"
# 发送验证码（若注册），备用
curl -s -m 5 --retry 5 -H 'Content-Type: application/x-www-form-urlencoded; charset=gbk' -H 'Dnt: 1' -H 'Host: www.hetianlab.com' -d "usermail=$1" 'https://www.hetianlab.com/regist!checkUserPhone.action' -o hetianlab_$1
result=$(cat hetianlab_$1 | sed -e 's/,/ /g' | awk '{for(i=1;i<=NF;i++){print $i}}' | sed -e 's/"//g' | grep '^message' | sed -e 's/}//g' | sed -e 's/message://g' -e 's/可以用。/未注册/g' | sed -e "s/^/# 合天网安实验室 $1 /g")
test=$(echo $result | grep '已注册')
test_test=${#test}
if [ $test_test != 0 ]
then 
echo "合天网安:学习" >> $1_score
fi 
# echo $result
rm -f hetianlab_$1
# result=$(iconv -f gbk -t UTF-8 -c hetianlab_$1)
# rm -f hetianlab_$1

