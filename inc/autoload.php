<?php

require_once('inc/config.php');
//define('__ROOT__', dirname(dirname(__FILE__)));
//require_once(dirname(__FILE__) . "/config.php");

function __autoload($class_name){
    $class = explode("_", $class_name);
    $path = implode("/", $class).".php";
//    $path = __DIR__ .'/../classes/'. implode("/", $class).".php";
    require_once($path);
}

