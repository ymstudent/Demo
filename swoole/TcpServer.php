<?php
/**
 * Created by PhpStorm.
 * User: yanmi
 * Date: 2018/12/25
 * Time: 15:09
 */

namespace swoole;

//如果以守护进程启动后，必须使用绝对地址
include_once __DIR__."/mqtt/MessageId.php";
include_once __DIR__."/mqtt/phpMQTT.php";
include_once __DIR__."/mqtt/Aliyun.php";

class TcpServer
{
    private $serv;
    private $mqtt_config;
    private $mqtt_connect;
    const PROCESS_NAME = 'swoole';
    const LOG_NAME = 'swoole_mqtt';

    public function __construct()
    {
        //创建Server对象，监听 127.0.0.1:9501端口
        $this->serv = new \swoole_server('0.0.0.0', 9501);

        //设置属性
        $this->serv->set(array(
            //守护进程化。设置daemonize => 1时，程序将转入后台作为守护进程运行。长时间运行的服务器端程序必须启用此项。
            //启用守护进程后，CWD（当前目录）环境变量的值会发生变更，相对路径的文件读写会出错。PHP程序中必须使用绝对路径
            'daemonize' => true,
            'worker_num' => 4, //异步非阻塞代码一般设为CPU的1-4倍。
            'max_request' => 5000, //一个worker进程在处理完超过此数值的任务后将自动退出，主要作用是解决PHP进程内存溢出问题
            'max_conn' => 1024, //进程最大连接数
            'task_worker_num' => 20, //Task进程最大值不得超过cpu_num*1000,该进程是同步阻塞的，里面不得调用异步IO函数
            'task_ipc_mode' => 3, //worker进程与task进程之间的通信模式，3为队列通信并且设置为了争抢模式，使用消息队列通信，如果Task进程处理能力低于投递速度，可能会引起Worker进程阻塞。
            'message_queue_key' => 0x72000100, //指定消息队列的key
            'task_max_request' => 5000, //task进程最大任务数
            'log_file' => '/tmp/swoole.log', //日志文件
            'log_level' => 4, //需要记录的错误级别
        ));

        //监听服务启动事件
        $this->serv->on('Start', array($this, 'onStart'));
        //监听管理进程启动事件
        $this->serv->on('ManagerStart', array($this, 'onManagerStart'));
        //监听工作进程启动事件
        $this->serv->on('WorkerStart', array($this, 'onWorkerStart'));
        //监听工作进程异常退出事件
        $this->serv->on('WorkerError', array($this, 'onWorkerError'));
        //监听工作检测停止事件
        $this->serv->on('WorkerStop', array($this, 'onWorkerStop'));
        //监听连接进入事件
        $this->serv->on('Connect', array($this, 'onConnect'));
        //监听数据接受事件
        $this->serv->on('Receive', array($this, 'onReceive'));
        //监听连接关闭事件
        $this->serv->on('Close', array($this, 'onClose'));
        //监听task进程接收任务事件
        $this->serv->on('Task', array($this, 'onTask'));
        //监听Task进程完成任务事件
        $this->serv->on('Finish', array($this, 'onFinish'));

        //启动服务器
        $this->serv->start();
    }

    //onStart回调中，仅允许echo、打印Log、修改进程名称。不得执行其他操作
    public function onStart($serv)
    {
        swoole_set_process_name(self::PROCESS_NAME.'_master');
    }

    //在这个回调函数中可以修改管理进程的名称
    public function onManagerStart($serv)
    {
        swoole_set_process_name(self::PROCESS_NAME.'_manager');
    }

    //此事件在Worker进程/Task进程启动时发生，这里创建的对象可以在进程生命周期内使用
    public function onWorkerStart($serv, $worker_id)
    {
        //引入常用函数文件，由于可能会发送更改，所以在worker进程开始时引用
        include_once __DIR__.'/mqtt/common.php';
        $jobType = $serv->taskworker ? 'Tasker' : 'Worker';
        swoole_set_process_name(self::PROCESS_NAME.'_'.$jobType.'_'.$worker_id);
        //在task进程中启动mqtt连接
        if ($serv->taskworker) {
            //获取配置
            $this->mqtt_config = get_mqtt_config($worker_id);
            $this->mqtt_connect = get_mqtt($this->mqtt_config, self::LOG_NAME, ['event' => "进程{$worker_id}连接mqtt服务器"]);
            //如果没有连接上mqtt服务器，关闭当前进程
            if (!$this->mqtt_connect) {
                $serv->stop($worker_id, true);
            }
            //30S发送一次心跳包
            $serv->tick(30000, function () use ($serv, $worker_id) {
                //发送心跳包
                if (!$this->mqtt_connect->ping()) {
                    //如果ping失败就重新连接
                    $this->mqtt_connect = get_mqtt($this->mqtt_config, self::LOG_NAME, ['event' => "进程{$worker_id} ping失败，重新连接mqtt服务器"]);
                    if (!$this->mqtt_connect) {
                        $serv->stop($worker_id, true);
                    }
                }
            });
        }

        //在worker进程判断文件是否更新
        if (!$serv->taskworker) {
            //清除文件状态缓存，这个是为了防止下面filemtime从缓存中读取
            clearstatcache();
            $filemtime = filemtime(__FILE__);
            //30S检测一次文件更新
            $serv->tick(30000, function () use ($serv, $worker_id, $filemtime) {
                //检查文件更新
                clearstatcache();
                //如果文件变化，则重启所有的work进程
                if ($filemtime != filemtime(__FILE__)) {
                    \Aliyun::wsls(self::LOG_NAME,"文件更新，重启所有woker/task进程\r\n");
                    $serv->reload();
                }
            });
        }
    }

    public function onWorkerError($serv, $worker_id, $worker_pid, $exit_code, $signal)
    {
        echo "{$worker_id} Error\r\n";
    }

    //此函数在Worker进程中执行
    public function onWorkerStop($serv,$worker_id)
    {
        //zend_opcache的opcache清理函数，防止某些服务器开启了opcache
        opcache_reset();
    }

    //此函数在Worker进程中执行
    public function onConnect($serv, $fd)
    {
        //echo "Client: connect.\n";
    }

    //此函数在Worker进程中执行
    public function onReceive($serv, $fd, $from_id, $data)
    {
        $param['data'] = json_decode($data,true);
        $param['fd'] = $fd;
        //向task进程投递任务
        $serv->task($param);
    }

    //此函数在Task进程中执行
    public function onTask($serv, $task_id, $src_worker_id, $param)
    {
        $log = [];
        $st = microtime(true);
        $data = $param['data'];
        $fd = $param['fd'];
        $log['msg'] = $data;
        $return = ['code' => 2, 'msg' => 'mqtt消息发送失败'];
        try{
            if (empty($data['message'])) {
                throw new \Exception("no message");
            }
            $res = send_message($this->mqtt_connect, $data['mqtt_topic'], $data['message']);
            if ($res) {
                $return['code'] = 1;
                $return['msg'] = 'mqtt消息发送成功';
                $log['send_res'] = '消息发往'.$data['mqtt_topic']."成功";
            }else{
                //断线重连
                $log['send_res'] =  '消息发往'.$data['mqtt_topic']."失败，重新连接mqtt";
                $this->mqtt_connect = get_mqtt($this->mqtt_config, self::LOG_NAME, $log);
                if (!$this->mqtt_connect) {
                    $serv->stop($serv->worker_id, true);
                }
            }
        }catch (\Throwable $e) {
            $log['send_res'] = "消息发送出错，错误信息：".$e->getMessage();
        }
        $res = json_encode($return);
        $serv->send($fd, $res);
        $et = microtime(true);
        $log['spend_time'] = "任务{$src_worker_id}-{$serv->worker_id}-{$task_id}完成，花费时间".($et-$st)."S\r\n";
        \Aliyun::wsls(self::LOG_NAME, $log);
        return $res;
    }

    //此函数在worker进程中执行
    public function onFinish($serv, $task_id, $data)
    {
        //echo "{$task_id}回调完成\r\n";
    }

    public function onClose($server, $fd, $reactorId)
    {
        //echo "Client: close.\n";
    }
}

$serv = new TcpServer();