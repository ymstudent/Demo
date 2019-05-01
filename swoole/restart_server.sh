#!/bin/bash
#重新启动服务脚本
Pid=`ps -ef | grep "swoole" | grep -v "grep" | grep "master" | awk '{print $2}'`
if [ $Pid ]
then
kill -TERM $Pid
echo "Swoole server shutdown success\r\n"
fi
Path=`pwd`
cd $Path && php TcpServer.php
echo "Swoole server restart success\r\n"