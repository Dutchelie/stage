<?php
//models only receive and retreive data away
class Register_model extends CI_Model {
    //checks if email already exists in database.
    public function get_mail($user_email) {
        //from the table user
        $this->db->from('user');
        //where column emailaddress = (value) test@gmail.com
        $this->db->where('emailaddress', $user_email);
        //if the emailaddress test@gmail.com exists in the column emailaddress
        //retreive the whole row of that (value) test@gmail.com
        $query = $this->db->get();
        //put the data in a array
        $check_result = $query->row_array();
        //return this array
        //it returns true(if data exists) or false(if data does NOT exist)
        return $check_result;
    }
    //check if account is active
    public function is_active($user_id) {
        //selects the column is_active
        $this->db->select('is_active');
        //where column user_id is (user_id) 10
        $this->db->where('user_id', $user_id);
        //get column is_active of user_id 10
        $query = $this->db->get('user');
        //put the is_active value in an array
        $check_result = $query->row_array();
        //return this array
        //it returns true(if data exists) or false(if data does NOT exist)
        return $check_result;
    }
    //registers user for the first time
    public function register_data($account_data) {
        //insert into the table user, column ($account_data) firstname, lastname, emailaddress, birthday
        $this->db->insert('user', $account_data);
    }
    //updates users emailaddress when account isnt active
    public function update_data($account_data) {
        //where column emailaddress with (value) emailaddress
        $this->db->where('emailaddress', $account_data["emailaddress"]);
        //only updates emailaddress row when that emailaddress exists
        //update into the table user, column ($account_data) firstname, lastname, emailaddress, birthday
        $this->db->update('user', $account_data);
    }
    //get the id so it can we used in the controller
    public function get_id($user_email) {
        //from the table user
        $this->db->from('user');
        //where column emailaddress has an value ($user_email) test@gmail.com
        $this->db->where('emailaddress', $user_email);
        //when test@gmail.com exists in column emailaddress
        //get this row and put it into an array
        $query = $this->db->get();
        $result = $query->result_array();
        //specify you only want the id
        $id = $result[0]['user_id'];
        //returns this array
        //returns the id that was given to the registered user.
        return $id;
    }
    //get emailaddress from table user_login
    public function get_login_mail($user_email) {
        //from the table user_login
        $this->db->from('user_login');
        //where column username get the ($user_email) test@gmail.com
        $this->db->where('username', $user_email);
        //when test@gmail.com exists in column emailaddress
        //get this row and put it into an array
        $query = $this->db->get();
        $check_result = $query->row_array();
        //return this array
        //it returns true(if data exists) or false(if data does NOT exist)
        return $check_result;
    }
    //Updates the new user to the user_login tabel in the database.
    //so it can actually login when he made a password.
    public function update_login_data($user_login, $user_id) {
        //where column user_id has value (user_id) 10
        $this->db->where('user_id', $user_id);
        //update at table user_login, at columns ($user_login) user_id and username
        //in the table user_login the column username has email value's 
        $this->db->update('user_login', $user_login);
    }
    //inserts the new user into the login table user_login
    public function insert_login_data($user_login) {
        //insert into table user_login, columns ($user_login) user_id, username(emailaddress)
        $data_login = $this->db->insert('user_login', $user_login);
        //returns true (if data got in database succesfullly) or
        //returns false (if the data didnt get into the database)
        return $data_login;
    }
    
}
