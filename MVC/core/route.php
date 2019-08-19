<?php
function call_hook(){
    global $url;
    global $default;
    
    $param = array();
    
    $urlArr = explode("/", rtrim($url, "/"));
    $controller = array_shift($urlArr);
    $action = array_shift($urlArr);
    $param = $urlArr;

    if ($controller == ""){
        $controller = $default['controller'];
        $action = $default['action'];
    }
    
    if ($action == ""){
        $action = $default['action'];
    }
    
    $controller_name = ucfirst($controller);
    $dispatch = new $controller_name($controller, $action);
    
    if (method_exists($dispatch, ucfirst($action))){
        call_user_func_array(array($dispatch, ucfirst($action)), $param);
    }else{
        die('method not exitsts.<br />');
    }
}

function auto_load($classname){
    if (file_exists(ROOT . DS . 'core' . DS . strtolower($classname) . '.class.php')){
        require_once(ROOT . DS . 'core' . DS . strtolower($classname) . '.class.php');
    }else if(file_exists(ROOT . DS . 'app' . DS . 'controller' . DS . strtolower($classname) . '.php')){
        require_once(ROOT . DS . 'app' . DS . 'controller' . DS . strtolower($classname) . '.php');
    }else if(file_exists(ROOT . DS . 'app' . DS . 'model' . DS . strtolower($classname) . '.php')){
        require_once(ROOT . DS . 'app' . DS . 'model' . DS . strtolower($classname) . '.php');
    }else{
        die('class not found.<br />');
    }
}

spl_autoload_register('auto_load');
call_hook();