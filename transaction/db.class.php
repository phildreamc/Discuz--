<?php

class DB {
    private $config;
    private $conn;
    public $extcredit;
    
    public function __construct($config){
        $this->config = $this->set_config($config);
        $this->set_conn();
    }
    
    public function set_config($_config) {
        return array(
            'host' => $_config['db'][1]['dbhost'],
            'user' => $_config['db'][1]['dbuser'],
            'pw' => $_config['db']['1']['dbpw'],
            'charset' => $_config['db']['1']['dbcharset'],
            'connect' => $_config['db']['1']['pconnect'],
            'tablepre' => $_config['db']['1']['tablepre'],
            'name' => $_config['db']['1']['dbname'],
            'slave' => $_config['db']['slave'],
            'slave_except_table' => $_config['db']['common']['slave_except_table'],
        );
    }
    
    public function score($uid, $s, $method) {
        if (!$this->conn) {
            $this->set_conn();
        }
        $table = $this->config['tablepre'].'common_member_count';
        $n = "select extcredits".$this->extcredit." from ".$table." where uid=".$uid;
        $result = mysqli_query($this->conn, $n);
        $row = mysqli_fetch_assoc($result);
        $now = $row["extcredits".$this->extcredit];
        if ($method == 'add'){
            $now += $s;
        }else if ($method == 'dec'){
            $now -= $s;
        }else {
            return $now;
        }
        $q = "update ".$table." set extcredits".$this->extcredit." =".$now." where uid=".$uid;
        return mysqli_query($this->conn, $q);
    }
    
    public function fetch() {
        if (!$this->conn) {
            $this->set_conn();
        }
        $q = "select value from ".$this->config['tablepre']."common_pluginvar where title='Phildreamc_extcredit' and variable='extcredit'";
        $result = mysqli_query($this->conn, $q);
        $row = mysqli_fetch_assoc($result);
        return $row['value'];
    }
    
    public function set_conn() {
        $this->conn = new mysqli($this->config['host'], $this->config['user'], $this->config['pw'], $this->config['name']);
        if (!$this->conn) {
            die('Could not connect: ' . mysql_error());
        }
        $this->extcredit = $this->fetch();
    }
    
    public function dis_con(){
        mysqli_close($this->conn);
    }
}