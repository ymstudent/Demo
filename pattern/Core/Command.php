<?php
/**
 * 命令模式：其别名为动作(Action)模式或事务(Transaction)模式。
 * 将一个请求封装为一个对象，从而使我们可用不同的请求对客户进行参数化。
 * 命令模式的本质是对命令进行封装，将发出命令的责任(请求者)和执行命令(接受者)的责任分割开。
 * 每一个命令都是一个操作：请求的一方发出请求，要求执行一个操作；接收的一方收到请求，并执行操作。
 */

namespace Ym\Demo\Pattern;

/**
 * 命令接口，定义具体命令要实现的函数
 * Interface Command
 * @package Ym\Demo\Pattern
 */
interface Command
{
    public function execute();
}

/**
 * 具体命令类--指定接受者执行攻击命令
 * Class AttackCommand
 * @package Ym\Demo\Pattern
 */
class AttackCommand implements Command
{
    private $receiver;

    public function __construct(Receiver $receiver)
    {
        $this->receiver = $receiver;
    }

    public function execute()
    {
        // TODO: Implement execute() method.
        $this->receiver->attackAction();
    }
}

/**
 * 具体命令类--指定接受者执行防御命令
 * Class DefenseCommand
 * @package Ym\Demo\Pattern
 */
class DefenseCommand implements Command
{
    private $receiver;

    public function __construct(Receiver $receiver)
    {
        $this->receiver = $receiver;
    }

    public function execute()
    {
        // TODO: Implement execute() method.
        $this->receiver->defenseAction();
    }
}

/**
 * 接受者类--接受并执行命令
 * Class Receiver
 * @package Ym\Demo\Pattern
 */
class Receiver
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function attackAction()
    {
        return $this->name . '执行了攻击命令';
    }

    public function defenseAction()
    {
        return $this->name . '执行了防御命令';
    }
}

/**
 * 请求者--请求执行具体命令
 * Class Invoker
 * @package Ym\Demo\Pattern
 */
class Invoker
{
    private $concreteCommand;

    public function __construct($concreteCommand)
    {
        $this->concreteCommand = $concreteCommand;
    }

    public function executeCommand()
    {
        $this->concreteCommand->excute();
    }
}

/**
 * 客户端类
 * Class Client
 * @package Ym\Demo\Pattern
 */
class Client
{
    public function __construct()
    {
        $receiverZhang = new Receiver("张三");
        $attackCommand = new AttackCommand($receiverZhang);
        $attackInvoker = new Invoker($attackCommand);
        $attackInvoker->executeCommand();

        $receiverYe = new Receiver("李四");
        $defenseCommand = new DefenseCommand($receiverYe);
        $defenseInvoker = new Invoker($defenseCommand);
        $defenseInvoker->executeCommand();
    }
}

