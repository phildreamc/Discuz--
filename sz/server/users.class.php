<?php
class Users {
    var $users;
    
    public function __construct(){
        $this->users = array();
	}
    
    public function auth($user, $uid, $t) {
        $api_token = "VPYXsIghDH";
        $token = md5($uid.$user.$api_token);
        $r = $token == $t ? TRUE : FALSE;
        return $r;
    }
    
    public function login($user, $uid, $key) {
        $info = array('uid' => $uid, 'key' => $key);
        $this->users[$user] = $info;
    }
    
    public function logout($user) {
        unset($this->users[$user]);
    }
}