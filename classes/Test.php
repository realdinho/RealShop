<?php

class Test{
    public static $first_name = "Realdo";
    public $last_name = "Dias";
    
    public function getUser(){
        return $this->last_name;
    }
    
    public static function getFName(){
        return self::$first_name;
    }
}

