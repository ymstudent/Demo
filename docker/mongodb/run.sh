#!/bin/bash
if [ ! -f /.mongodb_password_set ]; then
    /set_mongodb_password.sh
fi

#设置mongodb启动参数
if [ "$AUTH" == "yes" ]; then
    export mongodb='/usr/bin/mongod -nojournal --auth --httpinterface --rest'
else
    export mongodb='/usr/bin/mongod -nojournal --httpinterface --rest'
fi

if [ ! -f /data/mongodb/mongod.lock ]; then
    eval $mongodb
else
    export mongodb=$mongodb' --dbpath /data/mongodb'
    rm /data/lib/mongod.lock
    mongod --dbpath /data/mongodb --repair && eval $mongodb
fi