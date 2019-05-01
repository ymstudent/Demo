#!/bin/bash
#检查服务是否可用脚本
count=`ps -ef | grep "swoole" | grep -v "grep" | grep "master" | wc -l`

if [ $count -lt 1 ]; then
ps -ef | grep "swoole" | grep -v "grep" | awk '{print $2}' |xargs kill -9
sleep 2
ulimit -c unlimited
Path=`pwd`
cd ${Path} && php TcpServer.php
echo ""$(date +%Y-%m-%d_%H:%M:%S)" restart" >> /tmp/swoole_retart.log
fi