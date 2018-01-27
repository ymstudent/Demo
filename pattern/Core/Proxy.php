<?php
/**
 * 代理模式：当我们访问一个类时，不直接去访问这个类，而是通过一个代理类去访问这个类。
 * 代理类和被代理类必须继承于同一个接口。这样做的目的就是为了解耦，当某天有新的要求是，
 * 可以不去动原始类，而直接在代理类中修改即可（和适配器模式有点像），代理类还可以进行，拦截消息，预处理数据等操作
 */

namespace Ym\Demo\Pattern;

interface Img {
    public function getWidth();
}

class RawImg implements Img
{
    public function getWidth()
    {
        return '100*100';
    }
}

class ProxyImg implements Img
{
    private $rawImg;

    public function __construct()
    {
        $this->rawImg = new RawImg();
    }

    public function getWidth()
    {
        return $this->rawImg->getWidth();
    }
}

$img = new ProxyImg();
$width = $img->getWidth();
echo $width;
