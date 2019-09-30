<?php
require_once("websocket.class.php");
require_once("room.class.php");
require_once("users.class.php");
require_once("engine.class.php");

class Socket extends WebSocket {
    public $users;
    
    public function __construct($address, $port){
        parent::__construct();
        $this->users = new Users();
        $this->users->login('aaa', 213, 'test');
        $this->users->logout('aaa', array($this, 'close'), 'test');
    }
    
    function getdata($key, $msg){
        $arr = json_decode($msg, true);
        if ($arr['sys'] == 'login') {
            if ($this->users->auth($arr['name'], $arr['uid'], $arr['token'])) {
                $this->users->login($arr['name'], $arr['uid'], $key);
            }
        }
        if ($arr['sys'] == 'logout') {
            if ($this->users[$arr['name']]['key'] == $key) {
                $this->users->logout($arr['name'], array($this, 'close'), $key);
            }
        }
    }
    
    // function name($key) {
        // $name = array_search($key, $this->users);
        // return $name;
    // }
    
    function sendRoom($num, $msg){
        
    }
    
    function sendAll($msg){
        $clients = $this->clients;
        foreach ($clients as $key=>$client){
            $this->send($key, $msg);
        }
    }
    
    function close($key) {
        $this->e($key);
    }
    
    function score($uid, $s, $t) {
        $key = 'saj9w27FfJUXUArF';
        $day = date("d");
        $token = md5($day.$uid.$s.$t.$key);
        $post_data = 'uid='.urlencode($uid).'&score='.urlencode($s).'&type='.urlencode($t).'&token='.urlencode($token);
        $r = intval($this->send_post('https://www.bbsyabo.com/plugin.php?id=transaction:api', $post_data));
        return $r;
    }
    
    function send_post($url, $post_data) {
        $post_url = $url;
        $postdata = $post_data;
        $UserAgent = 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $post_url);
        curl_setopt($ch, CURLOPT_USERAGENT, $UserAgent);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        $out_put=curl_exec ($ch);
        curl_close($ch);
     
        return $out_put;
    }
}

$socket = new Socket("127.0.0.1", 5555);
$socket->run();
