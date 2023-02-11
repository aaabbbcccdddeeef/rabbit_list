#!/bin/bash
tmp=$(ls | grep 'tmp')
test_tmp=${#tmp}
bak=$(ls | grep 'bak')
test_bak=${#bak}
if [ $test_bak == '0' ]
then 
mkdir bak
fi
if [ $test_tmp == '0' ]
then  
mkdir tmp
fi 
if [ $# == 0 ]
then 
echo "# eg: ./stalin_list.sh --help"
echo "# show help tags"
exit
fi
function printlogo()
{
echo -e "
薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇
薇薇薇薇　　　　　薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇　　　薇薇薇薇薇薇薇　　　薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇　　　薇薇薇薇薇薇薇薇薇薇　　　薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇
薇薇　　　　　　　　薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇　　　薇薇薇薇薇薇薇　　　薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇　　　薇薇薇薇薇薇薇薇薇薇　　　薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇
薇薇　　　薇薇　　　　薇薇薇　　　薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇　　　薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇　　　薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇　　　薇薇薇薇薇
薇薇　　　薇薇　　　　薇薇薇　　　薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇　　　薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇　　　薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇　　　薇薇薇薇薇
薇薇　　　薇薇薇薇薇薇薇薇薇　　　薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇　　　薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇　　　薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇　　　薇薇薇薇薇
薇薇　　　　薇薇薇薇薇　　　　　　　　　薇薇薇薇　　　　　　薇薇薇薇薇薇　　　薇薇薇薇薇薇薇　　　薇薇薇薇　　　　　　　　　薇薇薇薇　　　薇薇薇薇薇薇薇薇薇薇　　　薇薇薇薇薇　　　　　　　薇薇　　　　　　　　　薇薇
薇薇薇　　　　　　薇薇薇薇薇　　　薇薇薇薇薇薇　　　薇薇　　　薇薇薇薇薇　　　薇薇薇薇薇薇薇　　　薇薇薇薇　　　　　薇　　　薇薇薇薇　　　薇薇薇薇薇薇薇薇薇薇　　　薇薇薇薇薇　　　薇薇　　　薇薇薇薇　　　薇薇薇薇薇
薇薇薇薇薇　　　　　薇薇薇薇　　　薇薇薇薇薇薇　薇薇薇薇　　　薇薇薇薇薇　　　薇薇薇薇薇薇薇　　　薇薇薇薇　　　　薇薇　　　薇薇薇薇　　　薇薇薇薇薇薇薇薇薇薇　　　薇薇薇薇薇　　　薇薇薇薇薇薇薇薇薇　　　薇薇薇薇薇
薇薇薇薇薇薇薇　　　　薇薇薇　　　薇薇薇薇薇薇薇薇薇　　　　　薇薇薇薇薇　　　薇薇薇薇薇薇薇　　　薇薇薇薇　　　薇薇薇　　　薇薇薇薇　　　薇薇薇薇薇薇薇薇薇薇　　　薇薇薇薇薇　　　　　薇薇薇薇薇薇薇　　　薇薇薇薇薇
薇　　　　薇薇薇　　　薇薇薇　　　薇薇薇薇薇薇　　　　　　　　薇薇薇薇薇　　　薇薇薇薇薇薇薇　　　薇薇薇薇　　　薇薇薇　　　薇薇薇薇　　　薇薇薇薇薇薇薇薇薇薇　　　薇薇薇薇薇薇　　　　　　薇薇薇薇薇　　　薇薇薇薇薇
薇　　　　薇薇薇　　　薇薇薇　　　薇薇薇薇薇　　　薇薇薇　　　薇薇薇薇薇　　　薇薇薇薇薇薇薇　　　薇薇薇薇　　　薇薇薇　　　薇薇薇薇　　　薇薇薇薇薇薇薇薇薇薇　　　薇薇薇薇薇薇薇薇薇薇　　　薇薇薇薇　　　薇薇薇薇薇
薇薇　　　薇薇　　　　薇薇薇　　　薇薇薇薇薇　　　薇薇　　　　薇薇薇薇薇　　　薇薇薇薇薇薇薇　　　薇薇薇薇　　　薇薇薇　　　薇薇薇薇　　　薇薇薇薇薇薇薇薇薇薇　　　薇薇薇薇　　　薇薇薇　　　薇薇薇薇　　　薇薇薇薇薇
薇薇　　　　　　　　薇薇薇薇薇　　　　　　薇　　　　　　　　　薇薇薇薇薇　　　薇薇薇薇薇薇薇　　　薇薇薇薇　　　薇薇薇　　　薇薇薇薇　　　　　　　　　薇薇薇薇　　　薇薇薇薇薇　　　　　　　　薇薇薇薇　　　　　　　薇
薇薇薇薇　　　　　薇薇薇薇薇薇薇　　　　　薇薇薇　　　　　　　　薇薇薇薇　　　薇薇薇薇薇薇薇　　　薇薇薇薇　　　薇薇薇　　　薇薇薇薇　　　　　　　　　薇薇薇薇　　　薇薇薇薇薇薇　　　　　薇薇薇薇薇薇薇　　　　　薇薇
薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇薇"
}
# printlogo
all=$(echo "$@" | awk '{for(i=1;i<=NF;i++){print $i}}')
front=null
for words in $all
do
if [ $words == '--help' ]
then 
echo "# stalin_list version 1 "
echo "# author: lidazhi"
echo "# OSINT && Infomation Gather && Hacker Geolocation Information Mapping && what's more.."
echo ""
echo "# --add_list"
echo "# eg: --add_list lvdouzhou"
echo "# useage: 添加一个用户名到名单"
echo ""
echo "# --del_list"
echo "# eg: --del_list lvdouzhou"
echo "# useage: 删除一个名单上的名字"
echo ""
echo "# --show_list"
echo "# eg: --show_list"
echo "# useage: 展示已有的名单"
echo ""
echo "# --chase"
echo "# eg: --chase username"
echo "# useage: 在 CSDN 上搜索一个用户名"
# echo ""
# echo "# --file_list"
# echo "# eg: --file_list ./bak/log"
# echo "# useage: set a file to save data that stalin_list had find,you don't have to set this if you don't need it"
echo ""
echo "# --find"
echo "# eg: --find lidazhi,1.1.1.1,男"
echo "# useage: 通过关键词从爬取到的内容中搜索 username,nickname,gender,email,position,school,company"
# echo ""
# echo "# --rank"
# echo "# eg: --rank lat:29.56278,lon:106.55278,rank:1000"
# echo "# useage: Set a latitude and longitude and range, look for the IPs contained in it and the information that is logged"
# echo "# careful: this funcation need a Expensive API that offer you Accurate IP location,you have to code a script your self,or it won't work"
# echo "# for more infomation to setup your own ip to location mode,please read ./config"
echo ""
echo "# --seek"
echo "# eg: --seek-username lidazhi"
echo "# useage: 基础功能，部分api需要配置，可以利用爬取各个开发者平台的公开数据并展示，搜索枚举泄漏数据，用户名注册网站等等"
echo ""
# echo "# eg: --seek email:lidazhi@qq.com"
# echo "# useage: this mode are also use crawer to get infomation about this email"
# echo ""
echo "# eg: --seek-phone-byguess 188919950%%"
echo "# useage: 枚举可能的号码列表，缺失部分使用%代替"
echo ""
echo "# eg: --seek-phone-bylocation city:毕节,province:贵州,start:147,end:1576"
echo "# useage: 通过地点枚举号段，末尾缺失部分也可以用%代替，会自动补全数据,手机号相关数据数据默认都保存在 ./proble_phone_list"
echo ""
echo "# eg: --seek-phone-bySET"
echo "# useage: 需要一台安卓手机，打开adb，如果有模拟触控，也请打开，根据提示，进行操作，注意您的数据并不会上传到任何云端，但结束使用后记得关闭这两个功能"
echo "# "
echo "# eg: --seek-phone-bySET-getalive"
echo "# useage: 运行完 --seek-phone-bySET 选项，您可以再通过您捕获的数据排除空号，这将使数据更加准确，同时也是免费的"
echo ""
echo "# eg: --seek-phone-bySET-regtest"
echo "# useage: 这将使用本地的注册检测模块对指定号码进行注册检测，未防止滥用，收录不多，只检测开发者和黑客使用的平台"
echo "# --rm "
echo "# eg: --rm phone_log"
echo "# useage: 删除指定内容的缓存，可选字段是 phone_log,username_log,email_log,ip_log"
# echo "# eg: --seek ip:1.1.1.1"
# echo "# useage:find ip infomations on zoomeye,fofa,xthreatbook,may contains Threat intelligence,IP assets,domain infomation.."
# echo "# for more threat intelligence in China,you should try https://x.treatbook.com/"
# echo ""
# echo "# eg: --seek domain:qq.com"
# echo "# useage: find emails reletive to this domain,find ip,treat intelligence,register infomation,domain Record,urls..."
exit
elif [ $front == '--find' ]
then 
./search.sh $words
elif [ $front == '--del_list' ]
then 
sed -e "s/$words//g" -i ./list
sed '/^[[:space:]]*$/d' -i ./list
elif [ $front == '--add_list' ]
then 
echo "$words" >> ./list
echo "# 成功将 $words 添加到监测名单"
echo "# 共 $(cat ./list | wc | awk '{print $1}') 条记录"
elif [ $words == '--show_list' ]
then
echo "#"
echo "# 监视名单" 
cat ./list | sed -e 's/^/# /g'
line=$(cat ./list | wc | awk '{print $1}')
echo "#"
echo "# 记录ip"
cat ./bak/iplist | sed -e 's/^/# /g'
line1=$(cat ./bak/iplist | wc | awk '{print $1}')
echo "#"
echo "# 共监视 $line 个 关键词,共 $line1 个 ip 记录"
elif [ $front == '--seek-username' ]
then 
username=$words
./username.sh $username
elif [ $front == '--seek-phone-byguess' ]
then 
./guess_phones.sh $words
elif [ $front == '--seek-phone-bylocation' ]
then 
./location2phones.sh $words
elif [ $words == '--seek-phone-bySET' ]
then 
./import.sh 
elif [ $words == '--seek-phone-bySET-getalive' ]
then
echo "# 源数据 $(cat ./proble_phone_list | wc | awk '{print $1}') 行" 
cat text_log | grep '[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]' | sed -e 's/text=//g' | sort | uniq > ./proble_phone_list
echo "# 数据已更新！"
echo "# 总计 $(cat ./proble_phone_list | wc | awk '{print $1}') 行"
elif [ $words == '--seek-phone-bySET-regtest' ]
then 
echo "# 检测需要一定的时间，请不要关闭窗口"
./developer_finder.sh ./proble_phone_list
wait
clear
elif [ $front == '--seek-phone-bySET-regtest' ]
then 
file=$(ls | grep "$words")
test=${#file}
if [ $test != 0 ]
then
./developer_finder.sh $words
wait 
clear
else 
echo "# 找不到 $words"  
fi 
fi 
front=$words
done 
