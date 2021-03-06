<?php
/**
 * 我们可以用2*1的小矩形横着或者竖着去覆盖更大的矩形。
 * 请问用n个2*1的小矩形无重叠地覆盖一个2*n的大矩形，总共有多少种方法？
 * 思路：和前面2道题一样，看着没有什么办法，直接用归纳法试试呗
 * 通过归纳法发现规律为：f(n) = f(n-1)+f(n-2)，哈哈，又是斐波那契数列
 */
function rectCover($n)
{
    if($n == 0){
        return 0;
    }
    if($n == 1){
        return 1;
    }
    if($n == 2){
        return 2;
    }
    $f1 = 1;
    $f2 = 2;
    for($i=2;$i<$n;$i++){
        $rel = $f1+$f2;
        $f1 = $f2;
        $f2 = $rel;
    }
    return $rel;
}

/**
 * 这道题可以归类为：用1*m方块覆盖m*n区域
 * 这类问题基本上都可以套用公司：f(n) = f(n-1)+f(n-m) (n>m)
 */