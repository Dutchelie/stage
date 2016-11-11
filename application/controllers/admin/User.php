<?php

class User extends Admin_Controller {

    public function profile() {
        $this->edit($this->arr_userdb["user_id"]);
    }

    public function index() {
        $group_id = $this->input->get_post("group_id");
      
        $search_email = $this->input->post("search_email");
        $search_firstname = $this->input->post("search_firstname");
        $search_lastname = $this->input->post("search_lastname");

        $data_where = array();
        $data_like = array();

        if (empty($search_email) === FALSE) {
            $data_like["emailaddress"] = $search_email;
        }

        if (empty($search_firstname) === FALSE) {
            $data_like["firstname"] = $search_firstname;
        }

        if (empty($search_lastname) === FALSE) {
            $data_like["lastname"] = $search_lastname;
        }

        if (empty($group_id) === FALSE) {
            $data_where["group_id"] = $group_id;
        }

        $data["select_group"] = $this->user_group_model->select_group($group_id);
        $total = $this->user_model->get_list($data_where, $data_like);
        $limit = $this->config->item('webapp_default_show_per_page');
        $page = ($this->input->get("page_number") == NULL) ? 0 : ($this->input->get("page_number") * $limit) - $limit;
        $data["listdb"] = $this->get_list($data_where, $data_like, $limit, $page);
        $data["pagination"] = show_page($this->index_url, $total);
        $data["total"] = $total;
        $data["title"] = "Gebruiker overzicht";
        $data["add_link_admin"] = site_url('admin/user/add/1');
        $data["add_link_user"] = site_url('admin/user/add/2');
        $data["result"] = $this->load->view('user/ajax_list', $data, TRUE);

        if ($this->input->post("do_ajax") == 1) {
            exit(json_encode($data));
        }

        $this->view_head();
        $this->load->view('user/list', $data);
        $this->view_foot();
    }

    private function get_list($data_where, $data_like, $limit, $page) {
        $arr_result = array();
        foreach ($this->user_model->get_list($data_where, $data_like, $limit, $page) as $rs) {
            $arr_group = $this->user_group_model->get_one($rs["group_id"]);
            $rs["group_name"] = $arr_group["name"];
            $rs["birthday"] = date_format(date_create($rs["birthday"]), 'd-m-Y');
            $rs["edit_link"] = site_url() . "admin/user/edit/{$rs["user_id"]}";
            $rs["del_link"] = site_url("admin/user/del");
            $arr_result[] = $rs;
        }

        return $arr_result;
    }

    public function del() {
        $id = $this->input->post("del_id");

        $rsdb = $this->user_model->get_one($id);
        if (empty($rsdb) === TRUE || $id == 1 || $id == $this->arr_userdb["user_id"]) {
            $json["msg"] = "Deze kan niet worden verwijdeerd!";
            $json["status"] = "error";
            exit(json_encode($json));
        }

        $data["modifiedby"] = $this->arr_userdb["user_id"];
        $data["is_del"] = 1;
        $this->user_model->edit($id, $data);
        $json["msg"] = "Gebruiker is verwijdeerd!";
        $json["status"] = "good";
        add_app_log($json["msg"]);
        exit(json_encode($json));
    }

    public function add($group_id = 0) {
        if ($this->input->post("emailaddress")) {
            $this->add_action();
        }
       
        $arr_group = $this->user_group_model->get_one($group_id);
        if (empty($arr_group) === TRUE) {
            redirect($this->index_url);
        }
        
        $data["title"] = "Nieuwe gebruiker - " . $arr_group["name"];
        $data["group_id"] = $arr_group["group_id"];
        $data['rsdb'] = NULL;
        $data["radio_active_status"] = $this->user_model->radio_active_status(0, TRUE);
        $data["select_gender"] = $this->user_gender_model->select_gender();
        $data["select_group"] = $this->user_group_model->select_group($data["group_id"]);
       
        $this->view_head();
        $this->load->view('user/edit', $data);
        $this->view_foot();
    }

    private function add_action() {
        $data_login["username"] = strtolower($this->input->post("username"));
        $data_login["password"] = $this->input->post("password");

        $data = $this->get_postdata();
        $data["is_active"] = 0;
        $data["createdby"] = $this->arr_userdb["user_id"];
        $data["birthday"] = date_format(date_create($data["birthday"]), 'Y-m-d');

        $check_email = $this->user_model->check_emailaddress($data["emailaddress"]);
        $check_username = $this->login_model->check_username($data_login["username"]);
        if ($check_username === TRUE) {
            $json["msg"] = "Het gebruikersnaam bestaat al!";
            $json["status"] = "error";
            exit(json_encode($json));
        }

        if (empty($data_login["username"]) === FALSE && $check_email === TRUE) {
            $json["msg"] = "Het emailadres bestaat al!";
            $json["status"] = "error";
            exit(json_encode($json));
        }

        $uid = $this->user_model->add($data);
        if ($uid > 0) {
            $data_login["user_id"] = $uid;
            $data_login["password"] = md5($data_login["password"]);
            $this->login_model->add($data_login);
            $json["type_done"] = "redirect";
            $json["redirect_url"] = site_url() . "admin/user/edit/$uid";
            $json["msg"] = "Nieuw gebruiker aangemaakt";
            $json["status"] = "good";
            add_app_log($json["msg"]);
            exit(json_encode($json));
        }
    }

    private function get_postdata() {
        $data["firstname"] = $this->input->post("firstname");
        $data["prefix"] = $this->input->post("prefix");
        $data["lastname"] = $this->input->post("lastname");
        $data["housenr"] = $this->input->post("housenr");
        $data["housenr_addition"] = $this->input->post("housenr_addition");
        $data["zipcode"] = strtoupper($this->input->post("zipcode"));
        $data["phone"] = $this->input->post("phone");
        $data["cellphone"] = $this->input->post("cellphone");
        $data["emailaddress"] = strtolower($this->input->post("emailaddress"));
        $data["is_active"] = $this->input->post("is_active");
        $data["birthday"] = $this->input->post("birthday");
        $data["group_id"] = $this->input->post("group_id");
        $data["gender_id"] = $this->input->post("gender_id");
        $this->ajaxck_model->ck_value('firstname', $data["firstname"], "Voornaam is leeg!");
        $this->ajaxck_model->ck_value('lastname', $data["lastname"], "Achternaam is leeg!");
        $this->ajaxck_model->ck_value('date', $data["birthday"], "Het geboortedaum klopt niet!");
        $this->ajaxck_model->ck_value('housenr', $data["housenr"], "Het huisnummer is niet juist!");
        $this->ajaxck_model->ck_value('zipcode', $data["zipcode"], "Het postcode klopt niet!");
        $this->ajaxck_model->ck_value('email', $data["emailaddress"], "Het emailadres is niet juist!");
        $this->ajaxck_model->ck_value('group_id', $data["group_id"], "Geen group_id gekozen!");
        return $data;
    }

    public function edit($id) {
        if ($this->input->post("emailaddress")) {
            $this->edit_action();
        }

        $data["rsdb"] = $this->user_model->get_one($id);
        $data["title"] = "Gebruiker wijzigen";
        if (empty($data['rsdb']) === TRUE) {
            redirect($this->index_url);
        }

        $arr_group = $this->user_group_model->get_one($data['rsdb']["group_id"]);
        $data["title"] = $arr_group["name"] . " wijzigen";
        $data["group_id"] = $arr_group["group_id"];
        $data["rsdb"]["birthday"] = date_format(date_create($data["rsdb"]["birthday"]), 'd-m-Y');
        $data["select_gender"] = $this->user_gender_model->select_gender($data['rsdb']["gender_id"]);
        $data["radio_active_status"] = $this->user_model->radio_active_status($data['rsdb']["is_active"]);
        $data["select_group"] = $this->user_group_model->select_group($data["group_id"]);


       
        $this->view_head();
        $this->load->view('user/edit', $data);
        $this->view_foot();
    }

    private function edit_action() {
        $uid = $this->input->post("user_id");
        $data_login["username"] = strtolower($this->input->post("username"));
        $data_login["password"] = $this->input->post("password");

        $data = $this->get_postdata();
        $data["modifiedby"] = $this->arr_userdb["user_id"];
     
        if (empty($data["cellphone"]) === FALSE || empty($data["phone"]) === FALSE) {
            $this->ajaxck_model->ck_value('phone', $data["cellphone"], "Het telefoonnummer klopt niet!");
        }

        $data["birthday"] = date_format(date_create($data["birthday"]), 'Y-m-d');
        $check_email = $this->user_model->check_emailaddress($data["emailaddress"]);
        $check_username = $this->login_model->check_username($data_login["username"]);
        $rsdb = $this->user_model->get_one($uid);

        if (empty($data_login["username"]) === FALSE && ($data_login["username"] !== $rsdb["username"]) && $check_username === TRUE) {
            $json["msg"] = "Het gebruikersnaam bestaat al!";
            $json["status"] = "error";
            exit(json_encode($json));
        }

        if (($data["emailaddress"] !== $rsdb["emailaddress"]) && $check_email === TRUE) {
            $json["msg"] = "Het emailadres bestaat al!";
            $json["status"] = "error";
            exit(json_encode($json));
        }

        if (empty($data_login["password"]) === FALSE) {
            $data_login["password"] = md5($data_login["password"]);
            $this->login_model->edit($uid, $data_login);
        }

        if (empty($rsdb) === FALSE) {
            $this->user_model->edit($uid, $data);
            $json["msg"] = "Gebruiker is bijgewerkt! " . anchor($this->index_url, 'Terug naar overzicht');
            $json["status"] = "good";
            add_app_log("Gebruiker is bijgewerkt! ");
            exit(json_encode($json));
        }
    }

}
