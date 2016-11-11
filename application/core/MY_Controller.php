<?php

class Front_Controller extends CI_Controller {

    protected $arr_userdb;
    protected $index_url;

    public function __construct() {
        parent::__construct();
        $this->access_check_model->double();
        $controller_file_name = strtolower(get_class($this));
        $this->index_url = site_url() . "$controller_file_name/index";
        $this->arr_userdb = $this->user_model->get_one($this->login_model->user_id());
    }

    protected function view_head($add_title = NULL) {
        $data["title"] = $this->config->item('webapp_title');
        if (empty($add_title) === FALSE) {
            $data["title"] = $this->config->item('webapp_title') . ' - ' . $add_title;
        }
        $this->load->view('head', $data);
    }

    protected function view_foot() {
        $this->load->view('foot');
    }

}

class User_Controller extends CI_Controller {

    protected $arr_userdb;
    protected $index_url;

    public function __construct() {
        parent::__construct();
        $this->access_check_model->double();
        $this->access_check_model->user();
        $this->load->switch_view_path("user");
        $controller_file_name = strtolower(get_class($this));
        $this->index_url = site_url() . "user/$controller_file_name/index";
        $this->arr_userdb = $this->user_model->get_one($this->login_model->user_id());
    }

    protected function view_head() {
        $data["title"] = $this->config->item('webapp_title');
        $data["webapp_title"] = $this->config->item('webapp_title');
        $this->load->view('head', $data);
    }

    protected function view_foot() {
        $this->load->view('foot');
    }

}

class Admin_Controller extends CI_Controller {

    protected $arr_userdb;
    protected $index_url;

    public function __construct() {
        parent::__construct();
        $this->access_check_model->double();
        $this->access_check_model->admin();
        $this->load->switch_view_path("admin");
        $controller_file_name = strtolower(get_class($this));
        $this->index_url = site_url() . "admin/$controller_file_name/index";
        $this->arr_userdb = $this->user_model->get_one($this->login_model->user_id());
    }

    protected function view_head() {
        $data["title"] = $this->config->item('webapp_title');
        $data["webapp_title"] = $this->config->item('webapp_title');
        $this->load->view('head', $data);
    }

    protected function view_foot() {
        $this->load->view('foot');
    }

}
