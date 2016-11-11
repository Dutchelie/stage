<?php
//Models geven alleen data heen en weer.
class Register_model extends CI_Model {

    public function get_data($register_data) {
        //var_dump($register_data);

//        $this->db->from('user');
//
//        $this->db->where($register_data);
//
//        $query = $this->db->get();
//        $check_result = $query->row_array();
//
//        return $check_result;
        return FALSE;
    }

    public function register_data($account_data) {
        
//        $this->db->insert('user', $account_data);
//
//        $id = $this->db->insert_id();
//
//        return $id;
        return 1;
    }

    public function send_login_data($user_id, $user_email) {

        //verander de key emailaddress naar username zodat het in de user_login tabel kan als username.        
//        $user_login = array (
//            'user_id' => $user_id,
//            'username' => $user_email,
//            
//        );
//
//        $data_login = $this->db->insert('user_login', $user_login);
//        return $data_login;
        return TRUE;
    }
    
}
