<?php
namespace Ym\Demo\Pattern;

/**
 * 利用单例模式实现一个数据库连接
 * 单例模式的要点：1、一个保存类实例的私有、静态成员变量；2、一个私有的构造方法；3、用来实例化本身的公有接口
 * 单例模式的好处：1、避免大量new操作消耗资源；2、需要更改设置时，只需要在一处更改即可
 * Class DataBase
 * @package Ym\Demo\pattern
 */
class DataBase
{
    //用该属性保存类实例
    private static $db;

    //构造函数为private，防止被实例
    private function __construct()
    {
        self::$db = mysqli_connect('127.0.0.1','root', '', '');
    }

    //实例化类的方法
    public static function getInstance()
    {
        if (empty(self::$db)) {
            self::$db = new DataBase();
        }
        return self::$db;
    }
}

$db = DataBase::getInstance();