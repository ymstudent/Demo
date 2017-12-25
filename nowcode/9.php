<?php
/**
 * 输入一个链表，输出该链表中倒数第k个结点。
 * 思路：什么是链表：链表是一种常用的数据结构，链表中的每一个元素都至少有两个元素，
 * 一个指向它的下一个元素，一个用来存放它自己的数据。看起来是不是很像php的数组。但是它和数组是有区别的：
 * 1.数组静态分配内存，链表动态分配内存
 * 2.数组在内存中连续，链表不连续
 * 3.数组元素在栈区，链表元素在堆区
 * 4.数组利用下标定位，时间复杂度为O(1)，链表定位元素时间复杂度O(n)；
 * 5.数组插入或删除元素的时间复杂度O(n)，链表的时间复杂度O(1)。
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
    //让第一个指针移动到$k处
    for($i=1;$i<$k;$i++){
        if($pre->next != null){
            $pre = $pre->next;
        }else{
            return null;
        }
    }
    //同时移动2个指针，直到第一个指针到达链表尾部
    while($pre->next != null){
        $pre = $pre->next;
        $last = $last->next;
    }
    return $last;
}