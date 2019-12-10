<?php
/**
 *
 * 数组中有一个数字出现的次数超过数组长度的一半，请找出这个数字。
 * 例如输入一个长度为9的数组{1,2,3,2,2,2,5,4,2}。由于数字2在数组中出现了5次，
 * 超过数组长度的一半，因此输出2。如果不存在则输出0。
 *
 * 思路1：php中有一个array_count_values()函数能够统计出数组中各个值出现的次数。
 * 通过这个函数，这道题就变得很简单了。
 */

function MoreThanHalfNum_Solution($numbers)
{
    $num = count($numbers)/2;
    $arr = array_count_values($numbers);
    foreach($arr as $key=>$d){
        if($d > $num){
            return $key;
        }
    }
    return 0;
}

/**
 * 思路2：将数组进行排序，取其中间数，如果数组中有超过一半的相同数，则中间数，肯定是那个数，那么我们只要统计中间
 * 数出现的次数是否超过一半，就能得出结果
 */
function MoreThanHalfNum_Solution2($numbers)
{
    $num = count($numbers);
    if($num < 1){
        return 0;
    }
    sort($numbers);
    $md = ceil($num/2);
    $md_num = $numbers[$md-1];
    $count = 0;
    foreach ($numbers as $d){
        if($d == $md_num){
            $count++;
        }
    }
    if($count >= $md){
        return $md_num;
    }else{
        return 0;
    }
}