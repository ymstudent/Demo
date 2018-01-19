<?php
/**
 * 适配器模式：在设计模式中有一个著名的“开-闭”原则，一个软件实体应当对扩展开放，对修改关闭。
 * 即在设计一个模块的时候，应当使这个模块可以在不被修改的前提下被扩展。
 */

namespace Ym\Demo\Pattern;

/**
 * 系统中现在有一个数据库操作接口，里面定义了操作数据库的方法
 * Interface DataBase
 * @package Ym\Demo\Pattern
 */
interface DataBase
{
    public function connect();
    public function query();
    public function close();
}

/**
 * Mysql类继承了这个接口，并按照接口定义的方法实现了操作mysql数据库的方法
 * Class Mysql
 * @package Ym\Demo\Pattern
 */
class Mysql implements DataBase
{
    public function connect()
    {
        // TODO: Mysql action
    }

    public function query()
    {
        // TODO: Mysql action
    }

    public function close()
    {
        // TODO: Mysql action
    }
}

/**
 * PDO类继承接口，实现了通过PDO操作数据库的方法
 * Class PDO
 * @package Ym\Demo\Pattern
 */
class PDO implements DataBase
{
    public function connect()
    {
        // TODO: PDO action
    }

    public function query()
    {
        // TODO: PDO action
    }

    public function close()
    {
        // TODO: PDO action
    }
}

//在这个系统中如果我们想要切换到PDO操作方法，我们只需要在数据库操作实例化的地方，将实例化对象替换成PDO类即可。
$dataBase = new Mysql();
$dataBase->connect();
$dataBase->query();
$dataBase->close();

/**
 * 现在，我们通过第三方类库引入了一个对Oracle数据库进行操作的方法，但是很遗憾，它里面的方法与我们当前系统并不兼容，
 * 我们无法通过简单的类切换就去使用他。但是现在公司决定将数据库改为Oracle，我们该怎么？将系统内所有关于数据库操作的
 * 代码全部进行修改么？这个时候适配器模式出现了。
 * Class Oracle
 * @package Ym\Demo\Pattern
 */
class Oracle
{
    public function oracleConnect()
    {
        // TODO: Oracle connect action
    }

    public function oracleQuery()
    {
        // TODO: Oracle query action
    }

    public function oracleClose()
    {
        //TODO: Oracle close action
    }
}

/**
 * 我们将原来不符合我们系统风格的Oracle类，封装到适配器类中，相当于对Oracle类做了一个兼容处理
 * Class Adapter
 * @package Ym\Demo\Pattern
 */
class Adapter implements DataBase
{
    private $adapter;

    public function __construct(Oracle $oracle)
    {
        $this->adapter = $oracle;
    }

    public function connect()
    {
        $this->adapter->oracleConnect();
    }

    public function query()
    {
        $this->adapter->oracleQuery();
    }

    public function close()
    {
        $this->adapter->oracleClose();
    }
}