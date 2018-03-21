<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        html {
            overflow-x : hidden ;
            height : 100% ;
            margin : 0 ;
            padding : 0 ;
        }
        .bg-bubbles {
            position: absolute;
            /*使气泡背景充满整个屏幕；*/
            top: 0;
            left: 0;
            margin: 0;
            width: 100%;
            height: 100%;
            /*如果元素内容超出给定的宽度和高度，overflow 属性可以确定是否显示滚动条等行为；*/
            overflow: hidden;
            background: linear-gradient(to bottom right, #50A3A2, #53E3A6);
        }
        li {
            position: absolute;
            /*bottom 的设置是为了营造出气泡从页面底部冒出的效果；*/
            bottom: -160px;
            /*默认的气泡大小； */
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.15);
            list-style: none;
            /*使用自定义动画使气泡渐现、上升和翻滚*/
            animation: square 15s infinite;
            transition-timing-function: linear;
            /*加上border-radius后气泡变为圆形*/
            border-radius: 50%;
        }
        /*分别设置每个气泡不同的位置、大小、透明度和速度，以显得有层次感；*/
        #li1 {
            left: 10%;
        }
        #li2 {
            left: 20%;
            width: 90px;
            height: 90px;
            animation-delay: 2s;
            animation-duration: 7s;
        }
        #li3 {
            left: 25%;
            animation-delay: 4s;
        }
        #li4 {
            left: 40%;
            width: 60px;
            height: 60px;
            animation-duration: 8s;
            background-color: rgba(255, 255, 255, 0.3);
        }
        #li5 {
            left: 70%;
        }
        #li6 {
            left: 80%;
            width: 120px;
            height: 120px;
            animation-delay: 3s;
            background-color: rgba(255, 255, 255, 0.2);
        }
        #li7 {
            left: 32%;
            width: 160px;
            height: 160px;
            animation-delay: 2s;
        }
        #li8 {
            left: 55%;
            width: 20px;
            height: 20px;
            animation-delay: 4s;
            animation-duration: 15s;
        }
        #li9 {
            left: 25%;
            width: 10px;
            height: 10px;
            animation-delay: 2s;
            animation-duration: 12s;
            background-color: rgba(255, 255, 255, 0.3);
        }
        #li10 {
            left: 85%;
            width: 160px;
            height: 160px;
            animation-delay: 5s;
        }
        /*自定义 square 动画；*/
        @keyframes square {
            0% {
                opacity: 0.5;
                transform: translateY(0px) rotate(45deg);
            }
            25% {
                opacity: 0.75;
                transform: translateY(-400px) rotate(90deg)
            }
            50% {
                opacity: 1;
                transform: translateY(-600px) rotate(135deg);
            }
            100% {
                opacity: 0;
                transform: translateY(-1000px) rotate(180deg);
            }
        }
    </style>
</head>
<body>
<ul class="bg-bubbles">
    <?php
    for($i=1;$i<11;$i++){
        echo "<li id='li".$i."'></li>";
    }
    ?>
</ul>
</body>
</html>