<?php

class User_gender_model extends CI_Model {

    private $table = "user_gender";

    public function select_gender($gender_id = NULL) {
        $select = '<select name="gender_id" class="form-control selectpicker">';
        foreach ($this->get_all() as $rs) {
            $ckk = $gender_id == $rs["gender_id"] ? "selected" : '';
            $select.="<option value={$rs["gender_id"]} $ckk >{$rs["name"]}</option>";
        }
        $select.='</select>';
        return $select;
    }

    public function get_all() {
        $query = $this->db->from($this->table)->order_by("gender_id", "asc")->get();
        return $query->result_array();
    }

    public function get_one($id = 0) {
        if ($id <= 0) {
            return;
        }
        $query = $this->db->from($this->table)->where('gender_id', $id)->limit(1)->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return array();
        }
    }

    public function fetch_gender($value = NULL) {
        switch ($value) {
            case 'male':
                return 3;
            case 'female':
                return 2;
            default:
                return 1;
        }
    }

    public function fetch_href($id = 0) {
        if ($id <= 0) {
            return;
        }
        $arr = $this->get_one($id);
        return $arr["href"];
    }
    
    public function fetch_name($id = 0) {
        if ($id <= 0) {
            return;
        }
        $arr = $this->get_one($id);
        return $arr["name"];
    }

}
