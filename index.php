<?php
define("APP_DIR", __DIR__.DIRECTORY_SEPARATOR."Application");
define("VIEWS_DIR", APP_DIR.DIRECTORY_SEPARATOR."Views");

function autoloader($class) {
	$filepath = str_replace('\\', DIRECTORY_SEPARATOR, $class) . ".php";
    require_once $filepath;
}

spl_autoload_register('autoloader');

if(php_sapi_name() === "cli"){
    $controller = new \Application\Controllers\ConsoleController();
}else{
    $controller = new \Application\Controllers\WebController();
}

$controller->index();