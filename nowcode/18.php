<?php
/**
 * 从上往下打印出二叉树的每个节点，同层节点从左至右打印。
 * 思路：昨天的题目，让我了解到了而二叉树的3种遍历方式，而这个题目考察的就是二叉树的最后一种遍历
 * 方式：层序遍历。在层序遍历中，所有深度为D的节点要在深度D+1的节点之前进行处理。他与其余遍历的
 * 最大不同之处在于他不是递归实现的；他用到了队列而不是使用递归所默示的栈。
 * 分析如下：
 * 1.如果此二叉树为空直接返回；
 * 2.要想层序遍历二叉树，我们必须要一个容器来保存它的左右孩子节点
 * 3.这个容器必须是先进先出，所以我们选择队列
 * 4.已经遍历过的节点必须从队列中移除
 */

function PrintFromTopToBottom($root)
{
    //申明数组，用来保存输出结果
    $list = [];
    if($root == null){
        return $list;
    }
    //申明辅助队列，用来保存左右孩子
    $splQueue= new SplQueue();
    $splQueue->enqueue($root);
    while (!$splQueue->isEmpty()) {
        $tmp = $splQueue->dequeue();
        if($tmp->left != null) {
            $splQueue->enqueue($tmp->left);
        }
        if($tmp->right != null) {
            $splQueue->enqueue($tmp->right);
        }
        array_push($list, $tmp->val);
    }
    return $list;
}