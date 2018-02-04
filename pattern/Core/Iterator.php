<?php
/**
 * 遍历模式(迭代器模式)：在不需要了解一个类内部实现的前提下，遍历一个聚合对象内部的元素。
 * php提供了封装好的迭代器接口（Iterator）,并且在其SPL扩展库中提供了一系列迭代器以遍历不同的对象。
 */

namespace Ym\Demo\Pattern;


/**
 * 实现一个迭代器，并打印出其内部的操作流程
 * Class MyIterator
 * @package Ym\Demo\Pattern
 */
class MyIterator implements \Iterator
{
    private $position = 0;
    private $array = array(
        "firstelement",
        "secondelement",
        "lastelement",
    );

    public function __construct()
    {
        $this->position = 0;
    }

    //返回当前元素
    public function current()
    {
        // TODO: Implement current() method.
        var_dump(__METHOD__);
        return $this->array[$this->position];
    }

    //返回当前元素的键
    public function key()
    {
        // TODO: Implement key() method.
        var_dump(__METHOD__);
        return $this->position;
    }

    //向前移动到下一个元素
    public function next()
    {
        // TODO: Implement next() method.
        var_dump(__METHOD__);
        ++$this->position;
    }

    //返回到迭代器的第一个元素
    public function rewind()
    {
        // TODO: Implement rewind() method.
        var_dump(__METHOD__);
        $this->position = 0;
    }

    //检查当前位置是否有效
    public function valid()
    {
        // TODO: Implement valid() method.
        var_dump(__METHOD__);
        return isset($this->array[$this->position]);
    }
}

$it = new MyIterator();
foreach ($it as $k=>$d){
    var_dump($k, $d);
    echo "\n";
}
/*
D:\WAMP\www\demo\pattern\Core\Iterator.php:52:string 'Ym\Demo\Pattern\MyIterator::rewind' (length=34)
D:\WAMP\www\demo\pattern\Core\Iterator.php:60:string 'Ym\Demo\Pattern\MyIterator::valid' (length=33)
D:\WAMP\www\demo\pattern\Core\Iterator.php:28:string 'Ym\Demo\Pattern\MyIterator::current' (length=35)
D:\WAMP\www\demo\pattern\Core\Iterator.php:36:string 'Ym\Demo\Pattern\MyIterator::key' (length=31)
D:\WAMP\www\demo\pattern\Core\Iterator.php:67:int 0
D:\WAMP\www\demo\pattern\Core\Iterator.php:67:string 'firstelement' (length=12)

D:\WAMP\www\demo\pattern\Core\Iterator.php:44:string 'Ym\Demo\Pattern\MyIterator::next' (length=32)
D:\WAMP\www\demo\pattern\Core\Iterator.php:60:string 'Ym\Demo\Pattern\MyIterator::valid' (length=33)
D:\WAMP\www\demo\pattern\Core\Iterator.php:28:string 'Ym\Demo\Pattern\MyIterator::current' (length=35)
D:\WAMP\www\demo\pattern\Core\Iterator.php:36:string 'Ym\Demo\Pattern\MyIterator::key' (length=31)
D:\WAMP\www\demo\pattern\Core\Iterator.php:67:int 1
D:\WAMP\www\demo\pattern\Core\Iterator.php:67:string 'secondelement' (length=13)

D:\WAMP\www\demo\pattern\Core\Iterator.php:44:string 'Ym\Demo\Pattern\MyIterator::next' (length=32)
D:\WAMP\www\demo\pattern\Core\Iterator.php:60:string 'Ym\Demo\Pattern\MyIterator::valid' (length=33)
D:\WAMP\www\demo\pattern\Core\Iterator.php:28:string 'Ym\Demo\Pattern\MyIterator::current' (length=35)
D:\WAMP\www\demo\pattern\Core\Iterator.php:36:string 'Ym\Demo\Pattern\MyIterator::key' (length=31)
D:\WAMP\www\demo\pattern\Core\Iterator.php:67:int 2
D:\WAMP\www\demo\pattern\Core\Iterator.php:67:string 'lastelement' (length=11)

D:\WAMP\www\demo\pattern\Core\Iterator.php:44:string 'Ym\Demo\Pattern\MyIterator::next' (length=32)
D:\WAMP\www\demo\pattern\Core\Iterator.php:60:string 'Ym\Demo\Pattern\MyIterator::valid' (length=33)
*/