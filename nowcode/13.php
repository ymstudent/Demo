<?php
/**
 * 操作给定的二叉树，将其变换为源二叉树的镜像。
 * 二叉树的镜像定义：源二叉树
 *      8
 *    /  \
 *   6   10
 *  / \  / \
 * 5  7 9 11
 * 镜像二叉树
 *     8
 *   /  \
 *  10   6
 *  / \  / \
 * 11 9 7  5
 *
 * 思路：一样的，涉及到二叉树的我们首先的反应就是递归能不能得出结果，
 * 对于这道题，无非就是替换一下左右树而已，递归来解就很简单了
 */
function Mirror(&$root)
{
    if($root == null){
        return null;
    }
    //替换左右树
    $tmp = $root->left;
    $root->left = $root->right;
    $root->right = $tmp;
    //递归
    if($root->left != null){
        Mirror($root->left);
    }
    if($root->right != null){
        Mirror($root->right);
    }
}

