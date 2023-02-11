#!/bin/bash
echo "# 用户名枚举邮箱"
echo "# 有一些提供商可能故意保留一些邮箱，或者存在关键字也显示已注册，实际木有，所以请自行甄别"
./vipsina.sh $username 
./sina.sh $username
./neteasy_name.sh $username
echo "# name=$username" 
echo "# 注册检测模块"
echo "# 博客相关"
./cnblog.sh $username | sed -e 's/^/# /g'
echo "# 域名相关"
./ipv6he.sh $username | sed -e 's/^/# ipv6he /g'
./godaddy.sh $username | sed -e 's/^/# /g'
echo "# 黑客论坛"
./52pj_username.sh $username
echo "# 开发相关"
echo "# leetcode"
./leetcode.sh $username
echo "# lintcode"
./lintcode.sh $username
github=$(./github.sh $username)
test_github=${#github}
if [ $test_github == 0 ]
then 
echo "# github: no such user"
else
echo "# github 数据" 
echo "$github"
fi 
freebuf=$(./freebuf.sh $username)
test_freebuf=${#freebuf}
if [ $test_freebuf != 0 ]
then 
echo "$freebuf" | sed -e 's/^/# /g'
else 
echo "# null"
fi
./chase.sh $username > /dev/null
echo "csdn $(./search.sh $username)" 
./forget_csdn.sh $username
echo "# 违禁词检测"
 ./abandon.sh $username 
echo "# breach 数据泄漏检测"
echo "# 此模块可能需要较好的网络和较长的检测时间，请耐心等待"
./breach.sh $username | sed -e 's/^/# /g'
echo "# 代码仓库泄漏检测"
./find_email.sh ${username}@ 
wait
./find_email.sh @${username}
wait
echo "# 域名注册测试"
# ./search_domain.sh $username
# 回炉重造了，先注释吧
echo "# 招聘数据测试"
./niuke.sh $username