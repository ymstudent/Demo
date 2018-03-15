<?php
/**
 * Created by PhpStorm.
 * User: ym
 * Date: 2018/3/15
 * Time: 22:38
 */

/**
 * 根据$_SERVER获取真实IP
 * @return mixed
 */
function getRealIpAddr()
{
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //如果使用代理服务器，可以通过这个参数来获取真实IP
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

/**
 * 根据IP调用新浪API获取地理位置
 * @param $ip
 * @return bool|mixed|string
 */
function detectCity($ip)
{
    if (empty($ip)) {
        return '请输入IP地址';
    }
    //使用新浪API
    $res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);
    if (empty($res)) {
        return false;
    }
    $jsonMatches = array();
    preg_match('#\{.+?\}#', $res, $jsonMatches);
    if (!isset($jsonMatches[0])) {
        return false;
    }
    $json = json_decode($jsonMatches[0], true);
    if (isset($json['ret']) && $json['ret'] == 1) {
        $json['ip'] = $ip;
        unset($json['ret']);
    } else {
        return false;
    }
    return $json;
}

$ip = getRealIpAddr();
$city = detectCity($ip);
var_dump($city);