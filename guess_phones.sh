#!/bin/bash
all=$(echo "$*" | awk '{for(i=1;i<=NF;i++){print $i}}')
rm -f ./proble_phone_list
function phone_list()
{
echo "$1" > ./phone_test_list    
while((1))
do 
cat ./phone_test_list | sort | uniq > ./phone_test_swap
cat ./phone_test_swap > ./phone_test_list
rm -f ./phone_test_swap
alline=$(cat ./phone_test_list)
for line in $alline
do 
check_line=$(echo $line | grep '%')
test_check_line=${#check_line}
if [ $check_line != 0 ]
then 
sed -e "s/$line//" -i ./phone_test_list
sed '/^[[:space:]]*$/d' -i ./phone_test_list
for i in `seq 0 9`
do 
# echo "$line"  | sed -e "s/%/$i/"
echo "$line"  | sed -e "s/%/$i/" >> ./phone_test_list
done 
fi 
done
result=$(cat ./phone_test_list | grep '%') 
test_result=${#result}
if [ $test_result == 0 ]
then 
break
fi 
done
cat ./phone_test_list 
}

for phone in $all
do 
lenth=${#phone}
if [ $lenth == '11' ]
then 
echo "# phone=$phone"
need_blank=$(echo "$phone" | grep '\%')
test_need_blank=${#need_blank}
if [ $test_need_blank != 0 ]
then 
nums=$(echo "$phone" | sed "s/[^\n]/&\n/g" | grep '\%' | wc | awk '{print $1}')
phone_lists=$(phone_list $phone)
echo "$phone_lists" >> proble_phone_list
else 
echo "$phone" >> proble_phone_list
fi 
else 
echo "# $phone 非中国号码，已排除"
fi 
done 
rm -f ./phone_test_list
cat ./proble_phone_list | sort | uniq > swap 
cat swap > ./proble_phone_list
lenth=$(cat swap | wc | awk '{print $1}')
rm -f swap
echo "# 总计 $lenth 个可能的手机号"