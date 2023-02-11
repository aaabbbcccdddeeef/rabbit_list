#!/bin/bash 
curl --http2 -s -m 5 --retry 5  -H 'Host: mail.sina.com.cn' -H 'User-Agent: Mozilla/5.0 (X11; CrOS x86_64 14794.0.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5045.0 Safari/537.36' -H 'Accept: */*' -H 'Accept-Language: zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2' -H 'Accept-Encoding: gzip, deflate' -H 'Content-Type: application/x-www-form-urlencoded;charset=UTF-8' -H 'Origin: https://mail.sina.com.cn' -H 'Dnt: 1' -H 'Referer: https://mail.sina.com.cn/register/regmail.php'  --data-binary "mail=$1%40sina.cn" 'https://mail.sina.com.cn/register/chkmail.php' -o $1_sina
result=$(cat $1_sina | gunzip | sed -e 's/{//g' -e 's/,/ /g' -e 's/"//g' | awk '{for(i=1;i<=NF;i++){print $i}}' | grep '^msg:' | sed -e 's/msg://g' -e "s/^/# sina $1 /g" -e 's/mailname_exists/已注册/g')
rm -f $1_sina
test=$(echo $result | grep '已注册')
test1=${#test}
if [ $test1 != 0 ]
then 
echo "$result"
fi 