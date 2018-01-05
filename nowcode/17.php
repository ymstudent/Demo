<?php
/**
 * 输入某二叉树的前序遍历和中序遍历的结果，请重建出该二叉树。假设输入的前序遍历和中序遍历的结果中
 * 都不含重复的数字。例如输入前序遍历序列{1,2,4,7,3,5,6,8}和中序遍历序列{4,7,2,1,5,3,8,6}，则重建
 * 二叉树并返回。
 * 二叉树的遍历：
 * 中序遍历：先遍历左子树，然后是当前节点，最后是右子树。--如按顺序打印出二叉树的每个节点
 * 后序遍历：先遍历两颗子树，再处理当前节点。--如计算二叉树某个子树的高度，需要先知道其两颗子树的高度
 * 先序遍历：先处理当前节点，再遍历子树。--常用来利用节点深度标志每一个节点
 * 有了这个基础，我们再来看题目给出的例子：
 * 前序的第一元素就是二叉树的根节点，通过根节点我们可以很容易的在中序遍历序列中找出二叉树
 * 的两个子树{4,7,2}和{5,3,8,6}.将这两子树看成两个新树，他们的前序为{2,4,7}和{3,5,6,8}
 * 根据上面的思想，我们可以很容易找出这两个子树的根节点和左右子树，所以最终重建的二叉树为：
 *               1
 *              / \
 *            2    3
 *           / \  / \
 *         4   7 5   6
 *                  /
 *                 8
 * 下面为代码的实现
 */
class TreeNode{
    var $val;
    var $left = NULL;
    var $right = NULL;
    function __construct($val){
        $this->val = $val;
    }
}
function reConstructBinaryTree($pre, $vin)
{
    if($pre && $vin) {
        //通过前序找出根节点
        $treeNode = new TreeNode($pre[0]);
        //找出中序序列中根节点的位置
        $rootIndex = array_search($pre[0], $vin);
        //通过根节点的位置，找出左右子树的前序序列和中序蓄力，递归即可
        $treeNode->left = reConstructBinaryTree(array_slice($pre,1, $rootIndex), array_slice($vin, 0, $rootIndex));
        $treeNode->right = reConstructBinaryTree(array_slice($pre,$rootIndex+1), array_slice($vin,$rootIndex+1));
        return $treeNode;
    }
}