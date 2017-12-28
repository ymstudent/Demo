<?php
/**
 * 输入一个链表，反转链表后，输出链表的所有元素。
 * 反转链表，面试常用题，但是看到这个题目的一瞬间，我就想起了前一天的那个题目：
 * 输入一个链表，从尾到头打印链表每个节点的值。
 * 握草，差点以为题目出重复了有木有，所以直接写了下面的代码：
 */

function ReverseList($pHead)
{
    $list = [];
    while($pHead != null){
        $list[] = $pHead;
        $pHead = $pHead->next;
    }
    return array_reverse($list);
}
/**
 * 测试结果就是无情被打脸，哈哈，通过率百分之0，测试用例为{1,2,3,4,5}，应输{5,4,3,2,1}，我的输出{0}
 */

/**
 * 在网上看了一下链表的反转后，理了2个比较容易理解的思路
 * 1、使用3个指针遍历单链表，逐个链接点进行反转。
 * 这里为什么要使用3个指针了？主要是为了防止链表断裂，详细解释可以看这篇博客https://www.cnblogs.com/kubixuesheng/p/4394509.html
 */
function ReverseList2($pHead)
{
    if($pHead == null){
        return null;
    }
    //当前节点的前一个节点
    $pre = null;
    //当前节点的下一个节点
    $next = null;
    //$head指向当前节点
    $head = $pHead;
    while ($head != null) {
        //使用$next保存下一个节点，保证单链表不会因为失去head节点的原next节点而就此断裂
        $next = $head->next;
        //进行链表的反转，将指向下一个节点的指针，指向前一个节点，这时可能出现链表的断裂
        //1->2->3->4->5
        //1<-2<-3 4->5
        $head->next = $pre;
        //将链表后移一位(前一节点=当前节点，当前节点=$next保存的节点)
        $pre = $head;
        $head = $next;
    }
    return $pre;
}

/**
 * 2、从第2个节点到第N个节点，依次逐节点插入到第1个节点(head节点)之后，最后将第一个节点挪到新表的表尾。
 * 此解法参考：http://blog.csdn.net/feliciafay/article/details/6841115
 */
function ReverseList3($pHead)
{
    //如果链表为空或者只有一个元素，直接返回
    if($pHead == null || $pHead->next == null){
        return $pHead;
    }
    //1->2->3->4->5
    $next = null;
    //将原始链表的第二个节点保存在$p2中(此处为2)
    $p2 = $pHead->next;
    while ($p2->next != null) {
        //利用$next保存$p2的下一个节点（第一次循环时为3，第二此循环时为4）
        $next = $p2->next;
        //将$p2指针指向本次链表的第四个节点（实际作用就是将p2后移一位）； 第一次：1->2->4->5 第二次：1->3->2->5
        $p2->next = $next->next;
        //将本次链表第三个节点的指针指向第二个节点 2->4->5(此时1，3的指针都指向2)  3->2->5(此时1和4都指向3)
        $next->next = $pHead->next;
        //将链表的第一个节点的指针直指向本次链表第三个节点 1->3->2->4->5  1->4->3->2->5
        $pHead->next = $next;
    }
    //循环完成后，$p2已经处于链表的尾部
    //将$p2的指针指向链表头部,相当于成环
    $p2->next = $pHead;
    //将新链表的头部设置为$p2的下下个节点，其实就是循环后链表的第二个节点
    $pHead = $p2->next->next;
    //将循环后链表的第一个节点的指针，指向null，链表断开，此时链表的反转完成
    $p2->next->next = null;
    return $pHead;
}