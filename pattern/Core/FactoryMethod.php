<?php
namespace Ym\Demo\Pattern;

/**
 * 工厂方法模式：与简单工厂模式类似，但是可以有多个工厂的存在
 * 特点：1、创建者类和要生产的产品类要分离开来，创建者类是一个工厂类，其中定义了生成产品对象的方法
 *      2、创建者类要继承一个抽象类或者接口，是其成为多态
 *      3、产品类也要继承一个抽象类或者接口，使其成为多态
 *      4、创建者类中的工厂方法要返回一个产品类实例
 */

/**
 * 创建者类接口
 * Class FactoryMethod
 * @package Ym\Demo\Pattern
 */
interface FactoryMethod
{
    /**
     * 生成产品对象的方法
     * @return mixed
     */
    public function makeBox();
}

/**
 * 产品类接口
 * Interface Box
 * @package Ym\Demo\Pattern
 */
interface Box
{
    public function getType();
}

/**
 * 衣柜类，继承产品接口
 * Class wardRobe
 * @package Ym\Demo\Pattern
 */
class wardRobe implements Box
{
    public function getType()
    {
        return 'this is wardRobe';
    }
}

/**
 * 橱柜类,，继承产品接口
 * Class cupBoard
 * @package Ym\Demo\Pattern
 */
class cupBoard implements Box
{
    public function getType()
    {
        return 'this is cupBoard';
    }
}

/**
 * makeWardRobe类，继承创建者接口，用于生产衣柜类对象
 * Class makeWardRobe
 * @package Ym\Demo\Pattern
 */
class makeWardRobe implements FactoryMethod
{
    public function makeBox()
    {
        return new wardRobe();
    }
}

/**
 * makeCupBoard类，继承创建者接口，用于生产橱柜类对象
 * Class makeCupBoard
 * @package Ym\Demo\Pattern
 */
class makeCupBoard implements FactoryMethod
{
    public function makeBox()
    {
        return new cupBoard();
    }
}

//客户端
$makeWardRobe = new makeWardRobe();
$wardRobe = $makeWardRobe->makeBox();
print_r($wardRobe->getType());  //this is a wardRobe
echo '<br>';
$makeCupBoard = new makeCupBoard();
$cupBoard = $makeCupBoard->makeBox();
print_r($cupBoard->getType());  //this is cupBoard

/**
 * 简单工厂模式和工厂方法模式的区别：
 * 简单工厂模式只有一个工厂类，而工厂方法模式却通过继承接口，产生出一系列的工厂类，这些工厂类
 * 生产出一批与之对应的产品类（个人理解：在简单工厂模式中，一个工厂类中实例出的对象是五花八门的。
 * 就像一锅大杂烩，而工厂方法模式就是将简单工厂模式中会在一起的这些工厂方法，分门别类，放入到与之
 * 对应的工厂类中去，而不是在一个工厂类中挤在一起。这也符合设计模式的思想，不要让一个类去完成过多
 * 的工作。）
 *
 */