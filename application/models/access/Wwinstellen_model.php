<?php
//models only receive and retreive data away
class Wwinstellen_model extends CI_Model {
    //Here you store the password at the right user_id.
    public function store_password($wachtwoord_data, $user_id) {
        //where column user_id has value ($user_id["0"]) = user_id 10
        $this->db->where('user_id', $user_id["0"]);
        //update table user_login, column ($wachtwoord_data) password at user_id 10
        $pass_send = $this->db->update('user_login', $wachtwoord_data);
        //returns true (if data got in database succesfullly) or
        //returns false (if the data didnt get into the database)
        return $pass_send;
    }
    //Here you make the account active.
    public function active_login($user_id, $active) {
        //where column user_id has value ($user_id["0"]) = user_id 10
        $this->db->where('user_id', $user_id["0"]);
        //update table user, column ($active) is_active at user_id 10
        $result = $this->db->update('user', $active);
        //returns true (if data got in database succesfullly) or
        //returns false (if the data didnt get into the database)
        return $result;
    }
    //Here you select the group for the user
    public function group_user($user_id, $user_group) {
        //where column user_id has value ($user_id["0"]) = user_id 10
        $this->db->where('user_id', $user_id["0"]);
        //update table user, column ($user_group) group_id at user_id 10
        $result = $this->db->update('user', $user_group);
        //returns true (if data got in database succesfullly) or
        //returns false (if the data didnt get into the database)
        return $result;
    }
    public function get_firstname($id) {
        //select column firstname
        $this->db->select('firstname');
        //from table user
        $this->db->from('user');
        //where array ($id) = user_id => id of user
        $this->db->where($id);
        //if id exists in database get the value of column firstname
        //and put it in an array
        $query = $this->db->get();
        $result = $query->row_array();
        //returns array with firstname in it
        return $result;
    }
    //Check if account is active or not.
    public function get_active($user_id) {
        //select column is_active
        $this->db->select('is_active');
        //from table user, column ($user_id["0"] user_id = 10
        $this->db->from('user', $user_id["0"]);
        //get whole row of user_id 10 and put it in an array
        $query = $this->db->get();
        $result = $query->row_array();
        //return this array
        //it returns true(if data exists) or false(if data does NOT exist)
        return $result;
    }

}
