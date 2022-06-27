<?php

class Crud_model extends CI_Model
{

    public function get_entries()
    {
        $query = $this->db->get('products');
        return $query->result();
    }

    public function insert_entry($data)
    {
         $this->db->insert('products', $data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }

    public function delete_entry($id)
    {
        return $this->db->delete('products', array('id' => $id));
    }
    
    public function delete_entry_all($id)
    {
        return $this->db->delete('product_images', array('product_id' => $id));
    }

    public function single_entry($id)
    {
        $this->db->select('*');
        $this->db->from('products');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if (count($query->result()) > 0) {
            return $query->row();
        }
    }

    public function update_entry($id, $data)
    {
        return $this->db->update('products', $data, array('id' => $id));
    }
    
     public function insertImage($data = array()) { 
        if(!empty($data)){ 
             
            // Insert gallery data 
            $insert = $this->db->insert_batch('product_images', $data); 
             
            // Return the status 
            return $insert?$this->db->insert_id():false; 
        } 
        return false; 
    } 
}
