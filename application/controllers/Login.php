<?php

class Login extends CI_Controller {

    //De functie index is standaard bij elke page. Login of registereren maakt niet uit deze function zit erbij.
    //Hierdoor komt het ook dat $data zonder iets te doen naar login.php word gestuurd.
    public function index() {
        if ($this->login_model->group_id() > 0) {
            redirect($this->access_check_model->redirect_url());
        }

        if ($this->input->post('username') && $this->input->post('password')) {
            $this->login_action();
        }

        $data["title"] = "Welkom bij login";
        $data["h3"] = "<strong>Inloggen</strong> met uw gegevens";
        $data["p"] = "Voer uw gebruikersnaam en wachtwoord in:";
        $this->load->view("login/head", $data);
        $this->load->view("login/login", $data);
        $this->load->view("login/foot");
    }

    private function login_action() {
        $username = $this->input->post("username");
        $password = $this->input->post("password");

        $json = array();

        if ($this->login_model->check_data($username, $password) === TRUE) {
            $this->login_model->add_user_session();
            redirect($this->access_check_model->redirect_url());
        }
        redirect(site_url("login"));
    }

    public function logout() {
        $this->session->unset_userdata('referred_from');
        $this->login_model->logout();
        redirect(site_url());
    }

}
