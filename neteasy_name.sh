#!/bin/bash
curl -s -m 10 --retry 1024 -H 'Host: reg1.vip.163.com' -H 'Accept: application/json, text/plain, */*' -H 'Content-Type: application/x-www-form-urlencoded'  --data-binary "username=$1&domain=vip.163.com" 'https://reg1.vip.163.com/newReg1/api/checkUsername.m' -o neteasy_1_$1 &
curl -s -m 10 --retry 1024 -H 'Host: reg1.vip.163.com' -H 'Accept: application/json, text/plain, */*' -H 'Content-Type: application/x-www-form-urlencoded'  --data-binary "username=$1&domain=vip.126.com" 'https://reg1.vip.163.com/newReg1/api/checkUsername.m' -o neteasy_2_$1 &
curl -s -m 10 --retry 1024 -H 'Host: reg1.vip.163.com' -H 'Accept: application/json, text/plain, */*' -H 'Content-Type: application/x-www-form-urlencoded'  --data-binary "username=$1&domain=188.com" 'https://reg1.vip.163.com/newReg1/api/checkUsername.m' -o neteasy_3_$1 &
wait
cat ./neteasy_1_$1 ./neteasy_2_$1 ./neteasy_3_$1 > neteasy_all_$1
rm -f neteasy_1_$1 neteasy_2_$1 neteasy_3_$1
result=$(cat neteasy_all_$1 | sed -e 's/,/ /g' -e 's/{/ /g' | awk '{for(i=1;i<=NF;i++){print $i}}' | sed -e 's/"//g' |  grep '^valid' | sed -e 's/valid://g')
rm -f neteasy_all_$1
num=1
for result in $result
do 
if [ $num == 1 ]
then 
add="vip.163.com"
fi
if [ $num == 2 ]
then 
add="vip.126.com"
fi
if [ $num == 3 ]
then 
add="188.com"
fi
if [ $result == 'true' ]
then 
echo "# $1@$add 未注册"
else 
echo "# $1@$add 已注册"
fi 
let num=$num+1
done 