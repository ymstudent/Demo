<?php
/**
 * 输入两个整数序列，第一个序列表示栈的压入顺序，请判断第二个序列是否为该栈的弹出顺序。
 * 假设压入栈的所有数字均不相等。例如序列1,2,3,4,5是某栈的压入顺序，序列4，5,3,2,1是该压栈序列对应的一个弹出序列，
 * 但4,3,5,1,2就不可能是该压栈序列的弹出序列。（注意：这两个序列的长度是相等的）
 * 思路：看到这个题的时候我是一脸蒙蔽的，完全不知道怎么做啊，想了半个小时后，百度之。找到一个比较容易理解的思路
 * 借用一个辅助栈，遍历入栈顺序，先将第一个放入辅助栈中，这里是1，然后判断栈顶元素是不是出栈顺序的第一个元素，
 * 这里是4，很显然1≠4，所以我们继续压栈，直到相等以后开始出栈，出栈一个元素，则将出栈顺序向后移动一位，
 * 直到不相等，这样循环等压栈顺序遍历完成，如果辅助栈还不为空，说明弹出序列不是该栈的弹出顺序。
 * 举例：
 * 入栈1,2,3,4,5
 * 出栈4,5,3,2,1
 * 首先1入辅助栈，此时栈顶1≠4，继续入栈2
 * 此时栈顶2≠4，继续入栈3
 * 此时栈顶3≠4，继续入栈4
 * 此时栈顶4＝4，出栈4，弹出序列向后一位，此时为5，,辅助栈里面是1,2,3
 * 此时栈顶3≠5，继续入栈5
 * 此时栈顶5=5，出栈5,弹出序列向后一位，此时为3，,辅助栈里面是1,2,3
 * ….
 * 依次执行，最后辅助栈为空。如果不为空说明弹出序列不是该栈的弹出顺序。
 *
 * 这种方法其实就是模拟了一遍入栈出栈。
 * 下面是php的实现方式
 */

function IsPopOrder($pushV, $popV)
{
    if(count($pushV) == 0 || count($popV) == 0) {
        return false;
    }

    $splStack = new SplStack(); //php SPL库中定义的栈
    $len = count($pushV);   //栈长度
    $j=0;
    for ($i=0; $i<$len; $i++) {
        //遍历入栈序列，将元素按入栈顺序压入辅助栈中
        $splStack->push($pushV[$i]);
        //判断辅助栈中的栈顶是否和出栈序列的第一个元素相等
        while($j<$len && $popV[$j] == $splStack->top()) {
            //如果相等，将该元素从辅助栈中出栈，并将出栈序列后移一位
            $splStack->pop();
            $j++;
        }
    }
    //当入栈序列遍历完之后，如果辅助栈中为空，则表示弹出序列是该栈的弹出顺序
    return $splStack->isEmpty() ? true : false;
}