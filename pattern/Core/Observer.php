<?php
/**
 * 观察者模式：观察者模式是一种非常有用且常用的设计模式，观察者模式的核心是把客户元素（观察者）从一个中心类（主体）中
 * 分离开来。当主体知道事件发生时，观察者需要被通知到。但是，观察者和主体之间不能使用硬编码
 * TP框架的模型事件就运用了观察者模式。地址：https://www.kancloud.cn/thinkphp/master-database-and-model/265557#_714
 * PHP的SPL提供了SplSubject和SplObserver2个接口来实现观察者模式。地址：http://php.net/manual/zh/class.splsubject.php
 */

namespace Ym\Demo\Pattern;

use SplObserver;
use SplSubject;

/**
 * 观察者1
 * Class MyObserver1
 * @package Ym\Demo\Pattern
 */
class MyObserver1 implements SplObserver
{
    //接受来自Subject的事件
    public function update(SplSubject $subject)
    {
        // TODO: Implement update() method.
        echo __CLASS__ . '-' . $subject->getName()."\r\n";
    }
}

/**
 * 观察者2
 * Class MyObserver2
 * @package Ym\Demo\Pattern
 */
class MyObserver2 implements SplObserver
{
    public function update(SplSubject $subject)
    {
        // TODO: Implement update() method.
        echo __CLASS__ . '-' . $subject->getName()."\r\n";
    }
}

class MySubject implements SplSubject
{
    private $_observer;
    private $_name;

    public function __construct($name)
    {
        //SplObjectStorage为SPL库中的对象容器，用来存储一组对象，特别是当你需要唯一标识对象的时候
        $this->_observer = new \SplObjectStorage();
        $this->_name = $name;
    }

    //添加一个观察者对象
    public function attach(SplObserver $observer)
    {
        // TODO: Implement attach() method.
        $this->_observer->attach($observer);
    }

    //删除一个观察者对象
    public function detach(SplObserver $observer)
    {
        // TODO: Implement detach() method.
        $this->_observer->detach($observer);

    }

    //通知观察者
    public function notify()
    {
        // TODO: Implement notify() method.
        foreach ($this->_observer as $observer){
            $observer->update($this);
        }
    }

    //通知信息
    public function getName()
    {
        return $this->_name;
    }

    public function getAge()
    {
        return  18;
    }
}

//客户端操作
$observer1 = new MyObserver1();
$observer2 = new MyObserver2();

$subject = new MySubject('test');

$subject->attach($observer1);
$subject->attach($observer2);
$subject->notify();
//output: Ym\Demo\Pattern\MyObserver1-test Ym\Demo\Pattern\MyObserver2-test
