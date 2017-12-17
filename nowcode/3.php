<?php
/**
 * 题目：一只青蛙一次可以跳上1级台阶，也可以跳上2级。求该青蛙跳上一个n级的台阶总共有多少种跳法。
 * 1个台阶：1种
 * 2个台阶：2种
 * 3个台阶：3种
 * 4个台阶：5种
 * 5个台阶：8种
 * 由上面可以看出，跳台阶的规律符合斐波那契：f(n) = f(n-1)+f(n-2);
 * 那么此题其实就是2.php的变形，采用迭代的方式计算
 */
function jumpFloor($n)
{
    if($n==0){
        return 0;
    }
    if($n==1){
        return 1;
    }
    if($n==2){
        return 2;
    }
    $f1 = 1;
    $f2 = 2;
    for($i=2; $i<$n; $i++){
        $rel = $f1+$f2;
        $f1 = $f2;
        $f2 = $rel;
    }
    return $rel;
}