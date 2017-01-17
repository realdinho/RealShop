<?php

class Catalogue extends Application{
    private $_table = 'categories';
    private $_table_2 = 'products';
    public $_path = 'media/catalogue/';
    public static $_currency = '&pound;';

    public function getCategories(){
        $sql = "SELECT * FROM `{$this->_table}` ORDER BY `name` ASC";
        
        return $this->db->fetchAll($sql);
    }
    
    public function getCategory($id){
        $sql = "SELECT * FROM `{$this->_table}` WHERE `id`='".$this->db->escape($id)."'";
        
        return $this->db->fetchOne($sql);
    }
    
    public function getProducts($cat){
        $sql = "SELECT * FROM `{$this->_table_2}` WHERE `category`='".$this->db->escape($cat)."' ORDER BY `date` DESC";
        
        return $this->db->fetchAll($sql);
    }

    public function getProduct($id){
        $sql = "SELECT * FROM `{$this->_table_2}` WHERE `id`='".$this->db->escape($id)."'";
        
        return $this->db->fetchOne($sql);
    }
}
