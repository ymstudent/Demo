<?php
/**
 * 给定一个double类型的浮点数base和int类型的整数exponent。求base的exponent次方。
 * 这个题目用php来做非常简单，因为php中有一个现有的函数pow(x,y)，可以求出x的y次方，哈哈哈，算不算作弊啊
 * 按照题目的意图来说，是为了考察代码的完整性，也就是看我们能不能找出所有的可能性。一个一个来呗
 * 1、exponent>=0,指数大于等于0，就是base的exponent次方
 * 2、exponent<0,就是base的abs(exponent)次方，然后取倒数
 */
function Power($base, $exponent)
{
    $rel = 1;
    for($i=0;$i<abs($exponent);$i++){
        $rel *= $base;
    }
    if($exponent<0){
        $rel = 1/$rel;
    }
    return $rel;
}

