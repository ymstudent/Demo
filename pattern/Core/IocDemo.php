<?php
/**
 * 依赖注入，控制反转，反射概念的理解
 */

namespace Ym\Demo;

/**
 * 概念：
 * 控制反转：由外部负责依赖需求的行为，称之为控制反转（IoC）
 * 依赖注入：不是由自己内部new对象或者实例，而是通过构造函数，方法传入的都称之为依赖注入（DI）
 * 通过依赖注入我们可以很自然的实现控制反转，所以我们一般认为控制反转与依赖注入表达的时同一个意思
 */

/**
 * 示例：定义了2种纪录日志的方式，一种数据库纪录，一种文件纪录
 */
interface Log
{
    public function write();
}

class FileLog implements Log
{
    public function write()
    {
        // TODO: Implement write() method.
        echo "file log write";
    }
}

class DatabaseLog implements Log
{
    public function write()
    {
        // TODO: Implement write() method.
        echo "database log write";
    }
}

/**
 * 定义一个user类，当登录成功时，纪录日志
 */
class User
{
    protected $fileLog;

    public function __construct()
    {
        $this->fileLog = new FileLog();
    }

    public function login()
    {

        //登录成功，纪录日志
        echo "login success";
        $this->fileLog->write();
    }
}
/**
 * 现在如果我们想改用数据库纪录日志，就必须修改原来的的User类
 * 这样不符合开放封闭原则（一个软件实体应当对扩展开放，对修改关闭），代码的耦合性也高
 */
$user = new User();
$user->login();


/**
 * 优化User类，将日志纪录类以构造函数的方式写入（依赖注入）
 */
class User2
{
    protected $log;

    public function __construct(Log $log)
    {
        $this->log = $log;
    }

    public function login()
    {
        echo "login success";
        $this->log->write();
    }
}

/**
 * 这样，如果要修改纪录日志的方式，就不需要去改动user2类了，直接通过外部传入DatabaseLog类就行了（控制反转）
 */
$user2 = new User2(new FileLog());
$user2->login();


/**
 * 反射：
 */
