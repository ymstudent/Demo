<?php
/**
 * Created by PhpStorm.
 * User: ym
 * Date: 2018/3/14
 * Time: 21:43
 * PHP在浏览器中输出笛卡尔心型图案
 * imagecolorallocate():  为一幅图像分配颜色
 * imagesetpixel(): 在 image 图像中用 color 颜色在 x，y 坐标（图像左上角为 0，0）上画一个点。
 * M_PI:PHP Math常量，表示pi（3.141592653.....）
 */
$width = 600;
$height = 650;
header("Content-type: image/gif");
$img = imagecreate($width, $height);//创建一张图片
$bg_color = imagecolorallocate($img, 0, 0, 0);
$red = imagecolorallocate($img, 255, 0, 0);
for ($i = 0; $i <= 100; $i++) {
    for ($j = 0; $j <= 100; $j++) {
        //转换为直角坐标系，设置偏移量，使图像居中
        $r = M_PI / 50 * $i * (1 - sin(M_PI / 50 * $j)) * 40;
        $x = $r * cos(M_PI / 50 * $j) * sin(M_PI / 50 * $i)+$width / 2;
        $y = -$r * sin(M_PI / 50 * $j) + $height / 6;
        imagesetpixel($img, $x, $y, $red);
    }
}
imagegif($img);