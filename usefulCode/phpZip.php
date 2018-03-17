<?php
/**
 * Created by PhpStorm.
 * User: ym
 * Date: 2018/3/16
 * Time: 23:01
 * 使用php压缩zip文件和解压zip文件
 * 需要使用PHP-ZIP库支持
 */
ini_set('display_errors',1);
/**
 * 压缩
 * @param array $files  文件数组
 * @param string $destination   目标zip文件
 * @param bool $overwrite 是否覆盖
 * @return bool
 */
function createZip($files = array(), $destination = '', $overwrite = false)
{
    //如果目标文件存在，且复写变量为false，直接返回false
    if (file_exists($destination) && !$overwrite) {
        return false;
    }
    $valid_files = array();
    if (is_array($files)) {
        //循环每个文件
        foreach ($files as $item) {
            //确定文件存在
            if (file_exists($item)) {
                $valid_files[] = $item;
            }
        }
    }
    if (count($valid_files)) {
        //创建 archive
        $zip = new ZipArchive();
        if ($zip->open($destination, $overwrite ? ZipArchive::OVERWRITE : ZipArchive::CREATE) != true) {
            return false;
        }
        //添加文件
        foreach ($valid_files as $file) {
            $zip->addFile($file, $file);
        }
        //关闭archive
        $zip->close();

        //检查文件是否存在
        return file_exists($destination);
    } else {
        return false;
    }
}

//test
//$path = dirname(__DIR__).'/nowcode/';
//$files = array("{$path}1.php", "{$path}2.php", "{$path}3.php");
//$rel = createZip($files, "myZipFile.zip", true);

function upZip($location, $newLocation)
{
    //exec(): 执行一个外部程序，解压zip文件
    if(exec("unzip $location", $arr)){
        //创建新目录
        mkdir($newLocation);
        for($i = 1; $i<count($arr);$i++){
            $file = trim(preg_replace("~inflating: ~", "", $arr[$i]));
            copy($location.'/'.$file, $newLocation.'/'.$file);
            unlink($location.'/'.$file);
        }
        return true;
    }else{
        return false;
    }
}
//test
$rel = upZip('myZipFile.zip', 'myzip/test');
var_dump($rel);