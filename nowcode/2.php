<?php
/**
 * 大家都知道斐波那契数列，现在要求输入一个整数n，请你输出斐波那契数列的第n项。
 * n<=39
 */

//斐波那契数列：F(n) = F(n-1) + F(n-2),从第三个数开始，每一项都为前两项的和

function Fibonacci($n)
{
    //采用递归，内存溢出
    //return Fibonacci($n-1)+Fibonacci($n-2);
    //采用迭代
    if($n==0){
        return 0;
    }
    if($n==1){
        return 1;
    }
    $f1=0;
    $f2=1;
    for($i=2;$i<=$n;$i++){
        $value = $f1+$f2;
        $f1 = $f2;
        $f2 = $value;
    }
    return $value;
}