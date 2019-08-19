<?php
class Config{
    protected static $config;
    
    function load_conf($file){
        if (is_file($file)){
            self::$config = include_once $file;
        }
    }
    
    function get_conf($name){
        if (isset(self::$config[$name])){
            return self::$config[$name];
        }else{
            return "config $name is undefined";
        }
    }
}