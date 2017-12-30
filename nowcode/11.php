<?php
/**
 * 输入两个单调递增的链表，输出两个链表合成后的链表，当然我们需要合成后的链表满足单调不减规则。
 * 思路：做这道题的时候，想了一会也没什么好思路，就只能用蠢办法了，循环链表进行比较，刚开始写的时候思路还
 * 不是很清晰，但是慢慢写着写着，就写出来了
 */
function Merge($p1, $p2)
{
    if($p1 == null){
        return $p2;
    }
    if($p2 == null){
        return $p1;
    }
    //去较小的作为合并链表的头部
    if($p1->val >= $p2->val){
        $head = $p2;
        //p2后移动一位
        $p2 = $p2->next;
    }else{
        $head = $p1;
        $p1 = $p1->next;
    }
    //循环比较大小
    while($p1 && $p2){
        if($p1 >= $p2){
            $head->next = $p2;
            $p2 = $p2->next;
        }else{
            $head->next = $p1;
            $p1 = $p1->next;
        }

    }
    //将指针指向链表剩下的部分
    if($p1 == null){
        $head->next = $p2;
    }
    if($p2 == null){
        $head->next = $p1;
    }
    return $head;
}
/**
 * 代码写完后，看了一下，感觉没有问题，然后提交，又被啪啪啪打脸了，输入{1,3,5},{2,4,6},输出{5,6}.
 * WTF???为什么只剩下最后2个节点了？
 * 看了一下其他人的解答，发现34行，将新链表后移时，出现了问题，这里其实并没有后移，而是不断把新链表
 * 的开头重置！！！，所以到了最后循环完之后，新链表其实只有{5}一个节点。
 * 正确的解法：此解法的详细说明：http://ymfeb.cn/articles/42
 */
function Merge2($p1, $p2)
{
    if($p1 == null){
        return $p2;
    }
    if($p2 == null){
        return $p1;
    }
    //取较小的为合并链表的头部
    if($p1->val >= $p2->val){
        $head = $p2;
        //将p2的头部指针后移一位
        $p2 = $p2->next;
    }else{
        $head = $p1;
        $p1 = $p1->next;
    }
    //php中对象的复制，其实就是引用操作，$head和$p其实指向的是同一个内存，所以对$p增加节点同时也会对$head产生影响
	//此操作其实就是将$P的指针指向新链表的头部，此后随着新链表中节点的增加$p的指针也不断的向后移动，但是$head的指针却依然指向链表头部
    $p = $head;
    //循环比较大小
    while($p1 && $p2){
        if($p1->val >= $p2->val){
            //链表增加
            $p->next = $p2; 
            //表头指针后移
            $p2 = $p2->next;
        }else{
            $p->next = $p1;
            $p1 = $p1->next;
        }
        //表头指针后移
        $p = $p->next;
    }
    //将指针指向链表剩下的部分
    if($p1 == null){
        $p->next = $p2;
    }
    if($p2 == null){
        $p->next = $p1;
    }
    return $head;
}
/**
 * 这里为什么是返回$head而不是返回$p呢？其实此时的$p和$head其实都是{1,2,3,4,5,6}但是$p的头部指针一直在变动，
 * 到循环的最后变成了5，而$head的头部指针却一直指向1,所以他返回的是一个完整的链表{1,2,3,4,5,6}
 */

/**
 * 除了这种循环迭代的方式之外，还有一种递归的方法
 */
function Merge3($pHead1, $pHead2)
{
    if($pHead1 == NULL)
        return $pHead2;
    elseif($pHead2 == NULL)
        return $pHead1;
    $pMergeHead = NULL;
    if($pHead1->val < $pHead2->val){
        $pMergeHead = $pHead1;
        $pMergeHead->next = Merge3($pHead1->next, $pHead2);
    }else{
        $pMergeHead = $pHead2;
        $pMergeHead->next = Merge3($pHead1, $pHead2->next);
    }
    return $pMergeHead;
}