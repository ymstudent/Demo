<?php
/**
 * 输入一个复杂链表（每个节点中有节点值，以及两个指针，一个指向下一个节点，另一个特殊指针指向任意一个节点），
 * 返回结果为复制后复杂链表的head。（注意，输出结果中请不要返回参数中的节点引用，否则判题程序会直接返回空）
 *
 */
class RandomListNode{
    var $label;
    var $next = NULL;
    var $random = NULL;
    function __construct($x){
        $this->label = $x;
    }
}

/**
 * 递归思路，
 * 测试通过，但是其实这个思路是错误的
 * 递归的random指向的还是没有复制前的节点，而复制链表要求的是指向新节点，所以是有问题的。
 * @param RandomListNode $pHead
 * @return RandomListNode
 */
function MyClone(RandomListNode $pHead)
{
    if($pHead == null) {
        return $pHead;
    }
    $pCloneHead = new RandomListNode($pHead->label);
    $pCloneHead->random = $pHead->random;
    $pCloneHead->next = MyClone($pHead->next);
    return $pCloneHead;
}