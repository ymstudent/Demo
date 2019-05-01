<?php
namespace Bluerhinos;
/*
 	phpMQTT
	A simple php class to connect/publish/subscribe to an MQTT broker
*/
/*
	Licence
	Copyright (c) 2010 Blue Rhinos Consulting | Andrew Milsted
	andrew@bluerhinos.co.uk | http://www.bluerhinos.co.uk
	Permission is hereby granted, free of charge, to any person obtaining a copy
	of this software and associated documentation files (the "Software"), to deal
	in the Software without restriction, including without limitation the rights
	to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
	copies of the Software, and to permit persons to whom the Software is
	furnished to do so, subject to the following conditions:
	The above copyright notice and this permission notice shall be included in
	all copies or substantial portions of the Software.
	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
	THE SOFTWARE.
*/
/* phpMQTT */
class phpMQTT {
    private $socket; 			/* holds the socket	*/
    private $msgid = 1;			/* counter for message id */
    public $keepalive = 60;		/* default keepalive timmer */
    public $timesinceping;		/* host unix time, used to detect disconects */
    public $topics = array(); 	/* used to store currently subscribed topics */
    public $debug = false;		/* should output debug messages */
    public $address;			/* broker address */
    public $port;				/* broker port */
    public $clientid;			/* client id sent to brocker */
    public $will;				/* stores the will of the client:遗嘱，一个由客户端预先定义好的主题和对应消息， 在客户端连接出现异常的情况下，由服务器主动发布此消息。 */
    private $username;			/* stores username */
    private $password;			/* stores password */
    public $cafile;

    /**
     * 初始化
     * phpMQTT constructor.
     * @param $address
     * @param $port
     * @param $clientid
     * @param null $cafile
     */
    function __construct($address, $port, $clientid, $cafile = NULL)
    {
        $this->broker($address, $port, $clientid, $cafile);
    }

    /**
     * 设置代理
     * @param $address
     * @param $port
     * @param $clientid
     * @param null $cafile
     */
    function broker($address, $port, $clientid, $cafile = NULL)
    {
        $this->address = $address;
        $this->port = $port;
        $this->clientid = $clientid;
        $this->cafile = $cafile;
    }

    /**
     * 自动连接
     * @param bool $clean
     * @param null $will
     * @param null $username
     * @param null $password
     * @return bool
     */
    function connect_auto($clean = true, $will = NULL, $username = NULL, $password = NULL)
    {
        if ($this->connect($clean, $will, $username, $password)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 连接代理
     * @param bool $clean cleanSession标志， true or false
     * @param null $will
     * @param null $username
     * @param null $password
     * @return bool
     */
    function connect($clean = true, $will = NULL, $username = NULL, $password = NULL)
    {
        try {
            if($will) $this->will = $will;
            if($username) $this->username = $username;
            if($password) $this->password = $password;
            if ($this->cafile) {
                $socketContext = stream_context_create(["ssl" => [
                    "verify_peer_name" => true,
                    "cafile" => $this->cafile
                ]]);
                $this->socket = @stream_socket_client("tls://" . $this->address . ":" . $this->port, $errno, $errstr, 60, STREAM_CLIENT_CONNECT, $socketContext);
            } else {
                $this->socket = @stream_socket_client("tcp://" . $this->address . ":" . $this->port, $errno, $errstr, 60, STREAM_CLIENT_CONNECT);
            }
            if (!$this->socket ) {
                if($this->debug) error_log("stream_socket_create() $errno, $errstr \n");
                return false;
            }
            stream_set_timeout($this->socket, 10); //socket超时时间10s
            stream_set_blocking($this->socket, 0); //设置为非阻塞模式
            $i = 0;
            $buffer = "";
            $buffer .= chr(0x00); $i++;
            $buffer .= chr(0x06); $i++;
            $buffer .= chr(0x4d); $i++;
            $buffer .= chr(0x51); $i++;
            $buffer .= chr(0x49); $i++;
            $buffer .= chr(0x73); $i++;
            $buffer .= chr(0x64); $i++;
            $buffer .= chr(0x70); $i++;
            $buffer .= chr(0x03); $i++;
            //No Will
            $var = 0;
            if($clean) $var+=2;
            //Add will info to header
            if($this->will != NULL){
                $var += 4; // Set will flag
                $var += ($this->will['qos'] << 3); //Set will qos
                if($this->will['retain'])	$var += 32; //Set will retain
            }
            if($this->username != NULL) $var += 128;	//Add username to header
            if($this->password != NULL) $var += 64;	//Add password to header
            $buffer .= chr($var); $i++;
            //Keep alive
            $buffer .= chr($this->keepalive >> 8); $i++;
            $buffer .= chr($this->keepalive & 0xff); $i++;
            $buffer .= $this->strwritestring($this->clientid,$i);
            //Adding will to payload
            if($this->will != NULL){
                $buffer .= $this->strwritestring($this->will['topic'],$i);
                $buffer .= $this->strwritestring($this->will['content'],$i);
            }
            if($this->username) $buffer .= $this->strwritestring($this->username,$i);
            if($this->password) $buffer .= $this->strwritestring($this->password,$i);
            $head = "  ";
            $head{0} = chr(0x10);
            $head{1} = chr($i);
            @fwrite($this->socket, $head, 2);
            @fwrite($this->socket,  $buffer);
            $string = $this->read(4);
            if(ord($string{0})>>4 == 2 && $string{3} == chr(0)){
                if($this->debug) echo "Connected to Broker\n";
            }else{
                error_log(sprintf("Connection failed! (Error: 0x%02x 0x%02x)\n",
                    ord($string{0}),ord($string{3})));
                return false;
            }
            $this->timesinceping = time();
            return true;
        }catch (\Exception $e) {
            if ($this->debug) echo $e->getMessage();
            return false;
        }catch (\Error $error) {
            if ($this->debug) echo $error->getMessage();
            return false;
        }
    }

    /* read: reads in so many bytes */
    function read($int = 8192, $nb = false)
    {
        //	print_r(socket_get_status($this->socket));
        $string = "";
        $togo = $int;

        if ($nb) {
            return fread($this->socket, $togo);
        }

        while (!feof($this->socket) && $togo > 0) {
            $fread = fread($this->socket, $togo);
            $string .= $fread;
            $togo = $int - strlen($string);
        }

        return $string;
    }

    /**
     * 订阅主题
     * @param $topics
     * @param int $qos
     * @return bool|string
     */
    function subscribe($topics, $qos = 0)
    {
        $i = 0;
        $buffer = "";
        $id = $this->msgid;
        $buffer .= chr($id >> 8);  $i++;
        $buffer .= chr($id % 256);  $i++;
        foreach($topics as $key => $topic){
            $buffer .= $this->strwritestring($key,$i);
            $buffer .= chr($topic["qos"]);  $i++;
            $this->topics[$key] = $topic;
        }
        $cmd = 0x80;
        //$qos
        $cmd +=	($qos << 1);
        $head = chr($cmd);
        $head .= chr($i);

        @fwrite($this->socket, $head, 2);
        @fwrite($this->socket, $buffer, $i);
        $string = $this->read(2);

        $bytes = ord(substr($string,1,1));
        $string = $this->read($bytes);

        return $string;
    }

    /**
     * ping:长连接心跳，防止长时间未通讯导致连接失效
     */
    function ping()
    {
        $head = chr(0xc0);
        $head .= chr(0x00);
         if (@fwrite($this->socket, $head, 2)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 断开连接
     */
    function disconnect()
    {
        $head = " ";
        $head{0} = chr(0xe0);
        $head{1} = chr(0x00);
        @fwrite($this->socket, $head, 2);
    }

    /**
     * 关闭socket通讯
     */
    function close(){
        $this->disconnect();
        stream_socket_shutdown($this->socket, STREAM_SHUT_WR);
    }

    /**
     * 发布消息
     * @param $topic
     * @param $content
     * @param int $qos
     * @param int $retain
     * @return array
     */
    function publish($topic, $content, $qos = 0, $retain = 0){
        $return = ['code' => 2, 'msg' => 'publish failed'];
        try {
            $i = 0;
            $buffer = "";
            $buffer .= $this->strwritestring($topic,$i);
            if($qos){
                $id = $this->msgid++;
                $buffer .= chr($id >> 8);  $i++;
                $buffer .= chr($id % 256);  $i++;
            }
            $buffer .= $content;
            $i+=strlen($content);
            $head = " ";
            $cmd = 0x30;
            if($qos) $cmd += $qos << 1;
            if($retain) $cmd += 1;
            $head{0} = chr($cmd);
            $head .= $this->setmsglength($i);
            if((@fwrite($this->socket, $head, strlen($head)))&&(@fwrite($this->socket, $buffer, $i))){
                //echo "done: ".$this->socket."<br>";
                $return['code'] = 1;
            }else{
                $error = error_get_last();
                $return['msg'] = $error['message'];
            }
        }catch (\Throwable $e) { //捕获错误与异常
            $return['msg'] =  $e->getMessage();
        }
        return $return;
    }

    /**
     * 处理消息
     * @param $msg
     */
    function message($msg){
        $tlen = (ord($msg{0})<<8) + ord($msg{1});
        $topic = substr($msg,2,$tlen);
        $msg = substr($msg,($tlen+2));
        $found = 0;
        foreach($this->topics as $key=>$top){
            if( preg_match("/^".str_replace("#",".*",
                    str_replace("+","[^\/]*",
                        str_replace("/","\/",
                            str_replace("$",'\$',
                                $key))))."$/",$topic) ){
                if(is_callable($top['function'])){
                    call_user_func($top['function'],$topic,$msg);
                    $found = 1;
                }
            }
        }
        if($this->debug && !$found) echo "msg recieved but no match in subscriptions\n";
    }

    /**
     * proc: the processing loop for an "allways on" client set true when you are doing other stuff
     * in the loop good for watching something else at the same time
     * 长连接设备的循环处理设置为true，当你在循环中处理其他东西的同时也能方便的查看其余的事情
     * @param bool $loop
     * @return int
     */
    function proc( $loop = true)
    {
        if(1){
            $sockets = array($this->socket);
            $w = $e = NULL;
            $cmd = 0;

            //$byte = fgetc($this->socket);
            if(feof($this->socket)){
                if($this->debug) echo "eof receive going to reconnect for good measure\n";
                fclose($this->socket);
                $this->connect_auto(false);
                if (count($this->topics)) {
                    $this->subscribe($this->topics);
                }
            }

            $byte = $this->read(1, true);

            if(!strlen($byte)){
                if($loop){
                    usleep(100000);
                }
            }else{
                $cmd = (int)(ord($byte)/16);
                if($this->debug) echo "Recevid: $cmd\n";
                $multiplier = 1;
                $value = 0;
                do{
                    $digit = ord($this->read(1));
                    $value += ($digit & 127) * $multiplier;
                    $multiplier *= 128;
                }while (($digit & 128) != 0);
                if($this->debug) echo "Fetching: $value\n";

                if ($value) {
                    $string = $this->read($value);
                }

                if($cmd) {
                    switch($cmd) {
                        case 3:
                            $this->message($string);
                            break;
                    }
                    $this->timesinceping = time();
                }
            }
            if ($this->timesinceping < (time() - $this->keepalive )) {
                if($this->debug) echo "not found something so ping\n";
                $this->ping();
            }

            //如果超过2倍保持时间就重新连接
            if ($this->timesinceping<(time()-($this->keepalive*2))) {
                if($this->debug) echo "not seen a package in a while, disconnecting\n";
                fclose($this->socket);
                $this->connect_auto(false);
                if (count($this->topics)) {
                    $this->subscribe($this->topics);
                }
            }
        }
        return 1;
    }

    /**
     * 获取消息长度
     * @param $msg
     * @param $i
     * @return float|int
     */
    function getmsglength(&$msg, &$i)
    {
        $multiplier = 1;
        $value = 0 ;
        do{
            $digit = ord($msg{$i});
            $value += ($digit & 127) * $multiplier;
            $multiplier *= 128;
            $i++;
        }while (($digit & 128) != 0);
        return $value;
    }

    /**
     * 设置消息长度
     * @param $len
     * @return string
     */
    function setmsglength($len)
    {
        $string = "";
        do{
            $digit = $len % 128;
            $len = $len >> 7;
            // if there are more digits to encode, set the top bit of this digit
            if ( $len > 0 )
                $digit = ($digit | 0x80);
            $string .= chr($digit);
        }while ( $len > 0 );
        return $string;
    }

    /**
     * writes a string to a buffer
     * 将字符串写入缓冲区
     * @param $str
     * @param $i
     * @return string
     */
    function strwritestring($str, &$i)
    {
        $ret = " ";
        $len = strlen($str);
        $msb = $len >> 8;
        $lsb = $len % 256;
        $ret = chr($msb);
        $ret .= chr($lsb);
        $ret .= $str;
        $i += ($len+2);
        return $ret;
    }

    /**
     * 输出字符串
     * @param $string
     */
    function printstr($string)
    {
        $strlen = strlen($string);
        for($j=0;$j<$strlen;$j++){
            $num = ord($string{$j});
            if($num > 31)
                $chr = $string{$j}; else $chr = " ";
            printf("%4d: %08b : 0x%02x : %s \n",$j,$num,$num,$chr);
        }
    }
}