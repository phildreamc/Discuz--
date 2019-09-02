<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$action = $_GET['action'];
$tid = $_GET['tid'];

if (!$_G['uid'] || !is_numeric($tid)){
    exit();
}

$table = DB::table('plugin_transaction');
$config = $_G['cache']['plugin']['transaction'];
$tid_data = DB::fetch_first("select * from $table where tid = $tid");
// updatemembercount($_G['uid'], array($config['extcredit'] => 10), true, '博币交易', $tid_data['id'], '博币交易', '博币交易', '博币交易');

if ($action == 'cancel') {
    if ($_G['uid'] == $tid_data['uid'] && $tid_data['status'] == 'selling'){
        $date_time = new DateTime();
        $now = $date_time->format("Y-m-d H:i:s");
        if (DB::update('plugin_transaction', array('f_time'=>$now, 'status' => 'canceled'), "tid = $tid")){
            updatemembercount($_G['uid'], array($config['extcredit'] => $tid_data['number']), true, '博币售卖取消', $tid_data['id'], '博币交易', '博币交易', '博币售卖取消');
            echo 'true';
        }else {
            echo '系统错误，请重试或联系管理员！';
        }
    }else if($_G['uid'] == $tid_data['uid'] && $tid_data['status'] != 'selling'){
        echo '已进入购买流程，无法取消！';
    }
}

if ($action == 'buy') {
    if ($_G['uid'] != $tid_data['uid'] && $tid_data['status'] == 'selling'){
        $date_time = new DateTime();
        $now = $date_time->format("Y-m-d H:i:s");
        if (DB::update('plugin_transaction', array("buyer" =>$_G['uid'],"b_time"=>$now, "status" => "paying"), "tid = $tid")){
            echo 'true';
        }else {
            echo '系统错误，请重试或联系管理员！';
        }
    }
}

if ($action == 'paied') {
    if ($_G['uid'] == $tid_data['buyer'] && $tid_data['status'] == 'paying'){
        $date_time = new DateTime();
        $now = $date_time->format("Y-m-d H:i:s");
        if (DB::update('plugin_transaction', array("p_time"=>$now, "status" => "paied"), "tid = $tid")){
            echo 'true';
        }else {
            echo '系统错误，请重试或联系管理员！';
        }
    }
}

if ($action == 'receipt') {
    if ($_G['uid'] == $tid_data['uid'] && $tid_data['status'] == 'paied'){
        $date_time = new DateTime();
        $now = $date_time->format("Y-m-d H:i:s");
        if (DB::update('plugin_transaction', array("f_time"=>$now, "status" => "end"), "tid = $tid")){
            updatemembercount($tid_data['buyer'], array($config['extcredit'] => $tid_data['number']), true, '博币购买', $tid_data['id'], '博币交易', '博币交易', '博币购买');
            echo 'true';
        }else {
            echo '系统错误，请重试或联系管理员！';
        }
    }
}
