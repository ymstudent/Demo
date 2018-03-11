<?php
/**
 * 输入n个整数，找出其中最小的K个数。例如输入4,5,1,6,2,7,3,8这8个数字，则最小的4个数字是1,2,3,4
 * 思路：排序然后选取数组的前K个值就行。只需要注意传入的数组为空或者长度小于k的情况。
 * 问题：这里我一开始使用的是快速排序方法来排序输入数组，结果显示内存溢出
 * 然后换成了php自带的数组排序函数。
 */

function GetLeastNumbers_Solution($input, $k)
{
    // write code here
    $length=count($input);
    $result=array();
    if($length>0 && $length>=$k){
        //$input = FastSort($input);
        sort($input);
        $result = array_slice($input,0,$k);
        return $result;
    }else{
        return $result;
    }
}

function FastSort($arr){
    $base_num = $arr[0];
    $left_arr = array();
    $right_arr = array();

    for($i=1;$i<count($arr);$i++){
        if($arr[$i]>$base_num){
            $right_arr[] = $arr[$i];
        }else{
            $left_arr[] = $arr[$i];
        }
    }

    $left_arr = FastSort($left_arr);
    $right_arr = FastSort($right_arr);

    return array_merge($left_arr,array($base_num),$right_arr);
}