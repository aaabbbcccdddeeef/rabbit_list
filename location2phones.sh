#!/bin/bash 
rm -f ./proble_phone_list
province=$(echo "$1" | sed -e 's/,/ /g' | awk '{for(i=1;i<=NF;i++){print $i}}' | grep '^province:' | sed -e 's/province://g')
city=$(echo "$1" | sed -e 's/,/ /g' | awk '{for(i=1;i<=NF;i++){print $i}}' | grep '^city:' | sed -e 's/city://g')
start=$(echo "$1" | sed -e 's/,/ /g' | awk '{for(i=1;i<=NF;i++){print $i}}' | grep '^start:' | sed -e 's/start://g') 
end=$(echo "$1" | sed -e 's/,/ /g' | awk '{for(i=1;i<=NF;i++){print $i}}' | grep '^end:' | sed -e 's/end://g')

need_blank=$(echo $end | grep '%')
test_need_blank=${#need_blank}
echo "# province=$province"
echo "# city=$city"
echo "# start=$start"
echo "# end=$end"
result=$(cat ./regions.csv | grep "$province,$city," | sed -e 's/,/ /g' | awk '{print $1}')
# echo "$result"
for region_id in $result
do 
cat ./phones.csv | grep ",$region_id$" | sed -e 's/,/ /g' | awk '{print $2}' | grep "^$start" | sed "s/$/$end/g" >> ./proble_phone_list
done
if [ $test_need_blank != 0 ]
then 
echo "# 已自动枚举"
./guess_phones.sh $(cat ./proble_phone_list | xargs)
fi 
echo "# 总计 $(cat ./proble_phone_list | wc | awk '{print $1}') 个结果，保存在 ./proble_phone_list)"
echo "# 数据并非实时更新，仅作参考"