<?php

class App_log_model extends CI_Model {

    private $table = "app_log";

    public function get_list($data_where = array(), $data_like = array(), $limit = NULL, $start = NULL) {
        $this->db->from($this->table);
        $this->db->join('user', 'user_id');
        foreach ($data_where as $field => $value) {
            $this->db->where($field, $value);
        }
        foreach ($data_like as $field => $value) {
            $this->db->like($field, $value);
            $this->db->or_like($field, $value);
        }
        if (empty($limit) === FALSE) {
            $this->db->order_by("log_id", "desc");
            $this->db->limit($limit, $start);
            $query = $this->db->get();
            return $query->result_array();
        }
        return $this->db->count_all_results();
    }

    public function get_one($id) {
        if ($id <= 0) {
            return;
        }
        $query = $this->db->from($this->table)->where('log_id', $id)->limit(1)->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    public function add($description, $uid = 0) {
        if (empty($description) === TRUE) {
            return;
        }
        $data["description"] = $description;
        if ($uid > 0) {
            $data["user_id"] = $uid;
        } else {
            $data["user_id"] = $this->login_model->user_id();
        }
        $data["path"] = uri_string();
        $this->db->insert($this->table, $data);
    }

    public function del($id) {
        if ($id <= 0) {
            return;
        }
        $this->db->from($this->table)->where('log_id', $id)->limit(1)->delete();
    }
}
