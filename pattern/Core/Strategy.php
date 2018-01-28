<?php
/**
 * 策略模式：找出应用中可能需要变化之处，把它们独立出来，不要和那些不需要变化的代码混在一起;简单来说就是如果你的类的
 * 某处使用了大量的if...else语句或者你的某个父类下的子类实现了大量重复的代码，那么你就可以考虑将这个地方抽出来，写成接口
 * 举个例子：
 */

namespace Ym\Demo\Pattern;

/**
 * 我创建了一个抽象的鸭子类,所有的鸭子都能够游泳，但是不同的鸭子有不同的样子
 * Class Duck
 * @package Ym\Demo\Pattern
 */
abstract class Duck
{
    public function swim()
    {
        return 'swimming';
    }

    public abstract function display();
}

/**
 * 黑鸭子表现为黑色
 * Class BlackDuck
 * @package Ym\Demo\Pattern
 */
class BlackDuck extends Duck
{
    public function display()
    {
        return 'black';
    }
}

/**
 * 红鸭子表现为红色
 * Class RedDuck
 * @package Ym\Demo\Pattern
 */
class RedDuck extends Duck
{
    public function display()
    {
        return 'red';
    }
}

/**
 * 现在客户有了新的需求，要求鸭子都能飞，那简单啊，我们给接口添加上fly()方法，这样不久行了么，但是等等，我们发现在我们的
 * 鸭子中有一只橡皮鸭，橡皮鸭不能飞，所以我们只能去橡皮鸭的类中去重载fly()方法，橡皮鸭的fly()方法中没有任何的代码。这样
 * 我们就实现了让橡皮鸭不能飞。问题很完美的解决了啊。但是如果以后每出现一种不能飞的鸭子（塑料鸭，玩具鸭等），我们都需要去
 * 子类中重载fly()方法么？--这样毫无疑问犯了上面提到的错误，在父类的子类中实现了大量重复的代码。而且以后如果我们添加某种
 * 新的属性，一旦前面的鸭子类不适用这个属性，那么，我们就只能去修改已经完成的鸭子类--这样又违反了开-闭原则。啊！突然就感觉
 * 人生好难啊。
 * 来看一下策略模式是怎么解决这个难题的：
 * 策略模式提出，把最共有的方法放入父类中，把可以变化的方法抽取成接口，放入父类中，子类通过插入不同的接口实现，完成类的配置。
 * 在Duck类中,swim()属于共有并且相同的方法，display()属于共有但是每个实现都不同的方法，而fly()方法，则属于一些子类具有的方法
 * 所以，我们需要将fly()方法抽出，并写成接口。
 */

/**
 * 定义飞接口
 * Interface Fly
 * @package Ym\Demo\Pattern
 */
interface Fly
{
    public function fly();
}

/**
 * 定义能飞
 * Class CanFly
 * @package Ym\Demo\Pattern
 */
class CanFly implements Fly
{
    public function fly()
    {
        return 'I can fly';
    }
}

/**
 * 定义不能飞
 * Class NotFly
 * @package Ym\Demo\Pattern
 */
class NotFly implements Fly
{
    public function fly()
    {
        return 'I can not fly';
    }
}

/**
 * 新的鸭子类
 * Class StrategyDuck
 * @package Ym\Demo\Pattern
 */
abstract class StrategyDuck
{
    protected $fly;

    public function swim()
    {
        return 'swimming';
    }

    public abstract function display();

    public function fly()
    {
        return $this->fly->fly();
    }

    public function setFly(Fly $fly)
    {
        $this->fly = $fly;
    }
}

class StrategyRedDuck extends StrategyDuck
{
    public function display()
    {
        return 'red';
    }
}

class StrategyBlackDuck extends StrategyDuck
{
    public function display()
    {
        return 'black';
    }
}

/**
 * 现在，我们想要一只能飞的红鸭子，我们可以这样调用
 */
$redDuck = new StrategyRedDuck();
$redDuck->setFly(new CanFly());
$redDuck->fly();

/**
 * 如果我们还想有的鸭子能变成白天鹅该怎么办？这时，我们需要增加一个白天鹅接口，并添加2种实现，一种可以变，一种不能变，
 * 然后我们只需要为父类添加白天鹅方法和设置白天鹅方法就行了，不用去一个个修改子类，而是当我们使用子类时，去动态设定
 */