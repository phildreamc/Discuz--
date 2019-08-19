<?php
class Index extends Controller{
    public function __construct(){
        parent::__construct();
	}
    
    function index(){
        $conf = new Config();
        $conf->load_conf(ROOT . DS . 'app' . DS . 'web.conf.php');
        $user = new User();
        $this->assign('data', $conf->get_conf('data'));
        $this->display('index.tpl');
    }
    
    function bbb(){
        echo "aaa";
    }
}