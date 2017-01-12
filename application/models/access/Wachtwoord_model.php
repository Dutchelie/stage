<?php
//models only receive and retreive data away
class Wachtwoord_model extends CI_Model {
    //Check if account is active or not.
    public function get_active($arr_key) {
        //select column is_active
        $this->db->select('is_active');
        //from the table user
        $this->db->from('user');
        //where column user_id has value ($arr_key["0"]) = user_id 10
        $this->db->where('user_id', $arr_key["0"]);
        //when user_id 10 exists get the value of is_active and
        //put it into an array
        $query = $this->db->get();
        $result = $query->row_array();
        //return this array
        //it returns true(if data exists) or false(if data does NOT exist)
        return $result;
    }
    //Here you store the password at the right user_id.
    public function store_password($wachtwoord_data, $user_id) {
        //where column user_id has value($user_id["0"]) 10
        $this->db->where('user_id', $user_id["0"]);
        //update table user_login, column ($wachtwoord_data) password at user_id 10
        $pass_send = $this->db->update('user_login' ,$wachtwoord_data);
        //returns true (if data got in database succesfullly) or
        //returns false (if the data didnt get into the database)
        return $pass_send;
    }
}