<?php

/**
 * 输入两棵二叉树A，B，判断B是不是A的子结构。（ps：我们约定空树不是任意一个树的子结构）
 * 思路：对于二叉树的操作，我们大多数都可以通过递归的解决
 * 对于这道题，我们可以分成两部分来看：
 * 1、搜索A树中是否含有和B树的根节点root2值一样的节点
 * 2、判断A中以root2为根节点的子树是否包含和树B一样的结构
 */
class TreeNode
{
    var $val;
    var $left = NULL;
    var $right = NULL;

    function __construct($val)
    {
        $this->val = $val;
    }
}

function HasSubtree($pRoot1, $pRoot2)
{
    $result = false;
    //当A树或者B树为空时，直接返回false
    if($pRoot1 == null || $pRoot2 == null){
        return false;
    }
    if ($pRoot1->val == $pRoot2->val) {
        //如果找到和B树根节点相等的值，查找是不是有一样的结构
        $result = isSubTree($pRoot1, $pRoot2);
    }
    //如果当前节点的值不等于B树的根节点的值，就从左树中查找
    if (!$result) {
        $result = HasSubtree($pRoot1->left, $pRoot2);
    }
    //如果左树中也没有，就从右树查找
    if (!$result) {
        $result = HasSubtree($pRoot1->right, $pRoot2);
    }

    return $result;
}

function isSubTree($pRoot1, $pRoot2)
{
    //如果pRoot2已经遍历完成了，并且结构一样，返回true
    if ($pRoot2 == null) {
        return true;
    }
    //如果pRoot1先遍历完成，返回false
    if ($pRoot1 == null) {
        return false;
    }
    //如果节点值不同，返回false
    if ($pRoot1->val != $pRoot2->val) {
        return false;
    }
    //如果当前节点的值一样，就去子树中继续验证
    return isSubTree($pRoot1->left, $pRoot2->left) && isSubTree($pRoot1->right, $pRoot2->right);
}