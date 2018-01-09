<?php
/**
 * 输入一颗二叉树和一个整数，打印出二叉树中结点值的和为输入整数的所有路径。
 * 路径定义为从树的根结点开始往下一直到叶结点所经过的结点形成一条路径。
 */

function FindPath($root, $num)
{
    $a = $q = [];
    if (!$root) {
        return $a;
    }
    find($root, $num, $q, $a);
    return $a;
}

function find($root, $sum, $q, &$a)
{
    if ($root !== null) {
        $sum -= $root->val;
        $q[] = $root->val;
        if ($sum > 0) {
            find($root->left, $sum, $q, $a);
            find($root->right, $sum, $q, $a);
        } elseif ($sum == 0 && $root->left == null && $root->right == null) {
            $a[] = $q;
        }
    }
}