<?php

/**
 * 发送消息
 * @param $mqtt
 * @param $topic
 * @param $message
 * @return bool
 */
function send_message($mqtt, $topic, $message)
{
    $arr['MessageId'] = \Bluerhinos\MessageId::generate();
    $arr['MessageBodyMD5'] = md5($arr['MessageId']);
    $arr['MessageBody'] = is_array($message) ? json_encode($message) : $message;
    $arr['ReceiptHandle'] = base64_encode(time());
    $arr['EnqueueTime'] = time();
    $arr['FirstDequeueTime'] = time();
    $arr['NextVisibleTime'] = time();
    $arr['DequeueCount'] = 1;
    $arr['Priority'] = 8;
    $xml = arr_to_xml($arr);
    $errno_11_flag = "Resource temporarily unavailable"; //出现这个错误时，表示写缓存区已经满了，需要等待缓冲区出现出现空闲空间
SEND:
    $res = $mqtt->publish($topic, $xml, 1);
    if ($res['code'] != 1) {
        if (false !== strpos($res['msg'], $errno_11_flag)) {
            goto SEND;
        }
        echo $res['msg']."\r\n";
        return false;
    }
    return true;
}

/**
 * 连接MQTT服务器
 * @param $config
 * @param $wsls_topic
 * @param $log
 * @return \Bluerhinos\phpMQTT|bool
 */
function get_mqtt ($config, $wsls_topic, $log) {
    extract($config);
    $mqtt = new \Bluerhinos\phpMQTT($addr, $mqtt_port, $client_id);
    $connect = $mqtt->connect_auto($clean, $will, $user, $pwd);
    $log['server'] = $addr;
    $log['cid'] = $client_id;
    if (!$connect) {
        $log['connect_msg'] = "连接mqtt服务器失败.";
        Aliyun::wsls($wsls_topic, $log);
        return false;
    } else {
        $log['connect_msg'] = "连接mqtt服务器成功.";
        Aliyun::wsls($wsls_topic, $log);
    }
    return $mqtt;
}

/**
 * 获取服务器外网IP
 * @return array|false|string
 */
function get_client_ip()
{
    $ip = '127.0.0.1';
    $preg = "/\A((([0-9]?[0-9])|(1[0-9]{2})|(2[0-4][0-9])|(25[0-5]))\.){3}(([0-9]?[0-9])|(1[0-9]{2})|(2[0-4][0-9])|(25[0-5]))\Z/";
    @exec("ifconfig", $out, $stats);
    if (!empty($out)) {
        if (isset($out[9]) && strstr($out[9], 'addr:')) {
            $tmpArray = explode(":", $out[9]);
            $tmpIp = explode(" ", $tmpArray[1]);
            if (preg_match($preg, trim($tmpIp[0]))) {
                $ip = trim($tmpIp[0]);
            }
        }
    }
    unset($out, $status);
    //如果没有获取到或者获取的是本地地址或者获取的为非法地址，则请求ifconfig.co
    if ($ip == '127.0.0.1' || false == ip2long($ip)) {
        @exec("wget -qO- ifconfig.co", $out, $status);
        if (!empty($out)) $ip = $out[0];
    }
    return $ip;
}

/**
 * 获取mqtt配置
 * @param $work_id
 * @return array
 */
function get_mqtt_config($work_id)
{
    include_once __DIR__."/config.php";
    $ip = get_client_ip();
    $__mqtt_config['device_id'] = ip2long($ip)+$work_id;
    $__mqtt_config['mqtt_port'] = 1883;
    $__mqtt_config['will'] = NULL;
    $__mqtt_config['pwd'] = encryption($__mqtt_config['groupId'], $__mqtt_config['secretKey']);
    $__mqtt_config['client_id'] = $__mqtt_config['groupId'].'@@@'.$__mqtt_config['device_id'];
    return $__mqtt_config;
}

/**
 * HmacSHA1加密groupId生成登陆密码
 * @param $groupId
 * @param $secretKey
 * @return string
 */
function encryption($groupId, $secretKey)
{
    $ret = hash_hmac('sha1', $groupId, $secretKey, true);
    return base64_encode($ret);
}

/**
 * 数组转XML
 * @param $data
 * @return string
 */
function arr_to_xml($data)
{
    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<Message xmlns="http://mqs.aliyuncs.com/doc/v1">';
    foreach ($data as $key => $val) {
        is_numeric($key) && $key = "item id=\"$key\"";
        $xml .= "<$key>";
        $xml .= (is_array($val) || is_object($val)) ? $this->arrtoXml($val) : $val;
        list($key,) = explode(' ', $key);
        $xml .= "</$key>" . "";
    }
    $xml .= '</Message>';
    return $xml;
}

