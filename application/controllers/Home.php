<?php

class Home extends Front_Controller {

    public function index() {
        $data["title"] = "Home";
        $this->view_head($data["title"]);
        $this->load->view("home", $data);
        $this->view_foot();
    }

}
