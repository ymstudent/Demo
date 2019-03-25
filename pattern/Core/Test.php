<?php
/**
 * Created by PhpStorm.
 * User: yanmi
 * Date: 2019/2/20
 * Time: 16:45
 */

namespace Ym\Demo;

/**
 * 单例模式
 * Class Test
 * @package Ym\Demo
 */
class Test
{
    private static $_db;

    private function __construct()
    {
        $link = new \Redis();
        $link->connect('127.0.0.1', 6379);
    }

    public static function getDb()
    {
        if (empty(self::$_db)) {
            self::$_db = new self();
        }
        return self::$_db;
    }
}

$a = Test::getDb();