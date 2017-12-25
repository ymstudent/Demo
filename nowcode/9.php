<?php
/**
 * 输入一个链表，输出该链表中倒数第k个结点。
 * 思路：什么是链表：链表是一种常用的数据结构，链表中的每一个元素都至少有两个元素，
 * 一个指向它的下一个元素，一个用来存放它自己的数据。
 * 具体的代码思路为：两个指针，先让第一个指针和第二个指针都指向头结点，然后再让第一个指正走(k-1)步，到达第k个节点。
 * 然后两个指针同时往后移动，当第一个结点到达末尾的时候，第二个结点所在位置就是倒数第k个节点了。
 */
class ListNode{
    var $val;
    var $next = NULL;
    function __construct($x){
        $this->val = $x;
    }
}

function FindKthToTail($head, $k)
{
    if($k <=0){
        return null;
    }
    $pre = $head;
    $last = $head;
    //让di
    for($i=1;$i<$k;$i++){
        if($pre->next != null){
            $pre = $pre->next;
        }else{
            return null;
        }
    }
    while($pre->next != null){
        $pre = $pre->next;
        $last = $last->next;
    }
    return $last;
}