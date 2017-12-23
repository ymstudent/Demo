<?php
/**
 * 组合模式：一个接口对于多个实现，并且这些实现中都拥有相同的方法（名）。
 * 有时候你需要只运行一个方法，就让不同实现类的某个方法或某个逻辑全部执行一遍。
 * 在批量处理多个实现类时，感觉就像在使用一个类一样。
 */

/**
 * 下面通过仿造CI中的表单构造器来实现组合模式
 */
namespace Ym\Demo\Pattern;

/**
 * 基类：因为组合模式中的继承层级结构是树型结构，所有类都是由这个类发散出去的
 * 这个类就好像树木的根基，所以叫基类。
 * Interface RenderInderface
 * @package Ym\Demo\Pattern
 */
interface RenderInderface
{
    public function render();
}

/**
 * 叶子类：也被成为树叶对象、局部对象，因为在组合模式中，组合对象为树干，单独存在的对象为树叶，
 * 树叶对象是组合模式中的最小单位。它其中不能包含其它的对象。
 * Class TextElement
 * @package Ym\Demo\Pattern
 */
class TextElement implements RenderInderface
{
    private $text;

    public function __construct($text)
    {
        $this->text = $text;
    }

    public function render()
    {
        return $this->text;
    }
}

/**
 * 叶子类
 * Class InputElement
 * @package Ym\Demo\Pattern
 */
class InputElement implements RenderInderface
{
    private $input;

    public function __construct($type)
    {
        $this->input = "<input type='{$type}' />";
    }

    public function render()
    {
        return $this->input;
    }
}

/**
 * 组合类：包含了叶子对象的对象类，通过add方法添加叶子对象，通过remove方法删除对象（本例中没写，一般都会有）
 * Class Form
 * @package Ym\Demo\Pattern
 */
class Form implements RenderInderface
{
    private $elements = array();

    public function addElement(RenderInderface $element)
    {
        if(in_array($element,$this->elements,true)){
            return;
        }
        $this->elements[] = $element;
    }

    public function render()
    {
        $form = "<form>";
        foreach ($this->elements as $item) {
            $form .= $item->render()."<br/>";
        }
        $form .= "</form>";
        return $form;
    }
}

//实现
$form = new Form();
$form->addElement(new TextElement("帐号"));
$form->addElement(new InputElement("text"));
$form->addElement(new TextElement("密码"));
$form->addElement(new InputElement("text"));
$rel = $form->render();
print_r($rel);  //<form>帐号<br/><input type='text' /><br/>密码<br/><input type='text' /><br/></form>

/**
 * 组合模式的优点：
 * 1、灵活：组合模式中的一切类都共享一个父类，所以可以轻松的在设计中添加新的组合对象或者局部对象，而无需大范围
 * 的修改代码
 * 2、简单：使用组合模式时，客户端代码只需要设计简单的接口，因为它没有必要区分一个对象是组合对象还是局部对象，
 * 当它调用Form中的render方法时，或许会产生一些幕后的委托调用，但是对客户端来说，无论是过程还是效果都和它直接
 * 调用TextElement中的render是一样的
 * 3、隐式到达：组合模式中的对象通过树形结构组织，每个组合对象中都保存着对子对象的引用，因此对树中某一小部分
 * 的操作可能会影响整个树。
 * 4、显示到达：树形结构可轻松遍历，可以通过迭代树形结构来获取组合对象和局部对象的信息，或者对组合对象或局部对象
 * 进行批量处理
 * ----以上一段引用自深入php面对对象、模式一书。
 */

