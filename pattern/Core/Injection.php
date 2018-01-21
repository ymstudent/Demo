<?php
/**
 * 依赖注入(Dependency Injection [DI])：非常著名且有用的设计模式，通过把一个类不可更换的部分和可更换的部分分离开来，
 * 通过注入的方式来使用，从而达到解耦的目的。
 * 依赖注入是用于实现控制反转（Inversion of Control [IOC]）的最常见的方式之一。
 * 控制反转最大的作用就是解耦，那么控制反转究竟是解的什么耦合，为什么需要使用他解耦？一起来看一下下面的例子
 */

namespace Ym\Demo\Pattern;


class Mysql
{
    private $host;
    private $username;
    private $password;

    public function connect()
    {
        $this->host = '127.0.0.7';      //这里有个小技巧：在连接本地数据库时，使用'127.0.0.1'比使用'localhost'效率要
                                        //高的多（甚至有几倍）,这是因为使用'localhost'连接时，系统会先寻找IPV6地址，没有
                                        //再去寻找IPV4，而使用'127.0.0.1'直接告诉系统这是IPV4地址。
        $this->username = 'root';
        $this->password = '123456';
        mysqli_connect($this->host, $this->username, $this->password);
    }
}

class Database
{
    private $db;

    public function mysql()
    {
        $db = new Mysql();
        return $db;
    }
}

//客户端
$db = new DataBase();
$db->mysql()->connect();

/**
 * 现在，我们想向Mysql类中传入参数来动态的控制连接那个数据库，这样我们既需要修改Mysql类，又需要改变DataBase类。
 * 这个就是依赖注入需要处理的耦合
 * 依赖注入解决耦合的方式就是不再类中去实例化其余的类，而是在外部实例化后，再传入类的内部（以聚合代替组合）。
 * 依赖注入实现的方式:
 * 1、构造函数注入
 * 2、方法注入
 * 3、接口注入（创建一个注入使用的接口，然后再让使用类去继承这个接口）
 */

/**
 * 使用方法注入
 * Class DataBase2
 * @package Ym\Demo\Pattern
 */
class DataBase2
{
    private $db;
    public function mysql(Mysql $mysql)
    {
        return $db = $mysql;
    }
}

/**
 * 使用接口注入
 * Interface InjectInterface
 * @package Ym\Demo\Pattern
 */
interface InjectInterface
{
    public function inject(Mysql $mysql);
}
class DataBase3 implements InjectInterface
{
    public function inject(Mysql $mysql)
    {
        // TODO: Implement inject() method.
    }
}

