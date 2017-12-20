<?php
namespace Ym\Demo\Pattern;

/**
 * 原形模式：使用抽象工厂模式时，会出现很令人头痛的一点，就是每当需要增加一个新的产品时，就需要增加一个具体的创建者。
 * 这时一个避免这种依赖的办法就是使用PHP的clone关键词复制已存在的具体产品，然后，具体产品类本身便成为他们自己生成的
 * 基础，这就是原形模式，使用原形模式我们可以用组合来代替继承，使我们的代码更加灵活
 */
/**
 * 继续使用抽象工厂中的例子，这次我们将它升级为工厂模式试试
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

class TerrainFactory
{
    private $sea;
    private $plains;
    private $forest;

    public function __construct(Sea $sea, Plains $plains, Forest $forest)
    {
        $this->sea = $sea;
        $this->plains = $plains;
        $this->forest = $forest;
    }

    public function getSea()
    {
        return clone $this->sea;
    }

    public function getPlains()
    {
        return clone $this->plains;
    }

    public function getForest()
    {
        return clone $this->forest;
    }
}

$earthTerrain = new TerrainFactory(new EarthSea(), new EarthPlains(), new EarthForest());
$MarTerrain = new TerrainFactory(new MaeSea(), new MarPlains(), new MarForest());
/**
 * 这样我们只需要在生成对象时，注入不同的对象，就可以灵活的创建出我们想要的地形
 * 但需要注意的是，如果你注入的类（产品对象）引入了其余的对象，那么需要使用__clone()方法来进行深复制。
 * 关于深、浅复制可以看博客：http://ymfeb.cn/articles/40
 */
