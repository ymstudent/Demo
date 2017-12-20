<?php
namespace Ym\Demo\Pattern;

/**
 * 抽象工厂模式：用来生成一组相关类，常和工厂方法模式一起使用，
 * 特点：1、每个工厂必须全部继承或实现子同一个抽象类或者接口
 *      2、每个工厂必须包含多个工厂方法
 *      3、每个工厂的方法必须一致，每个方法返回的实例，必须来自同一个抽象类或者接口
 */
/**
 * 这里引用深入php一书中的例子：假如现在有一款叫文明的游戏，可以在区块组成的格子中操作战斗单元(unit)。
 * 每个区块代表海洋(sea)，平原(plains)和森林(forest)，地形约束了占有区块的单元的战斗力和移动。
 * 我们通过一个TerrainFactory对象来提供这些区块对象，并允许用户在完全不同的环境里选择，于是sea就可能是MarSea和EarthSea
 * 森林和平原也类似，这里就构成了抽象工厂模式。
 */
class Sea {};
class MaeSea extends Sea {};
class EarthSea extends Sea {};

class Plains {};
class MarPlains extends Plains {};
class EarthPlains extends Plains {};

class Forest {};
class MarForest extends Forest {};
class EarthForest extends Forest {};

abstract class TerrainFactory
{
    abstract public function getSea();
    abstract public function getPlains();
    abstract public function getForest();
}

class MarTerrainFactory extends TerrainFactory
{
    public function getSea()
    {
        return new MaeSea();
    }

    public function getPlains()
    {
        return new MarPlains();
    }

    public function getForest()
    {
        return new MarForest();
    }
}

class EarthTerrainFactory extends TerrainFactory
{
    public function getSea()
    {
        return new EarthSea();
    }

    public function getForest()
    {
        return new EarthForest();
    }

    public function getPlains()
    {
        return new EarthPlains();
    }
}

/**
 * 抽象工厂一般使用接口，特点是层层约束的，缺点是增加产品比较困难，比如再加个moutain的地形时，抽象创建者和他的每一个具体实现都
 * 需要修改。优点是增加固定类型产品的不同品牌比较方便，比如我要加一个木星的品牌，那么再建一个木星就可以了。
 * 你想做统一标准的时候，比如写了一个框架，数据库操作定义了一套接口，你自己写了一个Mysql的实现，那么其他人参与开发，
 * 比如另一个人写了一个Oracle的实现，那么这种标准的价值就体现出来了，它会让你的代码非常一致，不会被别人写乱。
 */