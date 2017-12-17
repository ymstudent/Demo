<?php
namespace Ym\Demo\Pattern;

/**
 * 对象池模式：单例模式的升级，一个对象池管理多个单例
 * 常见的使用对象池模式的技术包括线程池、数据库连接池、任务队列池、图片资源对象池等。
 * 对象池模式和注册树模式有什么不同：
 * 对象池主在对象创建开销较大或要控制对象数量的时候使用。最常见的对象池应该是数据库连接池和线程次，例如程序需要数据库连接时从连
 * 接池中取一个（连接池里有多个连接），用完了不是关闭连接而是把连接放回连接池给其他程序使用。一个对像池通常只放同一类的对象。
 * 注册树（Registry模式）其实类似对象池，但是里面各种类型的对象都放一个，方便程序通过Registry找到这些对象直接使用而不需自己创建。
 * 两者有交集，但是关注点是不同的。用对象池，关注的是性能，用Registry，关注的是方便对象的获取。
 * Class ObjectPool
 * @package Ym\Demo\Pattern
 */
class ObjectPool
{
    private $instances = [];

    public function get($key)
    {
        if(!isset($this->instances[$key])) {
            $value = $this->make($key);
            $this->add($key, $value);
        }
        return $this->instances[$key];
    }

    public function add($key, $value)
    {
        $this->instances[$key] = $value;
    }

    public function make($key)
    {
        if($key == 'mysql'){
            return DataBase::getInstance();
        }elseif ($key == 'redis'){
            //获取redis对象
        }
    }
}