<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'phil');

define('DIR_TPL', ROOT . DS . 'app' . DS . 'view' . DS . 'template_dir' . DS . 'default' . DS);
define('DIR_CPL', ROOT . DS . 'app' . DS . 'view' . DS . 'compile_dir' . DS);
define('DIR_CFG', ROOT . DS . 'app' . DS . 'view' . DS . 'config_dir' . DS);
define('DIR_CAC', ROOT . DS . 'app' . DS . 'view' . DS . 'cache_dir' . DS);

$default['controller'] = 'index';
$default['action'] = 'index';

define('WEBSITE', 'http://localhost');
define('WEBIMG', WEBSITE . dirname(dirname($_SERVER['PHP_SELF'])) . '/public/img/');