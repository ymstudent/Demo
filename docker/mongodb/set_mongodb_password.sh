#!/bin/bash
#此脚本用于设置mongodb的用户名与密码

#判断是否已经设置密码
if [ -f /.mongodb_password_set ]; then
    echo "Mongodb password already set!"
    exit 0
fi

/usr/bin/mongod --smallfiles --nojournal &

PASS=${MONGODB_PASS:-${pwgen -s 12 1}}
_word=$( [ ${MONGODB_PASS} ] && echo "preset" || echo "random")

RET=1
while [[ RET -ne 0]]; do
    echo "=> Waiting for confirmation of Mongodb service startup"
    sleep 5
    mongo admin --eval "help" > dev/null 2>&1
    RET=$?
done
