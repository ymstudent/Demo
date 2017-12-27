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
        //进行链表的反转，将指向下一个节点的指针，指向前一个节点，这时出现链表的断裂
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
    //1->2->3->4->5
    $head = null;
    //第二个节点
    $next = $pHead->next;
    while ($next->next != null) {
        //利用$head保存第三个节点
        $head = $next->next;
        //将第三个节点换为第四个节点 1->2->3->4->5
        $next->next = $head->next;
        //第四个节点换为第二个节点
        $head->next = $pHead->next;
        //将第三个节点插入到第一个节点的后面
        $pHead->next = $head;
    }
    $head->next = $pHead;//相当于成环
    $pHead = $next->next->next;//新head变为原head的next
    $next->next->next = null;//断掉环
    return $pHead;
}