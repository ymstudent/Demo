<?php
/**
 * Created by PhpStorm.
 * User: ym
 * Date: 2018/3/16
 * Time: 23:01
 * 使用php压缩zip文件和解压zip文件
 */
ini_set('display_errors',1);
/**
 * 压缩
 * @param array $files  文件数组
 * @param string $destination
 * @param bool $overwrite
 * @return bool
 */
function createZip($files = array(), $destination = '', $overwrite = false)
{
    //if the zip file already exists and overwrite is false, return false
    if (file_exists($destination) && !$overwrite) {
        return false;
    }
    //vars
    $valid_files = array();
    //if files were passed in...
    if (is_array($files)) {
        //cycle through each file
        foreach ($files as $item) {
            //make sure file exists
            if (file_exists($item)) {
                $valid_files[] = $item;
            }
        }
    }
    //if we have good files
    if (count($valid_files)) {
        //create the archive
        $zip = new ZipArchive();
        if ($zip->open($destination, $overwrite ? ZipArchive::OVERWRITE : ZipArchive::CREATE) != true) {
            return false;
        }
        //add the files
        foreach ($valid_files as $file) {
            $zip->addFile($file, $file);
        }
        //debug
        //echo 'the zip archive contains '.$zip->numFiles.' files with a status of '.$zip->status;

        //close the zip -- done!
        $zip->close();

        //chechk to make sure the file exists
        return file_exists($destination);
    } else {
        return false;
    }
}

//test
$path = dirname(__DIR__).'/nowcode/';
$files = array("{$path}1.php", "{$path}2.php", "{$path}3.php");
createZip($files, "myZipFile.zip", true);

function upZip($location, $newLocation)
{
    if(exec("unzip $location", $arr)){
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