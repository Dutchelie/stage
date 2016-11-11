<?php

class Vergeten extends CI_Controller {

    public function index() {

        if ($this->input->post('emailaddress')) {

            $this->vergeten_action();
        }
        $data["title"] = "Vergeten?";
        $data["h3"] = "<strong>Maak</strong> een nieuw password.";
        $data["p"] = "Voer uw oude en daarna uw nieuwe password in.";
        $this->load->view("login/head", $data);
        $this->load->view("login/vergeten", $data);
        $this->load->view("login/foot");
    }

    public function vergeten_action() {

        $data_check = array(
            'username' => $this->input->post('emailaddress'),
        );

        $user_data = $this->vergeten_model->data_check($data_check);
        if ($user_data === FALSE) {
            echo 'email bestaat niet.';
        } else { 
            
            $this->load->library('email');

            $this->email->from('j.iedema@ddrive.org');
            $this->email->to('j.iedema@ddrive.org');
            //$this->email->cc('jorrit.iedema001@fclive.nl');
            $this->email->subject('Wachtwoord Herstellen');
            $this->email->message($this->load->view('admin/wwvergeten', TRUE));
            $this->email->set_mailtype('html');

            //$this->email->send();
            if ($this->email->send() === TRUE) {
                echo'er is een mail naar u toegestuurt';
            } else {
                echo'niks verstuurd';
            }
        }
    }

}
