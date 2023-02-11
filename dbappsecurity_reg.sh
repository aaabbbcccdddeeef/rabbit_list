#!/bin/bash
curl -s -m 5 --retry 5 -H 'Host: ti.dbappsecurity.com.cn' "https://ti.dbappsecurity.com.cn/web/system/user/hasLoginName?username=$1&type=2" -o dbappsecurity_$1
result=$(cat dbappsecurity_$1 | sed -e 's/,/ /g' | awk '{for(i=1;i<=NF;i++){print $i}}' | sed -e 's/"//g' | grep '^data' | sed -e 's/}//g' | sed -e 's/:/ /g' | awk '{print $2}' | sed -e 's/false/未注册/g' -e 's/true/已注册/g' -e "s/^/# 安恒 $1/g")
test=$(echo $result | grep '已注册')
test_test=${#test}
if [ $test_test != 0 ]
then 
echo "安全星图:蓝队" >> $1_score
fi 
# echo "$result"
rm -f dbappsecurity_$1