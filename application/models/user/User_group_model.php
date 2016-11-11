<?php

class User_group_model extends CI_Model {

    private $table = "user_group";
    
    public function select_group($group_id = NULL) {
        $select = '<select name="group_id" class="form-control selectpicker">';
        $select.="<option value='' >------</option>";
        foreach ($this->get_all() as $rs) {
            $ckk = $group_id == $rs["group_id"] ? "selected" : '';
            $select.="<option value={$rs["group_id"]} $ckk >{$rs["name"]}</option>";
        }
        $select.='</select>';
        return $select;
    }
    
    public function add($data) {
        $this->db->insert($this->table, $data);
    }
    
    public function get_all() {
        $query = $this->db->from($this->table)->order_by("group_id", "desc")->get();
        return $query->result_array();
    }

    public function edit($id, $data) {
        $this->db->where('group_id', $id)->update($this->table, $data);
    }

    public function get_one($id) {
        if ($id <= 0) {
            return;
        }
        $query = $this->db->from($this->table)->where('group_id', $id)->limit(1)->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return array();
        }
    }
    
}
