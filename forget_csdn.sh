#!/bin/bash
curl -s -m 10 --retry 5 "https://passport.csdn.net/v1/service/usernames/$1?comeFrom=0" | sed -e 's/,/ /g' -e 's/"//g' -e 's/}//g' -e 's/{//g' | awk '{for(i=1;i<=NF;i++){print $i}}' | grep -E 'mobile|^email' | sed -e 's/^/# /g'
