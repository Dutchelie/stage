<?php

class Home extends User_Controller {

    public function index() {
        $data["title"] = "Dashboard";
//        var_dump($this->session->userdata('referred_from'));
//        exit;
        $this->view_head();
        $this->load->view("home", $data);
        $this->view_foot();
    }
}
