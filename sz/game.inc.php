<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if(!$_G['uid']){
    showmessage('请先登录！', null, array(), array('login' => '1'));
    exit();
}

$config = $_G['cache']['plugin']['sz'];
$table = DB::table('common_member_count');
$extcredits = "extcredits".$config['extcredit'];
$q = "select ".$extcredits." from ".$table." where uid = ".$_G['uid'];
$count = DB::fetch_first($q);
$score = $count[$extcredits];
$api_token = "VPYXsIghDH";
$token = md5($_G['uid'].$_G['username'].$api_token);
include template('sz:game');
echo $return;