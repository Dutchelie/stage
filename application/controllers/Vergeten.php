<?php

class Vergeten extends CI_Controller {

    public function index() {

        if ($this->input->is_ajax_request()) {
            $this->check_input();
//            $msg = array(
//                'response' => 'test.',
//            );
//
//            exit(json_encode($msg));
        }
        $data["title"] = "Vergeten?";
        $data["h3"] = "<strong>Maak</strong> een nieuw password.";
        $data["p"] = "Voer uw oude en daarna uw nieuwe password in.";
        $this->load->view("login/head", $data);
        $this->load->view("login/vergeten", $data);
        $this->load->view("login/foot");
    }

    private function check_input() {
        if ($this->input->post('emailaddress')) {
            $this->data_get();
//            $msg = array(
//                'response' => 'test.',
//            );
//
//            exit(json_encode($msg));
        }
        $msg = array(
            'response' => 'Vul alle velden in alstublieft.',
        );

        exit(json_encode($msg));
    }

    private function data_get() {
        $user_email = array(
            'username' => $this->input->post('emailaddress'),
        );
        $user_id = $this->vergeten_model->data_get($user_email);

        if (empty($user_id) === TRUE) {
            $msg = array(
                'response' => 'Uw Email bestaat niet.',
            );

            exit(json_encode($msg));
        }
//        $msg = array(
//            'response' => $user_id,
//        ); 
//
//        exit(json_encode($msg));

        $user_info = $user_id . '_' . $user_email["username"];
//        $msg = array(
//            'response' => $user_info,
//        );
//
//        exit(json_encode($msg));
        //$data["h4"] = $firstname;
        $encryptkey = $this->encryption->encrypt($user_info);
        $data ["encryptcode"] = rawurlencode($encryptkey);

        $this->vergeten_action($data);
    }

    private function vergeten_action($data) {
        $this->load->library('email');

        $this->email->from('j.iedema@ddrive.org');
        $this->email->to('j.iedema@ddrive.org');
        //$this->email->cc('jorrit.iedema001@fclive.nl');
        $this->email->subject('Wachtwoord Herstellen');
        $this->email->message($this->load->view('admin/wwvergeten', $data, TRUE));
        $this->email->set_mailtype('html');

        if ($this->email->send() === FALSE) {
            $msg = array(
                'response' => 'niks verstuurd.',
            );

            exit(json_encode($msg));
        }
        $msg = array(
            'response' => 'er is een mail naar u toegestuurd.',
        );

        exit(json_encode($msg));
    }

}
