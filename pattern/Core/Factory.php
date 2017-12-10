<?php
namespace Ym\Demo\Pattern;

/**
 * 简单工厂模式：一般情况下，一个类，会在很多地方进行实例化，如果以后对这个类进行什么修改（如改名），
 * 那么就需要在类实例化的地方去修改，这就很麻烦，工厂模式即使把业务类放入工厂类中，由工厂类去实例化这些类
 * 特点：1、工厂类必须有一个工厂方法，2、工厂方法必须能够返回其余类的实例，3、一次只能创建和返回一个类实例
 */

/**
 * Class Factory
 * @package Ym\Demo\Pattern
 */
class Factory
{
    public function creatDataBase()
    {
        return DataBase::getInstance();
    }

    //....当你需要实例化新的类时，需要在工厂类中创建一个新的工厂方法
}

$factory = new Factory();
//实例化DataBase类
$db = $factory->creatDataBase();