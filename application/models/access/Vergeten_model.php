<?php

class Vergeten_model extends CI_Model {
    
    public function data_check($data_check) {
        
        $this->db->from('user_login');
        
        $this->db->where($data_check);
        
        $query = $this->db->get();
        $check_hash = $query->row_array();
        
        return $check_hash;
    }
    
    public function change_pw($user_email, $user_pw) {
        
        $this->db->from('user_login');
        
        $this->db->where($user_email);
        
        $updated_pw = $this->db->update('user_login',$user_pw);
        
        return $updated_pw;
        
    }
}