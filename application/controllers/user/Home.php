<?php

class Home extends User_Controller {

    public function index() {
        $data["title"] = "Dashboard";
       
        $this->view_head();
        $this->load->view("home", $data);
        $this->view_foot();
    }
}
