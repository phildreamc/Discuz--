<?php
//������sock��
class WebSocket{
    public $sockets;    //socket�����ӳأ���client���ӽ�����socket��־
    public $clients;
    public $master; //socket��resource����ǰ�ڳ�ʼ��socketʱ���ص�socket��Դ
    
    public function __construct($address, $port){
        //����socket���ѱ���socket��Դ��$this->master
        $this->master = $this->ws($address, $port);
        //����socket���ӳ�
        $this->sockets = array($this->master);
    }
    
    function run(){
        while(true){
            $changes = $this->sockets;
            $write = NULL;
            $except = NULL;
            
            /*
            //���������ͬʱ���ܶ�����ӵĹؼ����ҵ��������Ϊ�����������������ִ�С�
            socket_select ($sockets, $write = NULL, $except = NULL, NULL);
 
            $sockets�������Ϊһ�����飬��������д�ŵ����ļ��������������б仯������������Ϣ�������пͻ�������/�Ͽ���ʱ��socket_select�����Ż᷵�أ���������ִ�С�
            $write�Ǽ����Ƿ��пͻ���д���ݣ�����NULL�ǲ������Ƿ���д�仯��
            $except��$sockets����Ҫ���ų���Ԫ�أ�����NULL�ǡ�������ȫ����
            ���һ�������ǳ�ʱʱ��
            ���Ϊ0������������
            ���Ϊn>1: �������n������������ĳһ���������¶�̬������ǰ����
            ���Ϊnull������ĳһ���������¶�̬���򷵻�
            */
            socket_select($changes, $write, $except, NULL);
            foreach($changes as $sock){
                
                //������µ�client���ӽ�������
                if ($sock == $this->master){
 
                    //����һ��socket����
                    $client = socket_accept($this->master);
 
                    //�������ӽ�����socketһ��Ψһ��ID
                    $key = uniqid();
                    $this->sockets[] = $client;  //�������ӽ�����socket������ӳ�
                    $this->clients[$key] = array(
                        'socket'=>$client,  //��¼�����ӽ���client��socket��Ϣ
                        'handshake'=>false       //��־��socket��Դû���������
                    );
                //����1.Ϊclient�Ͽ�socket���ӣ�2.client������Ϣ
                }else {
                    $len = 0;
                    $buffer = '';
                    //��ȡ��socket����Ϣ��ע�⣺�ڶ������������ô��μ��������ݣ������������ǽ������ݵĳ���
                    do {
                        $l = socket_recv($sock, $buf, 1000, 0);
                        $len += $l;
                        $buffer .= $buf;
                    }while ($l == 1000);
 
                    //����socket��user�����������Ӧ��$k,����ID
                    $key = $this->search($sock);
 
                    // ������յ���Ϣ����С��7�����client��socketΪ�Ͽ�����
                    if ($len<7){
                        // ����client��socket���жϿ�����������$this->sockets��$this->users�������ɾ��
                        $this->close($key);
                        continue;
                    }
                    
                    //�жϸ�socket�Ƿ��Ѿ�����
                    if (!$this->clients[$key]['handshake']){
                        //���û�����֣���������ִ���
                        $this->handshake($key,$buffer);
                        // $this->e($key.":connected;socket:".$sock);
                    }else {
                        //�ߵ�������Ǹ�client������Ϣ�ˣ��Խ��ܵ�����Ϣ����uncode����
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
    
    //����֡��Ϣ����
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
    
    //���뺯��
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
        socket_set_option($server, SOL_SOCKET, SO_REUSEADDR, 1);//1��ʾ�������е����ݰ�
        socket_bind($server, $address, $port);
        socket_listen($server);
        $this->e('Server Started : '.date('Y-m-d H:i:s'));
        $this->e('Listening on   : '.$address.' port '.$port);
        return $server;
    }
    
    function handshake($key, $buffer){
        //��ȡSec-WebSocket-Key��ֵ�����ܣ�����$key�����һ����258EAFA5-E914-47DA-95CA-C5AB0DC85B11�ַ���Ӧ���ǹ̶���
        $buf  = substr($buffer,strpos($buffer,'Sec-WebSocket-Key:')+18);
        $ws_key  = trim(substr($buf,0,strpos($buf,"\r\n")));
        $new_key = base64_encode(sha1($ws_key."258EAFA5-E914-47DA-95CA-C5AB0DC85B11",true));
         
        //����Э�������Ϣ���з���
        $new_message = "HTTP/1.1 101 Switching Protocols\r\n";
        $new_message .= "Upgrade: websocket\r\n";
        $new_message .= "Sec-WebSocket-Version: 13\r\n";
        $new_message .= "Connection: Upgrade\r\n";
        $new_message .= "Sec-WebSocket-Accept: " . $new_key . "\r\n\r\n";
        socket_write($this->clients[$key]['socket'], $new_message, strlen($new_message));
 
        //���Ѿ����ֵ�client����־
        $this->clients[$key]['handshake']=true;
        return true;
    }
    
    //��¼��־
    function e($str){
        //$path=dirname(__FILE__).'/log.txt';
        $str=$str."\n";
        //error_log($str,3,$path);
        //���봦��
        echo iconv('utf-8','gbk//IGNORE',$str);
    }
}