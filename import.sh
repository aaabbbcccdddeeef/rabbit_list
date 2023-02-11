#!/bin/bash
rm -f text_log
function main()
{
echo "# 请在使用本功能之前备份你的通讯录！！！"
echo "# 若你不是使用模拟器，并且未备份数据造成数据丢失，我概不负责！！！ "
while((1))
do 
read -p "是否确认备份完成? (y/n) " choose
if [ $choose == 'y' ]
then
echo "# 确定继续"
break 
fi 
done 
echo "# 生成文件..."
rm -f import.vcf 
for phone in $(cat ./proble_phone_list)
do 
echo "BEGIN:VCARD" >> import.vcf 
echo "VERSION:3.0" >> import.vcf 
echo "N:$phone;;;;" >> import.vcf 
echo "TEL;TYPE=cell:$phone" >> import.vcf 
echo "END:VCARD" >> import.vcf 
done 
echo "# 配置文件生成成功"
while((1))
do 
read -p "再次确定是否确认备份完成? (y/n) " choose
if [ $choose == 'y' ]
then
echo "# 确定继续"
break 
fi 
done 
while((1))
do 
read -p "# 确定是否确连接adb? (y/n) " choose
if [ $choose == 'y' ]
then
echo "# 确定继续"
break 
fi 
done 
}

function android()
{
adb push ./import.vcf /sdcard/
adb shell am start -t "text/x-vcard" -d "file:///sdcard/import.vcf" -a android.intent.action.VIEW com.android.contacts
}

function start()
{  
echo "# 请打开微信，钉钉，qq，百度网盘等社交软件的手机联系人，注意不要使用支付宝，会被警告"
echo "# 如果有模拟用户点击，请打开"
read -p "# 准确就绪按enter键"
while((1))
do 
back=$result  
adb exec-out uiautomator dump > null
rm -f null
adb pull /sdcard/window_dump.xml ./
result=$(adb shell cat /sdcard/window_dump.xml | awk '{for(i=1;i<=NF;i++){print $i}}' | sed -e 's/""/null/g' -e 's/"//g' | grep '^text=' | grep -v 'text=null' | grep -v '通讯录')
adb shell input swipe 1000 2500 1000 1200
if [ "$result" == "$back" ]
then 
echo "# 数据获取结束"
read -p "# 是否继续（y/n）" next
if [ $next == 'n' ]
then
echo "# 数据保存在 ./text_log"
break 
fi 
else
echo "$result"
echo "$result" >> ./text_log
fi 
done 
}
main
android
start
 echo "# 微信"
 cat ./text_log | grep -A 1 '微信' 
 read -p "# 按enter键继续"
 echo "# 钉钉"
 cat ./text_log | grep -B 3 '钉钉' | grep -v '添加'
 read -p "# 按enter键继续"
 # 敬请期待