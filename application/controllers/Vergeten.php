<?php

class Vergeten extends CI_Controller {
    //first function loaded on page load
    public function index() {
        //if it is an ajax request (ajax call)
        if ($this->input->is_ajax_request()) {
            //go to check_input
            $this->check_input();
        }
        //loading view with all the data
        $data["title"] = "Vergeten?";
        $data["h3"] = "<strong>Maak</strong> een nieuw password.";
        $data["p"] = "Voer uw oude en daarna uw nieuwe password in.";
        $this->load->view("login/head", $data);
        $this->load->view("login/vergeten", $data);
        $this->load->view("login/foot");
    }
    //checks the input from emailaddress
    private function check_input() {
        //checking if emailaddress has a value
        if ($this->input->post('emailaddress')) {
            //go to user_defice if emailaddress has an value
            $this->user_device();
        }
        //if the value of emailaddress is missing
        $msg = array(
            'response' => 'Vul alle velden in alstublieft.',
        );

        exit(json_encode($msg));
    }
    //checking what program and platform the user uses
    private function user_device() {
        //loading the agent library
        $this->load->library('user_agent');
        //getting the browser and the platform
        //for example Chrome Windows
        if ($this->agent->is_browser()) {
            $agent = $this->agent->browser() . ' ' . $this->agent->platform();
        } elseif ($this->agent->is_robot()) {
            $agent = $this->agent->robot() . ' ' . $this->agent->platform();
        } elseif ($this->agent->is_mobile()) {
            $agent = $this->agent->mobile() . ' ' . $this->agent->platform();
        } else {
            //if no program or platform is detected
            $msg = array(
                'response' => 'Unidentified User Agent.',
            );

            exit(json_encode($msg));
        }
        //make session of agent output
        $this->session->set_userdata('device', $agent);
        //if a program or platform is there go to data_get
        $this->data_get($agent);
    }
    //see if emailaddress exists
    public function data_get($agent) {
        //get email from form en put it in a array under the key "username"
        $user_email = array(
            'username' => $this->input->post('emailaddress'),
        );
        //check if the email exists and get the user_id of that email
        $user_id = $this->vergeten_model->data_get($user_email);
        //if user_id is empty
        if (empty($user_id) === TRUE) {
            //tell user the email doesnt exist
            $msg = array(
                'response' => 'Uw Email bestaat niet.',
            );

            exit(json_encode($msg));
        }
        //here is another client sided code that we are gonna use for security reasons and protection
        $user_info = $user_id . '_' . $user_email["username"] . '_' . $agent;
        //put the encrypted client sided code in $encryptcode
        $data["encryptcode"] = rawurlencode($this->encryption->encrypt($user_info));
        $this->session->set_userdata($data);
        //go to vergeten_action
        $this->vergeten_action();
    }
    //here you send the mail where the user can make a new password
    private function vergeten_action() {
        //get the emailaddress from the form and put into an array
        $mail = array('emailaddress' => $this->input->post('emailaddress'));
        //get the name from the database so you can put in into the mail
        $firstname = $this->vergeten_model->get_name($mail);
        $data["h4"] = $firstname;
        //making the mail that will be send to the user
        $this->load->library('email');
        $this->email->from('j.iedema@ddrive.org');
        $this->email->to($mail['emailaddress']);
        //$this->email->cc('jorrit.iedema001@fclive.nl');
        $this->email->subject('Wachtwoord maken.');
        $this->email->message($this->load->view('admin/wwvergeten', $data, TRUE));
        $this->email->set_mailtype('html');

        //if the email isnt send
        if ($this->email->send() === FALSE) {
            //tell the user no email has been send
            $msg = array(
                'response' => 'Niks verstuurd.',
            );

            exit(json_encode($msg));
        }
        //make a timer so you can check when the link is expired in the wachtwoord controlller
        $this->session->set_tempdata('timer', 300);//300 seconds = 5 minutes
        //2de manier om mail te testen.
        //add_app_log($this->load->view('admin/wwvergeten', $data, TRUE));
        //tell the user an email has been sent to their mail
        $msg = array(
            'response' => 'Er is een mail naar u toegestuurd.',
        );

        exit(json_encode($msg));
    }

}
