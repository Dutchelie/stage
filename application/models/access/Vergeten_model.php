<?php
//models only receive and retreive data away
class Vergeten_model extends CI_Model {
    //checks if email already exists in database.
    public function data_get($user_email) {
        //from table user_login
        $this->db->from('user_login');
        //where array $user_email = username => (emailaddress) test@gmail.com
        $this->db->where($user_email);
        //if the emailaddress test@gmail.com exists in the column emailaddress
        //retreive the whole row of that (value) test@gmail.com and make an array of it
        $query = $this->db->get();
        $id = $query->row_array();
        //only send the user_id of the array to the controller
        return $id["user_id"];
    }
    //get the users name for the email
    public function get_name ($mail) {
        //from the table user
        $this->db->from('user');
        //where array $mail = emailaddres => (emailaddress) test@gmail.com
        $this->db->where($mail);
        //if the emailaddress test@gmail.com exists in the column emailaddress
        //retreive the whole row of that (value) test@gmail.com and make an array of it
        $query = $this->db->get();
        $firstname = $query->row_array();
        //only send the firstname of the array to the controller
        return $firstname["firstname"];
    }
}
