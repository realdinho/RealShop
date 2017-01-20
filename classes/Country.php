<?php

class Country extends Application{
    
    private $_table = 'countries';
    
    public function getCountries(){
        $sql = "SELECT * FROM `{$this->_table}`
                ORDER BY `name` ASC";
        return $this->db->fetchAll($sql);
    }
    
     public function getCountry($id = null){
         if(!empty($id)){
             $sql = "SELECT * FROM `{$this->_table}`
                    WHERE `id` = '".$this->db->escape($id)."'";
             
             return $this->db->fetchOne($sql);
         }
     }
}

