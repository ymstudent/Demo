<?php
/**
 * 题目：一群猴子排成一圈，按1，2，...，n依次编号。然后从第1只开始数，数到第m只,把它踢出圈，
 * 从它后面再开始数，再数到第m只，在把它踢出去...，如此不停的进行下去，直到最后只剩下一只猴子为止，
 * 那只猴子就叫做大王。要求编程模拟此过程，输入m、n, 输出最后那个大王的编号
 */

/**
 * @param $n //猴子数
 * @param $m //出局数
 * @return int
 */
function monkeyKing($n, $m)
{
    //定义一个数组
    for($i=1;$i<$m+1;$i++){
        $arr[]=$i;
    }
    //设置数组指针
    $i=0;
    //循环数组,判断猴子次数
    while(count($arr)>1){
        if(($i+1)%$n==0){
            unset($arr[$i]);//把第m只猴子踢出去
        }else{
            array_push($arr,$arr[$i]);//把第m只猴子放在最后面
            unset($arr[$i]);//删除
        }
        $i++;
    }
    return $arr[$i];//返回结果
}

//约瑟夫环
function getSucessUserNum()
{
    $data = range(1, N);

    if(empty($data)) return false;

    //第一个报数的位置
    $start_p = (P-1);

    while(count($data) > 1)
    {
        //报到数出列的位置
        $del_p = ($start_p  + M - 1) % count($data);

        if(isset($data[$del_p]))
        {
            unset($data[$del_p]);
        }
        else
        {
            break;
        }

        //数组从新排序
        $data = array_values($data);

        $new_count = count($data);

        //计算出在新的$data中，开始报数的位置
        $start_p = ($del_p >= $new_count) ? ($del_p % $new_count) : $del_p;
    }

    echo  "<br> successful num : " . $data[0] . "<br><br>";
}