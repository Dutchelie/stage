<?php

class Applog extends Admin_Controller {

    public function index() {
        $reportrange = $this->input->post("reportrange");
        $search_description = $this->input->post("search_description");
        $user_name = $this->input->post("user_name");

        $data_where = array();
        $data_like = array();

        if (empty($search_description) === FALSE) {
            $data_like["description"] = $search_description;
        }

        if (empty($user_name) === FALSE) {
            $data_like["user.firstname"] = $user_name;
            $data_like["user.lastname"] = $user_name;
        }

        if (empty($reportrange) === FALSE) {
            $arr_range = explode("t/m", $reportrange);
            $data_where["date >="] = date_format(date_create(trim($arr_range[0])), 'Y-m-d H:i:s');
            $data_where["date <="] = date_format(date_create(trim($arr_range[1])), 'Y-m-d 23:59:59');
        }

        $total = $this->app_log_model->get_list($data_where, $data_like);
        $limit = $this->config->item('webapp_default_show_per_page');
        $page = ($this->input->get("page_number") == NULL) ? 0 : ($this->input->get("page_number") * $limit) - $limit;
        $data["listdb"] = $this->get_list($data_where, $data_like, $limit, $page);
        $data["pagination"] = show_page($this->index_url, $total);
        $data["total"] = $total;
        $data["title"] = "Applog overzicht";
        $data["result"] = $this->load->view('applog/ajax_list', $data, TRUE);
        if ($this->input->post("do_ajax") == 1) {
            exit(json_encode($data));
        }

        $this->view_head();
        $this->load->view('applog/list', $data);
        $this->view_foot();
    }

    private function get_list($data_where, $data_like, $limit, $page) {
        $arr_result = array();
        foreach ($this->app_log_model->get_list($data_where, $data_like, $limit, $page) as $rs) {
            $rs["user_name"] = $this->user_model->get_name($rs["user_id"]);
            $rs["date"] = date_format(date_create($rs["date"]), 'd-m-Y H:i:s');
            $rs["del_link"] = site_url("admin/applog/del");
            $arr_result[] = $rs;
        }

        return $arr_result;
    }

    public function del() {
        $id = $this->input->post("del_id");

        $rsdb = $this->app_log_model->get_one($id);
        if (empty($rsdb) === TRUE) {
            $json["msg"] = "Deze kan niet worden verwijdeerd!";
            $json["status"] = "error";
            exit(json_encode($json));
        }
        $this->app_log_model->del($id);
        $json["msg"] = "Applog is verwijdeerd!";
        $json["status"] = "good";
        add_app_log($json["msg"]);
        exit(json_encode($json));
    }

}
