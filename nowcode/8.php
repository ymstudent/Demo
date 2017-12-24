<?php
/**
 * 输入一个整数数组，实现一个函数来调整该数组中数字的顺序，使得所有的奇数位于数组的前半部分，
 * 所有的偶数位于位于数组的后半部分，并保证奇数和奇数，偶数和偶数之间的相对位置不变。
 * 思路：这道题很简单，没什么说的，奇数一个数组，偶数一个数组，然后合并就行了
 */

function reOrderArray($array)
{
    $left_arr = [];
    $right_arr = [];
    foreach ($array as $item) {
        if(($item%2) == 0) {
            $right_arr[] = $item;
        }else{
            $left_arr[] = $item;
        }
    }
    return array_merge($left_arr, $right_arr);
}