<?php
/**
 * 
 * 输入一个矩阵，按照从外向里以顺时针的顺序依次打印出每一个数字，例如，如果输入如下矩阵：
 * 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 则依次打印出数字1,2,3,4,8,12,16,15,14,13,9,5,6,7,11,10.
 *
 * 思路：矩阵在php中就是一个二维的数组，先画出这个矩阵
 * 1  2  3  4
 * 5  6  7  8
 * 9  10 11 12
 * 13 14 15 16
 * 顺时针打印其实就是按圈数循环打印，一圈包含2行2列，需要注意的是在某些时候一圈只包含单行或者单列(如将上述
 * 例子减去最后一行)，这时需要注意重复输出的问题
 * 举个例子：输入的矩阵为单行矩阵，1 2 3 4 5时，如果没有加入对单行，单例情况的判断，最后的输出为
 * 1 2 3 4 5 4 3 2
 */

function printMatrix($matrix)
{
    //12345
    $col = count($matrix[0]);
    $row = count($matrix);

    if($col == 0 || $row == 0) {
        return $matrix;
    }

    $result = [];
    //[0,0],[0,3],[3,0],[3,3] 四个顶点

    $left = 0; $right = $col-1; $top = 0; $bottom = $row-1;
    while ($left <= $right && $top <= $bottom) {
        //输出最上边行[0，0],[0,1],[0,2],[0,3]
        for($i=$left; $i<=$right; $i++){
            array_push($result, $matrix[$top][$i]);
        }
        //输出最右边一列 [1,3], [2,3], [3,3]
        for ($i=$top+1; $i<=$bottom; $i++){
            array_push($result,$matrix[$i][$right]);
        }
        //防止单列的情况，避免重复打印（如果是单例，这里的输出就会和第一个for循环的输出重复）
        if($top != $bottom) {
            //输出最下边一行 [3,2], [3,1],[3,0]
            for($i=$right-1; $i>=$left; $i--){
                array_push($result, $matrix[$bottom][$i]);
            }
        }
        //防止单行的情况，避免重复打印（如果是单行，这里的输出就会和第二个for循环的输出重复）
        if($left != $right) {
            //输出最左边一列 [2,0],[1,0]
            for ($i=$bottom-1; $i>$top; $i--){
                array_push($result, $matrix[$i][$left]);
            }
        }
        $left++; $right--; $top++; $bottom--;
    }
    return $result;
}