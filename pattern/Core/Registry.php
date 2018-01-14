<?php
/**
 * 注册器模式：提供系统级别的对象访问功能。通过key/value来存储独享
 * laravel中的Service Container本质上就是一种注册器。有时间可以去看看
 */

namespace Ym\Demo\Pattern;


class Registry
{
    private static $objects;

    public static function set($alias, $object)
    {
        if(!isset(self::$objects[$alias])){
            self::$objects[$alias] = $object;
        }
    }

    public static function get($alias)
    {
        return self::$objects[$alias];
    }

    public static function _unset($alias)
    {
        unset(self::$objects[$alias]);
    }
}

//使用
Registry::set('rand', \stdClass::class);
Registry::get('rand');