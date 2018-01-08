<?php
/**
 * 输入一个整数数组，判断该数组是不是某二叉搜索树的后序遍历的结果。如果是则输出Yes,否则输出No。
 * 假设输入的数组的任意两个数字都互不相同。
 * 二叉搜索树的定义：它或者是一棵空树，或者是具有下列性质的二叉树： 若它的左子树不空，则左子树上
 * 所有结点的值均小于它的根结点的值； 若它的右子树不空，则右子树上所有结点的值均大于它的根结点的值；
 * 它的左、右子树也分别为二叉排序树。
 * 思路：根据二叉搜索树的定义，我们将这个数组的最后一个元素x弹出后，就可以利用x将剩下的数组分为2个部分
 * 小于x的前半部分为左子树，大于x的后半部分为右子树
 */
function VerifySquenceOfBST($sequence)
{
    $flag = true;
    if (count($sequence) == 0) {
        return false;
    }
    if (count($sequence) == 1) {
        return true;
    } else {
        $root_val = array_pop($sequence);
        $less_max_idx = 0;
        //通过遍历找出数组中左子树有多大
        for ($i = 0; $i < count($sequence); $i++) {
            if ($sequence[$i] < $root_val) {
                $less_max_idx = $i;
            }
        }
        //截取出左、右子树
        $left = array_slice($sequence,0, $less_max_idx);
        $right = array_slice($sequence, $less_max_idx+1);
        //验证左子树,必须都比根节点小
        for ($i = 0; $i < count($left); $i++) {
            if ($left[$i] > $root_val) {
                return false;
            }
        }
        //验证右子树，必须都比根节点小
        for ($i = 0; $i < count($right); $i++) {
            if ($right[$i] < $root_val) {
                return false;
            }
        }
        //递归左右子树
        if ($flag && count($left) > 0) {
            $flag &= VerifySquenceOfBST($left);
        }
        if ($flag && count($right) > 0) {
            $flag &= VerifySquenceOfBST($right);
        }
        return $flag;
    }
}