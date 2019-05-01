<?php
/**
 * Created by PhpStorm.
 * User: yanmi
 * Date: 2019/2/21
 * Time: 15:32
 */

class Aliyun
{
    //记录日志到目录，使用日志实时采集
    public static function wsls($topic, $json)
    {
        if (!is_array($json)) {
            $json = array('content' => $json);
        }
        //写入附加信息:
        if (isset($_SERVER['REQUEST_URI'])) {
            $json['REQUEST']="{$_SERVER['SERVER_NAME']}:{$_SERVER['SERVER_PORT']}{$_SERVER['REQUEST_URI']}";
        }
        //写入访问地址
        if (isset($_SERVER['REMOTE_ADDR'])) {
            $json['REMOTE_ADDR']=$_SERVER['REMOTE_ADDR'];
            $json['REMOTE_PORT']=$_SERVER['REMOTE_PORT'];
        }
        //写入处理时间
        $json['REQUEST_TIME'] = time();
        umask(0);
        $logpath=dirname(dirname(__DIR__))."/aliyun_sls/log";
        if (!file_exists($logpath)) {
            @mkdir($logpath, 0777, true);
        }

        $fp=fopen("{$logpath}/{$topic}.log", 'ab');
        @fwrite($fp, json_encode($json, JSON_UNESCAPED_UNICODE)."\r\n");
        fclose($fp);
    }
}