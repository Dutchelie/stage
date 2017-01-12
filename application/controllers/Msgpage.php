<?php
//this view is a message page meant for the user
class Msgpage extends CI_Controller {
    //first function loaded on page load
    public function index() {
        //load the view
        $data["title"] = "Account.";
        $data["h3"] = "U kunt nu <strong>inloggen</strong> met uw account.";
        //$data["p"] = "test";
        $this->load->view("login/head", $data);
        $this->load->view("login/msgpage", $data);
        $this->load->view("login/foot");
    }
    
}