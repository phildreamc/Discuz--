<?php
//下面是sock类
class WebSocket{
    public $sockets;    //socket的连接池，即client连接进来的socket标志
    public $clients;
    public $master; //socket的resource，即前期初始化socket时返回的socket资源
    
    public function __construct($address, $port){
        //创建socket并把保存socket资源在$this->master
        $this->master = $this->ws($address, $port);
        //创建socket连接池
        $this->sockets = array($this->master);
    }
    
    function run(){
        while(true){
            $changes = $this->sockets;
            $write = NULL;
            $except = NULL;
            
            /*
            //这个函数是同时接受多个连接的关键，我的理解它是为了阻塞程序继续往下执行。
            socket_select ($sockets, $write = NULL, $except = NULL, NULL);
 
            $sockets可以理解为一个数组，这个数组中存放的是文件描述符。当它有变化（就是有新消息到或者有客户端连接/断开）时，socket_select函数才会返回，继续往下执行。
            $write是监听是否有客户端写数据，传入NULL是不关心是否有写变化。
            $except是$sockets里面要被排除的元素，传入NULL是”监听”全部。
            最后一个参数是超时时间
            如果为0：则立即结束
            如果为n>1: 则最多在n秒后结束，如遇某一个连接有新动态，则提前返回
            如果为null：如遇某一个连接有新动态，则返回
            */
            socket_select($changes, $write, $except, NULL);
            foreach($changes as $sock){
                
                //如果有新的client连接进来，则
                if ($sock == $this->master){
 
                    //接受一个socket连接
                    $client = socket_accept($this->master);
 
                    //给新连接进来的socket一个唯一的ID
                    $key = uniqid();
                    $this->sockets[] = $client;  //将新连接进来的socket存进连接池
                    $this->clients[$key] = array(
                        'socket'=>$client,  //记录新连接进来client的socket信息
                        'handshake'=>false       //标志该socket资源没有完成握手
                    );
                //否则1.为client断开socket连接，2.client发送信息
                }else {
                    $len = 0;
                    $buffer = '';
                    //读取该socket的信息，注意：第二个参数是引用传参即接收数据，第三个参数是接收数据的长度
                    do {
                        $l = socket_recv($sock, $buf, 1000, 0);
                        $len += $l;
                        $buffer .= $buf;
                    }while ($l == 1000);
 
                    //根据socket在user池里面查找相应的$k,即健ID
                    $key = $this->search($sock);
 
                    // 如果接收的信息长度小于7，则该client的socket为断开连接
                    if ($len<7){
                        // 给该client的socket进行断开操作，并在$this->sockets和$this->users里面进行删除
                        $this->close($key);
                        continue;
                    }
                    
                    //判断该socket是否已经握手
                    if (!$this->clients[$key]['handshake']){
                        //如果没有握手，则进行握手处理
                        $this->handshake($key,$buffer);
                        // $this->e($key.":connected;socket:".$sock);
                    }else {
                        //走到这里就是该client发送信息了，对接受到的信息进行uncode处理
                        $this->getdata($key, $this->uncode($buffer));
                    }
                }
            }
        }
    }
    
    function search($socket){
        foreach ($this->clients as $key=>$client){
            if ($socket == $client['socket']){
                return $key;
            }
        }
        return false;
    }
    
    function getdata($key, $msg){
        $this->send($key, $msg);
    }
    
    function sendAll($msg){
        $clients = $this->clients;
        foreach ($clients as $key=>$client){
            $this->send($key, $msg);
        }
    }
    
    function send($key, $msg){
        $clients = $this->clients;
        if (isset($clients[$key])) {
            $msg = $this->frame($msg);
            socket_write($clients[$key]['socket'], $msg, strlen($msg));
        }
    }
    
    function close($key) {
        $clients = $this->clients;
        socket_close($clients[$key]['socket']);
        $k = array_search($this->clients[$key]['socket'], $this->sockets);
        unset($this->sockets[$k]);
        unset($clients[$key]);
    }
    
    //返回帧信息处理
    function frame($s){
        $a = str_split($s, 125);
        if (count($a) == 1){
            return "\x81".chr(strlen($a[0])).$a[0];
        }
        $ns = '';
        foreach ($a as $o){
            $ns .= "\x81".chr(strlen($o)).$o;
        }
        return $ns;
    }
    
    //解码函数
    function uncode($str){
        $len = $masks = $data = $decoded = null;
        $len = ord($str[1]) & 127;
        
        if ($len === 126){
            $masks = substr($str, 4, 4);
            $data = substr($str, 8);
        }else if ($len === 127){
            $masks = substr($str, 10, 4);
            $data = substr($str, 14);
        }else {
            $masks = substr($str, 2, 4);
            $data = substr($str, 6);
        }
        for ($index = 0; $index <strlen($data); $index++){
            $decoded .= $data[$index] ^ $masks[$index % 4];
        }
        return $decoded;
    }
    
    function ws($address,$port){
        $server = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_set_option($server, SOL_SOCKET, SO_REUSEADDR, 1);//1表示接受所有的数据包
        socket_bind($server, $address, $port);
        socket_listen($server);
        $this->e('Server Started : '.date('Y-m-d H:i:s'));
        $this->e('Listening on   : '.$address.' port '.$port);
        return $server;
    }
    
    function handshake($key, $buffer){
        //截取Sec-WebSocket-Key的值并加密，其中$key后面的一部分258EAFA5-E914-47DA-95CA-C5AB0DC85B11字符串应该是固定的
        $buf  = substr($buffer,strpos($buffer,'Sec-WebSocket-Key:')+18);
        $ws_key  = trim(substr($buf,0,strpos($buf,"\r\n")));
        $new_key = base64_encode(sha1($ws_key."258EAFA5-E914-47DA-95CA-C5AB0DC85B11",true));
         
        //按照协议组合信息进行返回
        $new_message = "HTTP/1.1 101 Switching Protocols\r\n";
        $new_message .= "Upgrade: websocket\r\n";
        $new_message .= "Sec-WebSocket-Version: 13\r\n";
        $new_message .= "Connection: Upgrade\r\n";
        $new_message .= "Sec-WebSocket-Accept: " . $new_key . "\r\n\r\n";
        socket_write($this->clients[$key]['socket'], $new_message, strlen($new_message));
 
        //对已经握手的client做标志
        $this->clients[$key]['handshake']=true;
        return true;
    }
    
    //记录日志
    function e($str){
        //$path=dirname(__FILE__).'/log.txt';
        $str=$str."\n";
        //error_log($str,3,$path);
        //编码处理
        echo iconv('utf-8','gbk//IGNORE',$str);
    }
}