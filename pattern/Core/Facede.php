<?php
/**
 * 外观模式（门面模式）：为一个复杂的系统创建一个简单、清晰的接口。
 */
namespace Ym\Demo\Pattern;

/**
 * 例如：利用电脑执行一段程序有下面几个操作：
 * 1、利用输入设备输入指令
 * 2、CPU根据指令从内存中读取数据
 * 3、如果内存中没有数据则从磁盘中读取
 * 4、输出程序输出程序执行结果
 */
class InputDevice
{
    public function input()
    {
        return "input device";
    }
}

class OutDevice
{
    public function output($data)
    {
        return "output " . $data;
    }
}

class Memory
{
    public function getData(InputDevice $input)
    {
        return "get data from memory according to " . $input->input();
    }
}

class Disk
{
    public function getData(InputDevice $input)
    {
        return "get data from disk according to " . $input->input();
    }
}

class CPU
{
    public function deal(InputDevice $input)
    {
        $memory = new Memory();
        $data = $memory->getData($input);
        if(!$data){
            $disk = new Disk();
            $data = $disk->getData($input);
        }
        return $data;
    }
}

//客户端操作
$input = new InputDevice();
$cpu = new CPU();
$data = $cpu->deal($input);
$outPut = new OutDevice();
$out = $outPut->output($data);
echo $out;

/**
 * 下面我们将这些类（子系统）封装到一个总的系统中，只留下一个操作接口
 * Class Facede
 * @package Ym\Demo\Pattern
 */
class Facede
{
    private $inPut;
    private $cpu;
    private $outPut;

    public function __construct()
    {
        $this->inPut = new InputDevice();
        $this->outPut = new OutDevice();
        $this->cpu = new CPU();
    }

    public function excProcess()
    {
        $data = $this->cpu->deal($this->inPut);
        return $this->outPut->output($data);
    }
}

//客户端操作
$facade = new Facade();
echo $facade->process();

/**
 * 我们将多个子系统一起进行的复杂操作，封装成了一个简单的接口，这样客户端在调用时，不需要
 * 知道我们里面具体是怎么进行程序的执行的，他只需要调用我们留给他的接口就行了，并且，如果
 * 以后我们需要增加一步从数据库中读取数据的操作的话，我们只要改变内部的逻辑就行，客户端的
 * 代码是不需要进行改变。
 */

