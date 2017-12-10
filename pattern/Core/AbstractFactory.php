<?php
namespace Ym\Demo\Pattern;

/**
 * 抽象工厂模式：用来生成一组相关类，常和工厂方法模式一起使用，
 * 特点：1、每个工厂必须全部继承或实现子同一个抽象类或者接口
 *      2、每个工厂必须包含多个工厂方法
 *      3、每个工厂的方法必须一致，每个方法返回的实例，必须来自同一个抽象类或者接口
 */

/**
 * Class AbstractFactory
 * @package Ym\Demo\Pattern
 */
interface AbstractFactory
{
    public function makeBox();
    public function makeCar();
}

interface Car
{
    public function getCar();
}

interface Box{
    public function getBox();
}

class goodCar implements Car
{
    public function getCar()
    {
        return 'this is goodcar';
    }
}

class goodBox implements Box
{
    public function getBox()
    {
        return 'this is goodbox';
    }
}

class badCar implements Car
{
    public function getCar()
    {
        return 'this is badCar';
    }
}

class badBox implements Box
{
    public function getBox()
    {
        return 'this is badBox';
    }
};

class richMan implements AbstractFactory
{
    public function makeBox()
    {
        return new goodBox();
    }

    public function makeCar()
    {
        return new goodCar();
    }
}

class poorMan implements AbstractFactory
{
    public function makeBox()
    {
        return new badBox();
    }

    public function makeCar()
    {
        return new badCar();
    }
}

$richman = new richMan();
$car = $richman->makeCar();
$box = $richman->makeBox();
print_r($car->getCar());
echo '<be>';
print_r($box->getBox());

/**
 * 抽象工厂一般使用接口，特点是层层约束的，缺点是增加产品比较困难，比如再加个makeHouse()，接口和实现都得改。
 * 优点是增加固定类型产品的不同品牌比较方便，比如我要加一个middleMan的品牌，那么再建一middleMan就可以了。
 * 你想做统一标准的时候，比如写了一个框架，数据库操作定义了一套接口，你自己写了一个Mysql的实现，那么其他人参与开发，
 * 比如另一个人写了一个Oracle的实现，那么这种标准的价值就体现出来了，它会让你的代码非常一致，不会被别人写乱。
 */