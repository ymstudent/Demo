<?php
ignore_user_abort(TRUE); //如果客户端断开连接，不会引起脚本abort.
set_time_limit(0);//取消脚本执行延时上限
sleep(10);
$param = isset($_POST['param']) ? $_POST['param'] : $_GET['param'];//$_REQUEST['param']
if(file_exists('1.txt')){
    @unlink('1.txt');
}
file_put_contents('1.txt',$param);