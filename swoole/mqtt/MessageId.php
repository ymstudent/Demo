<?php
/**
 * Created by PhpStorm.
 * User: yanmi
 * Date: 2018/11/13
 * Time: 11:22
 */

namespace Bluerhinos;


class MessageId
{
    /**
     * 生成唯一id
     * @return String
     */
    public static function generate(){
        // 使用session_create_id()方法创建前缀
        if (function_exists('session_create_id')) {
            $prefix = session_create_id(date('YmdHis')); //PHP7以上版本才支持
        } else {
            $prefix = session_id(date('YmdHis'));
        }
        // 使用uniqid()方法创建唯一id
        $request_id = strtoupper(md5(uniqid($prefix, true)));
        // 格式化请求id
        return self::format($request_id);
    }
    /**
     * 格式化请求id
     * @param string $request_id 请求ID
     * @param string $format 格式
     * @return string
     */
    private static function format($request_id, $format='8,4,4,4,12')
    {
        $tmp = array();
        $offset = 0;
        $cut = explode(',', $format);
        // 根据设定格式化
        if($cut){
            foreach($cut as $v){
                $tmp[] = substr($request_id, $offset, $v);
                $offset += $v;
            }
        }
        // 加入剩余部分
        if($offset<strlen($request_id)){
            $tmp[] = substr($request_id, $offset);
        }
        return implode('-', $tmp);
    }
}