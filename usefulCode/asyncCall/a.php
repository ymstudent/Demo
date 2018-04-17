<?php
/**
 * php利用fscokopen()函数执行异步调用
 * 参考鸟哥的：使用fscok实现异步调用PHP。http://www.laruence.com/2008/04/16/98.html
 */

class asyncRequest
{
    /**
     * post 方式传参
     * @param string $url 请求url
     * @param array $data 参数
     * @return bool
     */
    public function postSend($url, $data=[])
    {
        $method = "POST";    //通过POST传递一些参数给要触发的脚本
        $url_array = parse_url($url);   //获取url信息，以便拼凑http header
        $port = isset($url_array['port']) ? $url_array['port'] : 80;
        $query = isset($data) ? http_build_query($data) : '';
        $errno = 0;
        $errstr = '';
        $fp = fsockopen($url_array['host'], $port, $errno, $errstr, 30);
        if(!$fp) {
            file_put_contents('1.txt',"errno={$errno}---errstr={$errstr}");
            return false;
        }

        //构建header
        $getPath = $url_array['path'];
        $header = $method.' '.$getPath." HTTP/1.1\r\n";
        $header .= 'Host:'.$url_array['host']."\r\n";
        $header .= 'Content-length:'.strlen($query)."\r\n";     //POST长度
        $header .= "Content-type:application/x-www-form-urlencoded\r\n";    //POST数据
        $header .= "Connection:Close\r\n\r\n";
        $header .= $query;
        fwrite($fp, $header);
        //var_dump(fread($fp, 1024)); //不关心服务器返回
        fclose($fp);
        return true;
    }

    /**
     * GET 方式传参
     * @param string $url 请求url
     * @param array $data 参数
     * @return bool
     */
    public function getSend($url, $data=[])
    {
        $method = "GET";    //通过POST传递一些参数给要触发的脚本
        $url_array = parse_url($url);   //获取url信息，以便拼凑http header
        $port = isset($url_array['port']) ? $url_array['port'] : 80;
        $query = isset($data) ? http_build_query($data) : '';
        $errno = 0;
        $errstr = '';
        $fp = fsockopen($url_array['host'], $port, $errno, $errstr, 30);
        if(!$fp) {
            file_put_contents('1.txt',"errno={$errno}---errstr={$errstr}");
            return false;
        }

        //构建header
        $getPath = $url_array['path'].'?'.$query;
        $header = $method.' '.$getPath." HTTP/1.1\r\n";
        $header .= 'Host:'.$url_array['host']."\r\n";
        $header .= "Connection:Close\r\n\r\n";
        fwrite($fp, $header);
        //var_dump(fread($fp, 1024)); //不关心服务器返回
        fclose($fp);
        return true;
    }
}

//test
$client = new asyncRequest();
//$client->postSend('http://www.demo.com/usefulCode/asyncCall/b.php',['param'=> 'hello world, post']);
$client->getSend('http://www.demo.com/usefulCode/asyncCall/b.php',['param'=> 'hello world, get']);
