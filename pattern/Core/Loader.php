<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2017/11/20
 * Time: 23:36
 */

namespace pattern;


class Loader
{
    public static function autoload($class)
    {
        $base_dir = BASEDIR;
        $file = $base_dir . str_replace('\\', '/', $class) . 'php';
        if (file_exists($file)) {
            require $file;
        }
    }
}