<?php

require_once ('config.php');

function __autoload($class_name) {
    // So lets say that we have Front_Controller, then
    // Front will be the first element of the array
    // Conttoller will be the second one
    // because they concanated with "_" character
    $class = explode("_", $class_name);


    // Implode is the opposite of explode. Instead to devide, it will 
    // concanete the array
    // as a concanenater we will use "/"
    // this way, let say we have as previously Front_Controller
    // the Front/Controller.php
    $path = implode("/", $class) . ".php";
    require_once($path);
}
