<?php
/**
 * 定义栈的数据结构，请在该类型中实现一个能够得到栈最小元素的min函数。
 * 栈的定义：栈，又叫做堆栈，是一种运算受限的线性表，只允许在表的一端进行插入和删除运算，这一端被成为栈顶，
 * 又叫表尾，用栈顶指针(top)表示栈顶元素。另一端被称为栈尾，又叫表头。在栈中，元素总是先进后出。
 * 本题思路：
 * 1、dataStack为存储数据的栈，minStack为存储最小值的栈；
 * 2.push的时候将node值与minStack中的top值比较，小则minStack push node，大则push top值
 * data中依次入栈，5,  4,  3, 8, 10, 11, 12, 1
 * 则min依次入栈，5,  4,  3，no,no, no, no, 1；no表示此次不入栈
 * 那么出栈时，如果data中的出栈元素和min中的top元素相等，则，也进行出栈操作
 */

/**
 * 实现栈的链式存储和基本栈操作
 * Class Stack
 */
class Stack
{
    /**
     * 栈
     * @var array
     */
    private $stack;

    /**
     * 栈长度
     * @var integer
     */
    private $size;

    /**
     * 初始化栈
     * Stack constructor.
     */
    public function __construct()
    {
        $this->stack = array();
        $this->size = 0;
    }

    /**
     * 判断是否是空栈
     * @return boolean
     */
    public function isEmpty()
    {
        return 0 === $this->size;
    }

    /**
     * 实现元素入栈
     * @param mixed $node
     * @return object $this
     */
    public function push($node)
    {
        $this->stack[$this->size++] = $node;

        return $this;
    }

    /**
     * 实现元素出栈，空栈时返回false，否则返回栈顶元素
     * @return mixed
     */
    public function pop()
    {
        if(!$this->isEmpty()){
            $top = array_splice($this->stack, --$this->size, 1);
            return $top[0];
        }
        return false;
    }

    /**
     * 获取栈顶元素
     * @return bool|mixed
     */
    public function getTop()
    {
        if(!$this->isEmpty()) {
            return $this->stack[$this->size - 1];
        }
        return false;
    }

    /**
     * 获取栈
     * @return array
     */
    public function getStack()
    {
        return $this->stack;
    }

    /**
     * 获取栈长度
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }
}

$dataStack = new Stack();
$minStack = new Stack();

function myPush($node)
{
    global $dataStack;
    global $minStack;
    $dataStack->push($node);
    //当minStack为空栈，或者minStack的栈顶元素大于$node时，将$node压如minStack
    if($minStack->isEmpty() || $minStack->getTop() > $node){
        $minStack->push($node);
    }
}

function myPop()
{
    global $dataStack;
    global $minStack;
    $node = $dataStack->pop();
    if($node == $minStack->getTop()){
        $minStack->pop();
    }
}

function myTop()
{
    global $dataStack;
    return $dataStack->getTop();
}

function myMin()
{
    global $minStack;
    return $minStack->getTop();
}
