<?php

class Wachtwoord_model extends CI_Model {
    
    public function check_key($arr_key) {
        
        $this->db->from('user');
        
        $this->db->where($arr_key);
        
        $query = $this->db->get();
        $check_result = $query->row_array();
        
        return $check_result;
        
    }
    
    public function store_password($wachtwoord_data) {
        
        $data_send = $this->db->insert('user_login', $wachtwoord_data);
        
        $user_id = $this->session->userdata('user_id');
        
        $this->db->where('user_id', $user_id);
        
        $pass_send = $this->db->update('user_login' ,$wachtwoord_data);
        
        return $pass_send;
    }
}