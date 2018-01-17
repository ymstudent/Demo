<?php
/**
 * fluent interface流利接口，又被称为链式操作，在很多框架的数据库操作中都有这样的模式(TP,CI,Laravel等)，这个操作的特点
 * 就是每个方法都会返回一个$this(对象本身)。
 */

namespace Ym\Demo\Pattern;


class Fluent
{
    private $name;
    private $age;
    private $sex;

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setAge($age)
    {
        $this->age = $age;
        return $this;
    }

    public function setSex($sex)
    {
        $this->sex = $sex;
        return $this;
    }

    public function __toString()
    {
        $userInfo = '';
        $userInfo .= 'Name：' . $this->name . PHP_EOL;
        $userInfo .= 'Age：' . $this->age . PHP_EOL;
        $userInfo .= 'Sex：' . $this->sex . PHP_EOL;

        return $userInfo;
    }
}

$user = new Fluent();
echo $user->setName('Tom')->setAge('18')->setSex('man');    //Name：Tom Age：18 Sex：man