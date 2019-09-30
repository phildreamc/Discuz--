<?php
require_once("game.class.php");

class Room {
    var $users;
    var $timerecord;
    var $now;
    var $wait;
    var $last;
    var $game;
    
    public function __construct() {
        $this->users = array();
	}
    
    public function _join($user) {
        array_push($this->users, $user);
    }
    
    public function _quit($user) {
        $key = array_search($user, $this->users);
        unset($this->users[$key]);
        $this->users = array_values($this->users);
    }
    
    public function start() {
        $this->timerecord = time();
        $n = mt_rand(0,1);
        $this->now = $this->users[$n];
        foreach ($this->users as $user) {
            if ($user != $this->now) {
                $this->wait = $user;
            }
        }
        $this->last = array();
        $this->game = Game::newgame();
    }
    
    public function roomCall($cards) {
        if (empty($this->last) || Game::compare($cards, $this->last)) {
            $this->last = $cards;
            $tmp = $this->now;
            $this->now = $this->wait;
            $this->wait = $tmp;
            $this->timerecord = time();
            return TRUE;
        }
        return FALSE;
    }
    
    public function inroom($user) {
        foreach($this->users as $name) {
            if ($name == $user) {
                return TRUE;
            }
        }
        return FALSE;
    }
    
    public function users_number() {
        return count($this->users);
    }
    
    public function isin() {
        return Game::ifture($this->last, $this->game, $this->last[2]);
    }
    
    public function istimeout($limit) {
        if (!empty($this->timerecord)) {
            $n = time();
            $t = $n - $this->timerecord;
            if ($t > $limit) {
                return TRUE;
            }
        }
        return FALSE;
    }
    
    public function gettime() {
        if (!empty($this->timerecord)) {
            $n = time();
            $t = 30 - ($n - $this->timerecord);
            
            return $t;
        }
        return FALSE;
    }
}