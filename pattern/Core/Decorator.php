<?php
/**
 * 装饰器模式：通过在运行时合并对象来扩展功能的一种灵活机制（以组合代替继承的思想）
 * 一个类中有一个方法，我需要经常改它，而且会反反复复，改完了又改回去。
 * 一般要么我们直接改原来的类中的方法，要么继承一下类覆盖这个方法。
 * 而装饰器模式可以不用继承，只需要增加一个类进去，就可以改掉那个方法。
 */
namespace Ym\Demo\Pattern;

/**
 * 下面还是以文明游戏为例，我们定义Tile（区域）能够产生财富，不同区域的产生的财富不同，平原财富为2，
 */
abstract class Tile
{
    abstract function getWealthFactory();
}

class Plains extends Tile
{
    private $wealthFactory = 2;

    public function getWealthFactory()
    {
        return $this->wealthFactory;
    }
}
/**
 * 现在，我们想丰富平原模型，我们加入了含有钻石的平原和受污染的平原，含有钻石的平原财富+2，而受到污染的平原财富-4
 * 通常的做法是从plains对象继承派生
 */
class DiamoPlains extends Plains
{
    public function getWealthFactory()
    {
        return parent::getWealthFactory() + 2;
    }
}

class PollutedPlains extends Plains
{
    public function getWealthFactory()
    {
        return parent::getWealthFactory() - 4;
    }
}

/**
 * 现在我们可以得到含有钻石平原和受污染的平原的财富值了，如果我想创建一个受到污染的钻石平原的模型，难道我们只能去创建一个
 * diamoPolluterdPlains的实例么
 *
 * 这时候，装饰器模式来了
 *
 * 我们创建一个新的TileDecorator类继承Tile，在这个类中，我们没有实现getWealthFactory()方法，所以此类只能被申明
 * 为抽象类，我们在这个抽象类中定义了一个protected级别的属性$tile，用来保存传入的Tile对象。然后我们创建了Daimo装饰器
 * 和polluted装饰器类，这个两个类都扩展自tile装饰器类，所以它们都拥有指向Tile对象的引用，当调用getWealthFactory()
 * 方法被调用的时候，这些类都会首先调用Tile对象的getWealthFactory方法，然后执行自己特有的操作
 */
abstract class TileDecorator extends Tile
{
    protected $tile;

    public function __construct(Tile $tile)
    {
        $this->tile = $tile;
    }
}

class DaimoDecorator extends TileDecorator
{
    public function getWealthFactory()
    {
        return $this->tile->getWealthFactory() + 2;
    }
}

class PollutedDecorator extends TileDecorator
{
    public function getWealthFactory()
    {
        return $this->tile->getWealthFactory() - 4;
    }
}

$tile = new Plains();
print $tile->getWealthFactory(); //2
$tile = new DaimoDecorator(new Plains());
print $tile->getWealthFactory(); //4
$tile = new DaimoDecorator(new PollutedDecorator(new Plains()));
print $tile->getWealthFactory(); //0 DaimoDecorator先引用了PollutedDecorator，而PollutedDecorator又先应用了Plains对象的引用

/**
 * 装饰器模式所建立的管道（多个装饰器犹如管道般串联起来，如第三个实例）对于创建过滤器非常有用，JAVA的IO包便广泛
 * 的使用装饰器类，通过这种模式，我们可以十分轻松的添加新的装饰器和新的组件而不需要去改变原来的类
 */





