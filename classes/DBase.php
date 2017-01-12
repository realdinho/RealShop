<?php

class DBase{
    private $_host = "us-cdbr-iron-east-04.cleardb.net";
    private $_user = "b93497a15432a9";
    private $_password = "c38a0b0e";
    private $_name = "heroku_547a30bfe0838c4";
    
    private $_connDB = false;
    public $_last_query = null;
    public $_affected_rows = 0;
    
    public $_insert_keys = array();
    public $_insert_values = array();
    
    public $_id;
    
    public function __construct() {
        $this->connect();
    }
    
    private function connect() {
        $this->_connDB = mysql_connect($this->_host, $this->_user, $this->_password);
        
        if(!$this->_connDB){
            die("Database connection failed: <br/>".mysql_error());
        } else{
            $_select = mysql_select_db($this->_name, $this->_connDB);
            
            if(!$_select){
                die("Database selection failed: <br/>".mysql_error());
            }
        }
        mysql_set_charset("utf8", $this->_connDB);
    }
    
    public function close(){
        if(!mysql_close($this->_connDB)){
            die("Closing connection failed!");
        }
    }
    
    public function escape($value){
        if(function_exists("mysql_real_escape_string")){
            if(get_magic_quotes_gpc()){
                $value = stripcslashes($value);
            }
            $value = mysql_real_escape_string($value);
        } else {
            if(!get_magic_quotes_gpc()){
                $value = addcslashes($value);
            }
        }
        return $value;
    }

    public function query($sql){
        $this->_last_query = $sql;
        $result = mysql_query($sql, $this->_connDB);
        $this->displayQuery($result);
        return $result;
    }
    
    public function displayQuery($result){
        if(!$result){
            $output = "Database query failed: ".mysql_error()."<br/>";
            $output .= "Last SQL query was: ".$this->_last_query;
            die($output);
        } else{
            $this->_affected_rows = mysql_affected_rows($this->_connDB);
        }
    }
    
    public function fetchAll($sql){
        $result = $this->query($sql);
        $out = array();
        while ($row = mysql_fetch_assoc($result)) {
            $out[] = $row;
        }
        mysql_free_result($result);
        return $out;
    }
    
    public function fetchOne($sql){
        $out = $this->fetchAll($sql);
        return array_shift($out);
    }
    
    public function lastId(){
        return mysql_insert_id($this->_connDB);
    }
}

