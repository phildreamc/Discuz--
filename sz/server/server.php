<?php
require_once("websocket.class.php");
require_once("room.class.php");
require_once("users.class.php");

class Socket extends WebSocket {
    public $info;
    public $config;
    public $rooms;
    
    public function __construct($address, $port){
        parent::__construct($address, $port);
        $this->config = array(
            'roomCounter' => 12
        );
        $this->info = new Users();
        $this->rooms = array();
        for ($i = 0; $i < $this->config['roomCounter']; $i++) {
            $this->rooms[$i] = new Room();
        }
    }
    
    function getdata($key, $msg){
        $arr = json_decode($msg, true);
        if ($arr['sys'] == 'login' && isset($arr['name']) && isset($arr['uid']) && isset($arr['token'])) {
            
            if ($this->info->auth($arr['name'], $arr['uid'], $arr['token'])) {
                if(isset($this->info->users[$arr['name']])) {
                    $this->close($this->info->users[$arr['name']]['key']);
                }
                if ($this->inroom($arr['name'])) {
                    $this->info->users[$arr['name']]['key'] = $key;
                    $roomNum = $this->info->users[$arr['name']]['roomNum'];
                    if ($this->countRoom($roomNum) >= 2) {
                        $sz = array_chunk($this->rooms[$roomNum]->game, 5);
                        foreach ($this->rooms[$roomNum]->users as $k => $name) {
                            if ($arr['name'] == $name) {
                                $msg = implode(' ', $sz[$k]);
                            }
                        }
                        $n = $arr['name'] == $this->rooms[$roomNum]->now ? 'call' : 'wait';
                        $last = implode(' ', $this->rooms[$roomNum]->last);
                        $lt = $this->rooms[$roomNum]->gettime();
                        $this->sendJson($key, 'reconn', json_encode(array('msg' => $msg, 'call' => $n, 'last' => $last, 'time' => $lt)));
                        return;
                    }else {
                        $this->rooms[$roomNum]->_quit($arr['name']);
                        unset($this->info->users[$arr['name']]['roomNum']);
                        $this->sendRU();
                    }
                }
                $this->info->login($arr['name'], $arr['uid'], $key);
                $this->sendJson($key, 'login', 'success');
                $roomm = array();
                foreach ($this->rooms as $num => $room) {
                    array_push($roomm, $room->users);
                }
                $this->send($key, json_encode(array('sys' => 'all', 'msg' => $roomm)));
            }else {
                $this->close($key);
            }
            return;
        }
        
        if ($arr['sys'] == 'close') {
            if ($this->getName($key)) {
                
            }
            $this->close($key);
        }
        
        if (!$this->getName($key)) { return;}
        
        if ($arr['sys'] == 'call') {
            $name = $this->getName($key);
            if (isset($this->info->users[$name]['roomNum'])) {
                $roomNum = $this->info->users[$name]['roomNum'];
            }else {
                return;
            }
            if (!$this->countRoom($roomNum)) {
                return;
            }
            $now = $this->rooms[$roomNum]->now;
            $wait = $this->rooms[$roomNum]->wait;
            $cards = explode(" ", $arr['msg']);
            foreach ($cards as $c => $v) {
                $cards[$c] = intval($v);
            }
            if ($cards[1] == 1) {
                $cards[2] == 1;
            }
            if ($name == $now) {
                if ($this->rooms[$roomNum]->roomCall($cards)) {
                    $this->sendJson($this->info->users[$wait]['key'], 'call', $arr['msg']);
                }else {
                    $lt = $this->rooms[$roomNum]->gettime();
                    $this->sendJson($key, 'cant', $lt);
                }
            }
            return;
        }
        
        if ($arr['sys'] == 'show') {
            $name = $this->getName($key);
            $roomNum = $this->info->users[$name]['roomNum'];
            $now = $this->rooms[$roomNum]->now;
            $wait = $this->rooms[$roomNum]->wait;
            if ($name == $now && !empty($this->rooms[$roomNum]->last)) {
                $this->gameover($roomNum);
            }else {
                $this->sendJson($key, 'cant', 'show');
            }
            return;
        }
        
        if ($arr['sys'] == 'join') {
            $name = $this->getName($key);
            if ($this->inroom($name)) { return;}
            if ($this->score($this->info->users[$name]['uid'], 0, 'get') < 10) {
                $this->sendJson($key, 'score', 'no');
                return;
            }
            $roomNum = intval($arr['msg']);
            if (!$this->inroom($name) && $this->countRoom($roomNum) < 2) {
                $this->joinRoom($name, $roomNum);
            }else {
                return;
            }
            if ($this->countRoom($roomNum) == 2) {
                $this->rooms[$roomNum]->start();
                $nk = $this->info->users[$this->rooms[$roomNum]->now]['key'];
                $wk = $this->info->users[$this->rooms[$roomNum]->wait]['key'];
                $user1 = $this->rooms[$roomNum]->users[0];
                $user2 = $this->rooms[$roomNum]->users[1];
                $key1 = $this->info->users[$user1]['key'];
                $key2 = $this->info->users[$user2]['key'];
                $sz = array_chunk($this->rooms[$roomNum]->game, 5);
                
                $this->score($this->info->users[$user1]['uid'], -10, 'add');
                $this->score($this->info->users[$user2]['uid'], -10, 'add');
                
                $this->sendJson($nk, 'start', 'call');
                $this->sendJson($wk, 'start', 'wait');
                $this->sendJson($key1, 'sz', implode(' ', $sz[0]));
                $this->sendJson($key2, 'sz', implode(' ', $sz[1]));
            }else {
                $this->sendJson($key, 'wait', 'test');
            }
            $this->sendRU();
            return;
        }
        
        if ($arr['sys'] == 'timeover') {
            $name = $this->getName($key);
            if (isset($this->info->users[$name]['roomNum'])) {
                $roomNum = $this->info->users[$name]['roomNum'];
            }else {
                return;
            }
            
            if ($this->countRoom($roomNum) < 2) {
                return;
            }
            if ($this->rooms[$roomNum]->istimeout(35)) {
                if (!empty($this->rooms[$roomNum]->last)) {
                    $this->gameover($roomNum);
                }else {
                    $now = $this->rooms[$roomNum]->now;
                    $wait = $this->rooms[$roomNum]->wait;
                    $cards = array(1, 1, 1);
                    if ($this->rooms[$roomNum]->roomCall($cards)) {
                        $this->sendJson($this->info->users[$wait]['key'], 'call', implode(' ', $cards));
                    }
                    $this->sendJson($this->info->users[$now]['key'], 'timeover', '');
                }
            }
            return;
        }
        
        if ($arr['sys'] == 'logout') {
            $this->info->logout($this->getName($key));
            $this->close($key);
            return;
        }
    }
    
    function sendRU() {
        $roomm = array();
        foreach ($this->rooms as $num => $room) {
            array_push($roomm, $room->users);
        }
        $this->sendAll(json_encode(array('sys' => 'all', 'msg' => $roomm)));
    }
    
    function gameover($roomNum) {
        $now = $this->rooms[$roomNum]->now;
        $wait = $this->rooms[$roomNum]->wait;
        $nk = $this->info->users[$this->rooms[$roomNum]->now]['key'];
        $wk = $this->info->users[$this->rooms[$roomNum]->wait]['key'];
        $user1 = $this->rooms[$roomNum]->users[0];
        $user2 = $this->rooms[$roomNum]->users[1];
        $key1 = $this->info->users[$user1]['key'];
        $key2 = $this->info->users[$user2]['key'];
        $sz = array_chunk($this->rooms[$roomNum]->game, 5);
        
        $this->sendJson($key1, 'result', implode(' ', $sz[1]));
        $this->sendJson($key2, 'result', implode(' ', $sz[0]));
        
        if ($this->rooms[$roomNum]->isin()) {
            $this->score($this->info->users[$wait]['uid'], 20, 'add');
            $this->sendJson($nk, 'winner', 'lose');
            $this->sendJson($wk, 'winner', 'win');
        }else {
            $this->score($this->info->users[$now]['uid'], 20, 'add');
            $this->sendJson($nk, 'winner', 'win');
            $this->sendJson($wk, 'winner', 'lose');
        }
        
        // $this->sendRoom($roomNum, 'result', implode(' ', $this->rooms[$roomNum]->game));
        $this->reRoom($roomNum);
        $this->sendRU();
    }
    
    function inroom ($name) {
        if (isset($this->info->users[$name]['roomNum'])) {
            return TRUE;
        }
        return FALSE;
    }
    
    function countRoom ($roomNum) {
        return $this->rooms[$roomNum]->users_number();
    }
    
    function joinRoom ($name, $roomNum) {
        $this->rooms[$roomNum]->_join($name);
        $this->info->users[$name]['roomNum'] = $roomNum;
    }
    
    function reRoom($roomNum) {
        foreach ($this->rooms[$roomNum]->users as $user) {
            $this->info->users[$user]['roomNum'] = NULL;
        }
        $this->rooms[$roomNum] = new Room();
    }
    
    function getName($key) {
        foreach ($this->info->users as $name => $info) {
            if ($info['key'] == $key) {
                return $name;
            }
        }
        return FALSE;
    }
    
    function sendJson($key, $sys, $msg) {
        $m = json_encode(array('sys' => $sys, 'msg' => $msg));
        $this->send($key, $m);
    }
    
    function sendRoom($roomNum, $sys, $msg) {
        foreach ($this->rooms[$roomNum]->users as $name) {
            $this->sendJson($this->info->users[$name]['key'], $sys, $msg);
        }
    }
    
    function sendAll($msg) {
        $clients = $this->clients;
        foreach ($clients as $key=>$client) {
            $this->send($key, $msg);
        }
    }
    
    function close($key) {
        $clients = $this->clients;
        if (isset($this->clients[$key]['socket'])) {
            $k = array_search($this->clients[$key]['socket'], $this->sockets);
            unset($this->sockets[$k]);
            unset($this->clients[$key]);
        }
    }
    
    function score($uid, $s, $t) {
        $key = 'saj9w27FfJUXUArF';
        $day = date("d");
        $token = md5($day.$uid.$s.$t.$key);
        $post_data = 'uid='.urlencode($uid).'&score='.urlencode($s).'&type='.urlencode($t).'&token='.urlencode($token);
        $r = intval($this->send_post('https://www.bbsyabo.com/plugin.php?id=sz:api', $post_data));
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

$socket = new Socket("172.31.162.110", 6677);
$socket->run();
