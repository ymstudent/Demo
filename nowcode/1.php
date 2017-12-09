<?php
/**
 * 在一个二维数组中，每一行都按照从左到右递增的顺序排序，每一列都按照从上到下递增的顺序排序。
 * 请完成一个函数，输入这样的一个二维数组和一个整数，判断数组中是否含有该整数。
 */
//思路一：进行2次遍历，逐个对比，找出该整数
function Find1($target, $array)
{
    foreach ($array as $d) {
        foreach ($d as $item) {
            if ($target == $item) {
                return true;
            }
        }
    }
    return false;
}

$array = array(
    '1' => array(1, 2, 3),
    '2' => array(2, 3, 4)
);

//思路二：矩阵是有序，从左下角来看，向右是递增的，向上是递减的，如果$target比该数小，上移动，大，右移
function Find2($target, $array)
{
    $row = count($array) - 1;
    $col = 0;
    while ($col <= count($array[$row]) - 1 && $row >= 0) {
        if ($target == $array[$row][$col]) {
            return true;
        }elseif ($target>$array[$row][$col]){
            $col++;
        }else{
            $row--;
        }
    }
    return false;
}