<?php


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class threadplugin_transaction {
	var $name = '交易主题';
	var $iconfile = 'agree.gif';
	var $buttontext = '发布交易';
    var $data = array();
    
    function newthread($fid) {
        include template('transaction:post_transaction');
        return $return;
    }
    
    function newthread_submit($fid){
        global $_G, $item_price, $item_number, $activityaid_url, $tradeaid_url;
        $config = $_G['cache']['plugin']['transaction'];
        $table = DB::table('common_member_count');
        $extcredits = "extcredits".$config['extcredit'];
        $q = "select ".$extcredits." from ".$table." where uid = ".$_G['uid'];
        $count = DB::fetch_first($q);
        $score = $count[$extcredits];
        $item_price = trim($_GET['item_price']);
        $item_number = trim($_GET['item_number']);
        if (!is_numeric($item_price) || !is_numeric($item_number)){
            exit();
        }
        $activityaid_url = $this->filter(trim($_GET['activityaid_url']));
        $tradeaid_url = $this->filter(trim($_GET['tradeaid_url']));
        if ($score < $item_number){
            showmessage('博币不足！');
        }
        if(empty($item_price) || empty($item_number)){
            showmessage('请完善售卖信息！');
        }
        if(empty($activityaid_url) && empty($tradeaid_url)){
            showmessage('至少上传一张收款二维码！');
        }
    }
    
    function newthread_submit_end($fid, $tid){
        global $_G, $tablepre, $db, $item_price, $item_number, $activityaid_url, $tradeaid_url;
        $config = $_G['cache']['plugin']['transaction'];
        $date_time = new DateTime();
        $now = $date_time->format("Y-m-d H:i:s");
        $table = 'plugin_transaction';
        $data = array(
            'tid' => $tid,
            'uid' => $_G['uid'],
            'price' => $item_price,
            'number' => $item_number,
            'wx' => $tradeaid_url,
            'zfb' => $activityaid_url,
            'c_time' => $now,
            'status' => 'selling'
        );
        if ($id = DB::insert($table, $data, true, false, false)) {
            updatemembercount($_G['uid'], array($config['extcredit'] => $item_number*(-1)), true, '博币售卖', $id, '博币交易', '博币交易', '博币售卖');
            showmessage('发布成功！', './forum.php?mod=viewthread&tid='.$tid);
        }
        showmessage('抱歉，出错啦！');
    }
    
    function editpost($fid, $tid){
        // global $_G;
        // $table = DB::table('common_member_count');
        // $tid_data = DB::fetch_first("select * from $table where tid = $tid");
        // if ($tid_data['status'] == 'selling'){
            // include template('transaction:post_transaction');
            // return $return;
        // }
    }
    
    function editpost_submit($fid, $tid){
        // global $_G, $item_price, $item_number, $activityaid_url, $tradeaid_url;
        // $table = DB::table('common_member_count');
        // $tid_data = DB::fetch_first("select * from $table where tid = $tid");
        // if ($tid_data['status'] != 'selling'){
            // showmessage('提示：已进入购买流程，无法编辑！', './forum.php?mod=viewthread&tid='.$tid);
        // }
        // $config = $_G['cache']['plugin']['transaction'];
        // $extcredits = "extcredits".$config['extcredit'];
        // $q = "select ".$extcredits." from ".$table." where uid = ".$_G['uid'];
        // $count = DB::fetch_first($q);
        // $score = $count[$extcredits];
        // $item_price = trim($_GET['item_price']);
        // $item_number = trim($_GET['item_number']);
        // $activityaid_url = trim($_GET['activityaid_url']);
        // $tradeaid_url = trim($_GET['tradeaid_url']);
        // if ($score < $item_price*$item_number - $tid_data['price']*$tid_data['number']){
            // showmessage('博币不足！');
        // }
        // if(empty($item_price) || empty($item_number)){
            // showmessage('请完善售卖信息！');
        // }
        // if(empty($activityaid_url) && empty($tradeaid_url)){
            // showmessage('至少上传一张收款二维码！');
        // }
    }
    
    function editpost_submit_end($fid, $tid){
        // global $_G, $tablepre, $db, $item_price, $item_number, $activityaid_url, $tradeaid_url;
        // $table = DB::table('common_member_count');
        // $tid_data = DB::fetch_first("select * from $table where tid = $tid");
        // if ($tid_data['status'] != 'selling'){
            // showmessage('提示：已进入购买流程，无法编辑！', './forum.php?mod=viewthread&tid='.$tid);
        // }
        // $b_price = $tid_data['price'];
        // $b_number = $tid_data['number'];
        // $config = $_G['cache']['plugin']['transaction'];
        // $date_time = new DateTime();
        // $now = $date_time->format("Y-m-d H:i:s");
        // $table = 'plugin_transaction';
        // $data = array(
            // 'price' => $item_price,
            // 'number' => $item_number,
            // 'wx' => $tradeaid_url,
            // 'zfb' => $activityaid_url,
            // 'e_time' => $now
        // );
        // if (DB::update($table, $data, "tid = $tid")) {
            // updatemembercount($_G['uid'], array($config['extcredit'] => $b_price*$b_number), true, '博币售卖更新', $tid_data['id'], '博币交易', '博币交易', '博币售卖更新');
            // updatemembercount($_G['uid'], array($config['extcredit'] => $item_price*$item_number*(-1)), true, '博币售卖更新', $tid_data['id'], '博币交易', '博币交易', '博币售卖更新');
            // showmessage('编辑成功！', './forum.php?mod=viewthread&tid='.$tid);
        // }
        // showmessage('抱歉，出错啦！');
    }
    
    function newreply_submit_end($fid, $tid){
        
    }
    
    function viewthread($fid){
        global $_G;
        $param = array('plugin_transaction', $fid);
        $data = DB::fetch_first("select * from %t where tid = %d", $param);
        if (!$_G['uid']){
            $guest = 'guest';
        }else if ($_G['uid'] == $data['uid']){
            $guest = 'seller';
        }else if ($data['buyer'] && $_G['uid'] == $data['buyer']) {
            $guest = 'buyer';
        }else {
            $guest = 'other';
        }
        include template('transaction:view_transaction');
        return $return;
    }
    
    function filter($str){
        if (empty($str)) return false;
        $str = htmlspecialchars($str);
        $str = str_replace( '"', "", $str);
        $str = str_replace( '(', "", $str);
        $str = str_replace( ')', "", $str);
        $str = str_replace( 'CR', "", $str);
        $str = str_replace( 'ASCII', "", $str);
        $str = str_replace( 'ASCII 0x0d', "", $str);
        $str = str_replace( 'LF', "", $str);
        $str = str_replace( 'ASCII 0x0a', "", $str);
        $str = str_replace( ',', "", $str);
        $str = str_replace( '%', "", $str);
        $str = str_replace( ';', "", $str);
        $str = str_replace( 'eval', "", $str);
        $str = str_replace( 'open', "", $str);
        $str = str_replace( 'sysopen', "", $str);
        $str = str_replace( 'system', "", $str);
        $str = str_replace( '$', "", $str);
        $str = str_replace( "'", "", $str);
        $str = str_replace( "'", "", $str);
        $str = str_replace( 'ASCII 0x08', "", $str);
        $str = str_replace( '"', "", $str);
        $str = str_replace( '"', "", $str);
        $str = str_replace("", "", $str);
        $str = str_replace("&gt", "", $str);
        $str = str_replace("&lt", "", $str);
        $str = str_replace("<SCRIPT>", "", $str);
        $str = str_replace("</SCRIPT>", "", $str);
        $str = str_replace("<script>", "", $str);
        $str = str_replace("</script>", "", $str);
        $str = str_replace("select","",$str);
        $str = str_replace("join","",$str);
        $str = str_replace("union","",$str);
        $str = str_replace("where","",$str);
        $str = str_replace("insert","",$str);
        $str = str_replace("delete","",$str);
        $str = str_replace("update","",$str);
        $str = str_replace("like","",$str);
        $str = str_replace("drop","",$str);
        $str = str_replace("DROP","",$str);
        $str = str_replace("create","",$str);
        $str = str_replace("modify","",$str);
        $str = str_replace("rename","",$str);
        $str = str_replace("alter","",$str);
        $str = str_replace("cas","",$str);
        $str = str_replace("&","",$str);
        $str = str_replace(">","",$str);
        $str = str_replace("<","",$str);
        $str = str_replace(" ",chr(32),$str);
        $str = str_replace(" ",chr(9),$str);
        $str = str_replace("    ",chr(9),$str);
        $str = str_replace("&",chr(34),$str);
        $str = str_replace("'",chr(39),$str);
        $str = str_replace("<br />",chr(13),$str);
        $str = str_replace("''","'",$str);
        $str = str_replace("css","'",$str);
        $str = str_replace("CSS","'",$str);
        $str = str_replace("<!--","",$str);
        $str = str_replace("convert","",$str);
        $str = str_replace("md5","",$str);
        $str = str_replace("passwd","",$str);
        $str = str_replace("password","",$str);
        $str = str_replace("../","",$str);
        $str = str_replace("./","",$str);
        $str = str_replace("Array","",$str);
        $str = str_replace("or 1='1'","",$str);
        $str = str_replace(";set|set&set;","",$str);
        $str = str_replace("`set|set&set`","",$str);
        $str = str_replace("--","",$str);
        $str = str_replace("OR","",$str);
        $str = str_replace('"',"",$str);
        $str = str_replace("*","",$str);
        $str = str_replace("-","",$str);
        $str = str_replace("+","",$str);
        $str = str_replace("=","",$str);
        $str = str_replace("'/","",$str);
        $str = str_replace("-- ","",$str);
        $str = str_replace(" -- ","",$str);
        $str = str_replace(" --","",$str);
        $str = str_replace("(","",$str);
        $str = str_replace(")","",$str);
        $str = str_replace("{","",$str);
        $str = str_replace("}","",$str);
        $str = str_replace("-1","",$str);
        $str = str_replace("response","",$str);
        $str = str_replace("write","",$str);
        $str = str_replace("|","",$str);
        $str = str_replace("`","",$str);
        $str = str_replace(";","",$str);
        $str = str_replace("etc","",$str);
        $str = str_replace("root","",$str);
        $str = str_replace("//","",$str);
        $str = str_replace("!=","",$str);
        $str = str_replace("$","",$str);
        $str = str_replace("&","",$str);
        $str = str_replace("&&","",$str);
        $str = str_replace("==","",$str);
        $str = str_replace("#","",$str);
        $str = str_replace("@","",$str);
        $str = str_replace("mailto:","",$str);
        $str = str_replace("CHAR","",$str);
        $str = str_replace("char","",$str);
        return $str;
    }
}