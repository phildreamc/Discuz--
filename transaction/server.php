<?php
include "websocket.class.php";
include "../../../config/config_global.php";
include "db.class.php";

class Socket extends WebSocket {
    public $rooms;
    public $map;
    public $users;
    public $db;
    public $uids;
    
    public function __construct($address, $port){
        $this->master = $this->ws($address, $port);
        $this->sockets = array($this->master);
        self::set_rooms();
    }
    
    function getdata($key, $msg){
        $arr = json_decode($msg, true);
        if ($arr['sys'] == 'token') {
            $api_token = "VPYXsIghDH";
            $token = md5($arr['uid'].$arr['name'].$api_token);
            if ($token == $arr['token']) {
                if (array_key_exists($arr['name'], $this->map) && count($this->rooms[$this->map[$arr['name']]]['users']) == 2) {
                    $r = $this->map[$arr['name']];
                    if ($this->rooms[$r]['users'][0] == $arr['name']) {
                        $isfirst = 'a';
                    }else {
                        $isfirst = 'no';
                    }
                    $i = array('step' => $this->rooms[$r]['step'], 'round' => $this->rooms[$r]['round'], 'score' => $this->rooms[$r]['score'], 'bet' => $this->rooms[$r]['bet'], 'isfirst' => $isfirst, 'users' => $this->rooms[$r]['users']);
                    $m = array('sys' => 'auth', 'code' => 'reconn', 'msg' => $i);
                }else {
                    
                    $m = array('sys' => 'auth', 'code' => 'success', 'msg' => '');
                }
                if (array_key_exists($arr['name'], $this->users)){
                    $this->close($this->users[$arr['name']]);
                }
                $this->users[$arr['name']] = $key;
                $this->uids[$arr['name']] = $arr['uid'];
                $this->send($key, json_encode($m));
                $this->send($key, json_encode(array('sys' => 'sys', 'code' =>'new','msg' => $this->map)));
            }else {
                $m = array('sys' => 'auth', 'code' => 'erro', 'msg' => '');
                $this->send($key, json_encode($m));
                $this->close($key);
            }
        }
        if ($arr['sys'] == 'msg') {
            if (in_array($key, $this->users)) {
                if ($arr['code'] == 'all') {
                    if (strlen($arr['msg']) < 100) {
                        $m = array('sys' => 'msg', 'code' => 'all', 'msg' => $this->name($key).":".$arr['msg']);
                        $this->sendAll(json_encode($m));
                    }
                }
            }
        }
        if ($arr['sys'] == 'sys') {
            if (in_array($key, $this->users)) {
                if ($arr['code'] == 'join' && is_numeric($arr['msg']) && count($this->rooms[$arr['msg']]['users']) < 2) {
                    if(!array_key_exists($this->name($key), $this->map)) {
                        if ($this->db->score($this->uids[$this->name($key)], 0, 'get') >= 10) {
                            array_push($this->rooms[$arr['msg']]['users'], $this->name($key));
                            $this->map[$this->name($key)] = $arr['msg'];
                            if (count($this->rooms[$arr['msg']]['users']) == 1) {
                                $m = array('sys' => 'sys', 'code' => 'wait', 'msg' => 'wait');
                                $this->sendRoom($arr['msg'], json_encode($m));
                                $this->rooms[$arr['msg']]['step'] = 'wait';
                                $this->rooms[$arr['msg']]['bet'] = 10;
                            }
                            if (count($this->rooms[$arr['msg']]['users']) == 2){
                                $this->rooms[$arr['msg']]['step'] = 'hide';
                                $this->rooms[$arr['msg']]['round'] = 1;
                                $this->rooms[$arr['msg']]['score'] = [0, 0];
                                $i = array('round' => $this->rooms[$arr['msg']]['round'],'f' => $this->rooms[$arr['msg']]['score'][0],'l' => $this->rooms[$arr['msg']]['score'][1], 'bet' => $this->rooms[$arr['msg']]['bet'], 'users' => $this->rooms[$arr['msg']]['users']);
                                $m = array('sys' => 'sys', 'code' => 'start', 'msg' => json_encode($i));
                                $this->db->score($this->uids[$this->rooms[$arr['msg']]['users'][0]], 10, 'dec');
                                $this->db->score($this->uids[$this->rooms[$arr['msg']]['users'][1]], 10, 'dec');
                                $this->sendRoom($arr['msg'], json_encode($m));
                            }
                            $this->sendAll(json_encode(array('sys' => 'sys', 'code' =>'new','msg' => $this->map)));
                        }else {
                            $m = array('sys' => 'sys', 'code' => 'noload', 'msg' => 10);
                            $this->send($key, json_encode($m));
                        }
                    }
                }
                if ($arr['code'] == 'hide' && is_numeric($arr['msg']) && intval($arr['msg']) <= 3 && intval($arr['msg'])>= 1 && $this->rooms[$this->map[$this->name($key)]]['step'] == 'hide' && array_key_exists($this->name($key), $this->map) && $this->name($key) == $this->rooms[$this->map[$this->name($key)]]['users'][($this->rooms[$this->map[$this->name($key)]]['round']+1)%2]) {
                    $this->rooms[$this->map[$this->name($key)]]['hide'] = $arr['msg'];
                    $m = array('sys' => 'sys', 'code' => 'hide');
                    $this->sendRoom($this->map[$this->name($key)], json_encode($m));
                    $this->rooms[$this->map[$this->name($key)]]['step'] = 'open';
                }
                if ($arr['code'] == 'open' && is_numeric($arr['msg']) && intval($arr['msg']) <= 3 && intval($arr['msg'])>= 1 && $this->rooms[$this->map[$this->name($key)]]['step'] == 'open' && array_key_exists($this->name($key), $this->map) && $this->name($key) == $this->rooms[$this->map[$this->name($key)]]['users'][$this->rooms[$this->map[$this->name($key)]]['round']%2]) {
                    $this->rooms[$this->map[$this->name($key)]]['open'] = $arr['msg'];
                    $m = array('sys' => 'sys', 'code' => 'result', 'msg' => array('hide' => $this->rooms[$this->map[$this->name($key)]]['hide'], 'open' => $this->rooms[$this->map[$this->name($key)]]['open']));
                    $this->sendRoom($this->map[$this->name($key)], json_encode($m));
                    if ($this->rooms[$this->map[$this->name($key)]]['round']%2==0) {
                        if ($this->rooms[$this->map[$this->name($key)]]['hide'] == $this->rooms[$this->map[$this->name($key)]]['open']) {
                            $this->rooms[$this->map[$this->name($key)]]['score'][0] += 1; 
                        }else {
                            $this->rooms[$this->map[$this->name($key)]]['score'][1] += 1;
                        }
                    }else {
                        if ($this->rooms[$this->map[$this->name($key)]]['hide'] == $this->rooms[$this->map[$this->name($key)]]['open']) {
                            $this->rooms[$this->map[$this->name($key)]]['score'][1] += 1; 
                        }else {
                            $this->rooms[$this->map[$this->name($key)]]['score'][0] += 1;
                        }
                    }
                    if ($this->rooms[$this->map[$this->name($key)]]['round'] <10 && abs($this->rooms[$this->map[$this->name($key)]]['score'][0] - $this->rooms[$this->map[$this->name($key)]]['score'][1]) <= 10 - $this->rooms[$this->map[$this->name($key)]]['round']) {
                        $this->rooms[$this->map[$this->name($key)]]['round'] += 1;
                        $this->rooms[$this->map[$this->name($key)]]['step'] = 'hide';
                    }else {
                        $roomnumber = $this->map[$this->name($key)];
                        $alluser = $this->rooms[$roomnumber]['users'];
                        if ($this->rooms[$this->map[$this->name($key)]]['score'][0] > $this->rooms[$this->map[$this->name($key)]]['score'][1]) {
                            $this->db->score($this->uids[$alluser[0]], 20, 'add');
                        }else if($this->rooms[$this->map[$this->name($key)]]['score'][0] < $this->rooms[$this->map[$this->name($key)]]['score'][1]){
                            $this->db->score($this->uids[$alluser[1]], 20, 'add');
                        }else {
                            $this->db->score($this->uids[$alluser[0]], 10, 'add');
                            $this->db->score($this->uids[$alluser[1]], 10, 'add');
                        }
                        $this->rooms[$this->map[$this->name($key)]] = array();
                        $this->rooms[$this->map[$this->name($key)]]['users'] = array();
                        unset($this->map[$alluser[0]]);
                        unset($this->map[$alluser[1]]);
                        $this->sendAll(json_encode(array('sys' => 'sys', 'code' =>'new','msg' => $this->map)));
                    }
                    // $m = array('sys' => 'sys', 'code' => 'next', 'msg' => '');
                    // $this->sendRoom($this->map[$key], json_encode($m));
                    // $this->rooms[$this->map[$key]]['step'] = 'hide';
                }
            }
            if ($arr['code'] == 'close') {
                $this->close($key);
            }
        }
    }
    
    function name($key) {
        $name = array_search($key, $this->users);
        return $name;
    }
    
    function sendRoom($num, $msg){
        foreach ($this->rooms[$num]['users'] as $user) {
            $this->send($this->users[$user], $msg);
        }
    }
    
    function sendAll($msg){
        $clients = $this->clients;
        foreach ($clients as $key=>$client){
            $this->send($key, $msg);
        }
    }
    
    function send($key, $msg){
        $msg = $this->frame($msg);
        $clients = $this->clients;
        socket_write($clients[$key]['socket'], $msg, strlen($msg));
    }
    
    function close($key) {
        $clients = $this->clients;
        if (array_key_exists($this->name($key), $this->map) && count($this->rooms[$this->map[$this->name($key)]]['users']) == 1) {
            $this->rooms[$this->map[$this->name($key)]] = array();
            $this->rooms[$this->map[$this->name($key)]]['users'] = array();
            unset($this->map[$this->name($key)]);
            $this->sendAll(json_encode(array('sys' => 'sys', 'code' =>'new','msg' => $this->map)));
        }
        socket_close($clients[$key]['socket']);
        $k = array_search($this->clients[$key]['socket'], $this->sockets);
        unset($this->users[$this->name($key)]);
        unset($this->uids[$this->name($key)]);
        unset($this->sockets[$k]);
        unset($this->clients[$key]);
    }
    
    function set_rooms(){
        $this->map = array();
        $this->users = array();
        $this->rooms = array();
        $this->uids = array();
        for ($i=0; $i < 12; $i++){
            $this->rooms[$i] = array();
            $this->rooms[$i]['users'] = array();
        }
    }
    
    function set_db($db){
        $this->db = $db;
    }
}

$db = new DB($_config);
$socket = new Socket("127.0.0.1", 5555);
$socket->set_db($db);
$socket->run();
