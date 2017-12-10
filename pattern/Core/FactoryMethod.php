<?php
namespace Ym\Demo\Pattern;

/**
 * 工厂方法模式：与简单工厂模式类似，但是可以有多个工厂的存在，
 * 特点：1、创建者类和要生产的产品类要分离开来，创建者类是一个工厂类，其中定义了生成产品对象的方法
 *      2、创建者类要继承一个抽象类或者接口，是其成为多态
 *      3、产品类也要继承一个抽象类或者接口，使其成为多态
 *      4、创建者类中的工厂方法要返回一个产品类实例
 */

/**
 * Class FactoryMethod
 * @package Ym\Demo\Pattern
 */
interface FactoryMethod
{
    public function makeBox();
}

interface Box
{
    public function getType();
}

/**
 * 衣柜类，继承box
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
 * 橱柜类,，继承box
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
 * makeWardRobe类，继承工厂方法类，用于实例化衣柜类
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
 * makeCupBoard类，继承工厂方法类，用于实例化橱柜类
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