<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$uid = $_GET["uid"];
$score = $_GET["score"];
$type = $_GET["type"];
$token = $_GET["token"];
$key = 'saj9w27FfJUXUArF';

$config = $_G['cache']['plugin']['sz'];
$table = DB::table('common_member_count');
$extcredits = "extcredits".$config['extcredit'];

echo api($uid, $score, $type, $token, $key);

function api($uid, $score, $type, $token, $key) {
    global $extcredits, $table, $config;
    $day = $day = date("d");
    $s = md5($day.$uid.$score.$type.$key);
    if ($s != $token) {
        return "erro";
    }
    if ($type == 'add'){
        $r = updatemembercount($uid, array($config['extcredit'] => $score), true, '骰子游戏', 0, '骰子游戏', '骰子游戏', '骰子游戏');
    }else if ($type == 'get'){
        $q = "select ".$extcredits." from ".$table." where uid = ".$_GET["uid"];
        $count = DB::fetch_first($q);
        $r = $count[$extcredits];
    }
    return $r;
}