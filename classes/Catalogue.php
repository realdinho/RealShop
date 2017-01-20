<?php

class Catalogue extends Application
{

    private $_table = 'categories';
    private $_table_2 = 'products';
    public $_path = 'media/catalogue/';
    public static $_currency = '&pound';
    public $_id;

    public function getCategories()
    {
        $sql = "SELECT * FROM `{$this->_table}`
                ORDER BY `name` ASC";
        return $this->db->fetchAll($sql);
    }

    public function getCategory($id)
    {
        $sql = "SELECT * FROM `{$this->_table}`
                WHERE `id`= '" . $this->db->escape($id) . "'";
        return $this->db->fetchOne($sql);
    }

    public function getProducts($cat)
    {
        $sql = "SELECT * FROM `{$this->_table_2}`
                WHERE `category`= '" . $this->db->escape($cat) . "'
                ORDER BY `date` DESC";
        return $this->db->fetchAll($sql);
    }

    public function getProduct($id)
    {
        $sql = "SELECT * FROM `{$this->_table_2}`
                WHERE `id`= '" . $this->db->escape($id) . "'";
        return $this->db->fetchOne($sql);
    }

    public function getAllProducts($srch = null)
    {
        $sql = "SELECT * FROM `{$this->_table_2}`";
        if (!empty($srch)) {
            $srch = $this->db->escape($srch);
            $sql .= " WHERE `name` LIKE '%{$srch}%' || `id` = '{$srch}'";
        } else {
            $sql .= " ORDER BY `date` DESC";
        }
        return $this->db->fetchAll($sql);
    }

    public function addProduct($params = null)
    {
        if (!empty($params)) {
            $params['date'] = Helper::setDate();
            $this->db->prepareInsert($params);
            $out = $this->db->insert($this->_table_2);
            $this->_id = $this->db->_id;
            return $out;
        }
        return false;
    }

    public function updateProduct($params = null, $id = null)
    {
        if (!empty($params) && !empty($id)) {

            $this->db->prepareUpdate($params);
            return $this->db->update($this->_table_2, $id);
        }
    }

    public function removeProduct($id = null)
    {
        if (!empty($id)) {
            $product = $this->getProduct($id);
            if (!empty($product)) {
                if (is_file(CATALOGUE_PATH . DS . $product['image'])) {
                    unlink(CATALOGUE_PATH . DS . $product['image']);
                }

                $sql = "DELETE FROM `{$this->_table_2}`
                      WHERE `id` = '" . $this->db->escape($id) . "'";
                return $this->db->query($sql);
            }
            return false;
        }
        return false;
    }

    public function addCategory($params = null)
    {
        if (!empty($params)) {
            $this->db->prepareInsert($params);
            $out = $this->db->insert($this->_table);
            $this->_id = $this->db->_id;
            return $out;
        }
        return false;
    }

    public function updateCategory($params = null, $id = null)
    {
        if (!empty($params) && !empty($id)) {
            $this->db->prepareUpdate($params);
            return $this->db->update($this->_table, $id);
        }
    }

    public function removeCategory($id = null)
    {
        if (!empty($id)) {
            $category = $this->getCategory($id);
            if (!empty($category)) {
                $sql = "DELETE FROM `{$this->_table}`
                      WHERE `id` = '" . $this->db->escape($id) . "'";
                return $this->db->query($sql);
            }
            return false;
        }
        return false;

    }

    public function duplicateCategory($name = null, $id = null)
    {
        if (!empty($name)) {
            $sql = "SELECT * FROM `{$this->_table}`
					WHERE `name` = '" . $this->db->escape($name) . "'";
            $sql .= !empty($id) ?
                " AND `id` != '" . $this->db->escape($id) . "'" :
                null;
            
            return $this->db->fetchOne($sql);
        }
        return false;

    }
}