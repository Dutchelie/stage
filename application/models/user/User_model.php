<?php

class User_model extends CI_Model {

    private $table = "user";

    public function radio_active_status($is_active = 0, $disabled = FALSE) {
        $arr_type = array(0 => "Inactive", 1 => "Active");
        $select = "";
        foreach ($arr_type as $key => $value) {
            $ckk = $is_active == $key ? ' checked ' : '';
            $ck_disabled = $disabled === TRUE ? ' disabled ' : '';
            $select.="<div class='radio'><input type='radio' id='is_active_$key' value='$key' name='is_active' $ckk $ck_disabled><label for='is_active_$key'>$value</label></div>";
        }
        return $select;
    }

    public function add($data) {
        $this->db->insert($this->table, $data);
        mkdir('./uploads/userfiles/' . $this->db->insert_id(), 0777, TRUE);
        return $this->db->insert_id();
    }

    public function edit($uid, $data) {
        $this->db->where('user_id', $uid)->update($this->table, $data);
    }

    public function get_list($data_where = array(), $data_like = array(), $limit = NULL, $start = NULL) {
        $this->db->from($this->table);
        $this->db->join('user_login', 'user_id');
        
        $this->db->where("{$this->table}.is_del", 0);

        foreach ($data_where as $field => $value) {
            $this->db->where($field, $value);
        }
        foreach ($data_like as $field => $value) {
            $this->db->like($field, $value);
        }

        if (empty($limit) === FALSE) {
            $this->db->order_by("{$this->table}.user_id", "desc");
            $this->db->limit($limit, $start);
            $query = $this->db->get();
            return $query->result_array();
        }
        $query = $this->db->get();
        return count($query->result());
    }

    public function check_emailaddress($emailaddress) {

        $query = $this->db->select('emailaddress')->from($this->table)->where('emailaddress', $emailaddress)->limit(1)->get();
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function get_one($uid) {
        $this->db->from($this->table);
        $this->db->join('user_login', "user_id");
        $this->db->where("{$this->table}.is_del", 0);
        $this->db->where("{$this->table}.user_id", $uid);
        $query = $this->db->limit(1)->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return array();
        }
    }

    public function get_name($uid = 0) {
        $arr_user = $this->get_one($uid);
        if (empty($arr_user) === TRUE) {
            return "Systeem";
        }
        return $arr_user["firstname"] . " " . $arr_user["lastname"];
    }

    public function get_all($data_where = array(), $data_like = array()) {
        $this->db->from($this->table);
        $this->db->join('user_login', "user_login.user_id = {$this->table}.user_id");
        $this->db->where("{$this->table}.is_del", 0);

        foreach ($data_where as $field => $value) {
            $this->db->where($field, $value);
        }
        foreach ($data_like as $field => $value) {
            $this->db->like($field, $value);
        }

        $this->db->order_by("{$this->table}.user_id", "desc");
        $query = $this->db->get();
        return $query->result_array();
    }
}
