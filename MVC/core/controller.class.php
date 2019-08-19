<?php
class Controller{
    var $smarty;
    
    public function __construct(){
        $this->smarty = new Smarty();
        $this->smarty->template_dir = ROOT . DS . 'app' . DS . 'view' . DS . get_called_class() . DS;
	}
    
    public function assign($name, $value){
        $this->smarty->assign($name, $value);
    }
    
    public function display($view){
        $this->smarty->display($view);
    }
}