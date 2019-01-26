#监控文件，然后根据端口号杀死僵尸进程
#!/bin/bash
f_path=`pwd`
while true
do
    for i in `seq 0 7`
    do
        port=`expr 1111 + $i \* 1000`
        m_name=""$f_path"/monitor"$port".txt"   #被监控的文件
        if [ ! -f $m_name ]; then continue; fi;
        echo "开始检查$port"
        u_time=`stat -c %Y $m_name`  #获取文件的修改时间（秒为单位）
	    n_time=`date +%s`			#获取当前系统的时间 （秒为单位）
	    if [ `expr $n_time - $u_time` -gt 1200 ]; then  #判断当前时间和文件修改时间差（20分钟）
	        pid=$(netstat -nlp | grep :$port | awk '{print $6}' | awk -F"/" '{ print $1 }')    #根据端口号查询对应的pid
	        if [  -n  "$pid"  ]; then
	            echo "kill $port"
                kill -9 $pid;     #杀掉对应的进程，如果pid不存在，则不执行
                `rm $f_path`;    #删除对应监控文件
            fi
	    fi
    done
    sleep 10 #10秒循环一次