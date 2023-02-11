#!/bin/bash
developer=$(cat $1)
rm -f *_score
function getinfo()
{
for phone in $developer 
do 
{
./360_reg.sh $phone &
./dbappsecurity_reg.sh $phone &
./qianxin.sh $phone &
./nsfocus.sh $phone &
# ./proginn_reg.sh $phone &
# 这里虽然是程序员招聘，但是很多时候都有一堆号码只注册了这个，就很离谱，建议注释起来
./hetian_reg.sh $phone &
./speedtest.sh $phone &
} &
done 
wait
}
function count()
{
for file in $(ls ./ | grep '_score')
do
echo ""
phone=$(echo $file | sed -e 's/_/ /g' | awk '{print $1}') 
site=$(cat $file | sed -e 's/:/ /g' | awk '{print $1}' | xargs | sed -e 's/ /,/g')
useage=$(cat $file | sed -e 's/:/ /g' | awk '{print $2}' | xargs | sed -e 's/ /,/g')
echo "# $phone 注册数据"
echo "# 网站：$site"
echo "# 画像: $useage"
rm -f $file
done 
}

getinfo
count
