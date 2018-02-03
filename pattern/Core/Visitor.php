<?php
/**
 * 访问者模式：很多时候，我们设计好了组件中的某个类需要做什么，有哪些操作。但是也有很多时候，我们无法将所有的情况都考虑
 * 进去，所以，往往需要在类中新增操作方法。但是，这样很明显的违背了设计模式的重要原则之一--开闭原则（对扩展开放，对修改
 * 关闭）。
 * 所以我们需要访问者模式来在不改变原有类的前提下，为类添加新的操作方法
 */

namespace Ym\Demo\Pattern;

/**
 * 定义一个接口，并申明accept()方法
 * Class Unit
 * @package Ym\Demo\Pattern
 */
abstract class Unit
{
    public function accept(Visitor $visitor)
    {
        $method = 'visit'.get_class($this);
        if(method_exists($visitor, $method)){
            $visitor->$method($this);
        }
    }
}

/**
 * 申明一个用户类，并继承unit基类
 * Class User
 * @package Ym\Demo\Pattern
 */
class User extends Unit
{
    public function getName()
    {
        return 'my name is Bob';
    }
}

/**
 * 申明一个获取电话类，并且该类中只有一个方法，而且方法名必须为visitUser(回看一下我们的unit基类，就能知道为什么方法名
 * 必须为这个了)。
 * Class getPhoneVisitor
 * @package Ym\Demo\Pattern
 */
class getPhoneVisitor
{
    public function visitUser()
    {
        return 'my phone is 123456';
    }
}

//客户端操作，获取用户电话号码
$user = new User();
$user->accept(new getPhoneVisitor());