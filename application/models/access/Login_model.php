<?php

class Login_model extends CI_Model {

    private $table = "user_login";
    public $login_user_data = array();

    public function user_id() {
        $session_data = $this->session->userdata($this->table);
        if (empty($session_data) === FALSE) {
            return $session_data["uid"];
        }
        return 0;
    }

    public function group_id() {
        $session_data = $this->session->userdata($this->table);
        if (empty($session_data) === FALSE) {
            return $session_data["group_id"];
        }
        return 0;
    }

    public function check_double_login() {
        $user_id = $this->user_id();
        $arr_ck = $this->get_logindata($user_id);
        if (empty($arr_ck["ip_address"]) === FALSE && empty($arr_ck["browser"]) === FALSE && empty($arr_ck["platform"]) === FALSE) {
            $user_data = $arr_ck["ip_address"] . $arr_ck["browser"] . $arr_ck["platform"];
            $check_data = $this->input->ip_address() . $this->agent->browser() . $this->agent->platform();
            if ($user_data === $check_data) {
                return FALSE;
            } else {
                return TRUE;
            }
        }

        return FALSE;
    }

    private function get_logindata($user_id) {
        if ($user_id <= 0) {
            return array();
        }
        $query = $this->db->from($this->table)->where('user_id', $user_id)->limit(1)->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return array();
        }
    }

    public function get_one($username, $password) {
        $query = $this->db->from($this->table)
                ->join("user", "user_id")
                ->where("(user.emailaddress = '$username' OR {$this->table}.username = '$username')")
                ->where("user.is_active", 1)
                ->where("user.is_del", 0)
                ->where("{$this->table}.password", md5($password))
                ->limit(1)
                ->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return array();
        }
    }

    public function get_one_by_username_email($username) {
        $query = $this->db->from($this->table)
                ->join("user", "user_id")
                ->where("(user.emailaddress = '$username' OR {$this->table}.username = '$username')")
                ->limit(1)
                ->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return array();
        }
    }

    public function check_data($username, $wachtwoord) {
        $arr_rs = $this->get_one($username, $wachtwoord);
        if (empty($arr_rs) === TRUE || $arr_rs['is_active'] == 0) {
            return FALSE;
        }
        $this->login_user_data = $arr_rs;
        return TRUE;
    }

    private function update_data($user_id) {
        if ($user_id <= 0) {
            return;
        }
        $data["ip_address"] = $this->input->ip_address();
        $data["browser"] = $this->agent->browser();
        $data["platform"] = $this->agent->platform();
        $this->edit($user_id, $data);
    }

    public function logout() {
        if ($this->user_id() <= 0) {
            return;
        }
        add_app_log($this->user_id(). " is uitgelogd");
        $this->session->unset_userdata($this->table);
    }

    public function add($data) {
        $this->db->insert($this->table, $data);
    }

    public function edit($uid, $data) {
        $this->db->where('user_id', $uid)->update($this->table, $data);
    }

    public function check_username($username) {
        $query = $this->db->select('username')->from($this->table)->where('username', $username)->limit(1)->get();
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function add_user_session() {
        $arr_rs = $this->login_user_data;
        if (empty($arr_rs) === TRUE) {
            return;
        }
        $sess_array = array(
            'uid' => $arr_rs['user_id'],
            'group_id' => $arr_rs['group_id']
        );
        $this->session->set_userdata($this->table, $sess_array);
        $this->update_data($arr_rs['user_id']);
        add_app_log($arr_rs['username']." is ingelogd");
    }
}
