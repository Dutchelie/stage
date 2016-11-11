<?php

class Register extends CI_Controller {

    public function index() {

        if ($this->input->post('firstname') && $this->input->post('lastname') && $this->input->post('emailaddress') && $this->input->post('birthday')) {
            $this->captcha_check();
        }

        $data["title"] = "Registreren";
        $data["h3"] = "<strong>Maken</strong> van uw gegevens";
        $data["p"] = "Voer uw persoonlijkegegevens in:";
        $data["login_url"] = site_url("login");
        $data["select_gender"] = $this->user_gender_model->select_gender();
        $this->load->view("login/head", $data);
        $this->load->view("login/register", $data);
        $this->load->view("login/foot");

//            $msg = 'twitter api';
//            $this->twitter->update($msg);
//            exit;
    }

    private function captcha_check() {
        if ($this->input->is_ajax_request()) {

            $url = "https://www.google.com/recaptcha/api/siteverify?";
            $secret = "6Lfp_AoUAAAAAOevj1eBx09wFMpllED1yAa4op60";
            $params = array(
                //'url' => $url,
                'secret' => $secret,
                'response' => $this->input->post('g-recaptcha-response')
            );

            $response = get_curl($url, $params);
            $result = json_decode($response);
            //var_dump($result->success);exit();
            if ($result->success === FALSE) {
                $msg = array(
                    'response' => 'Vink het onderste vakje aan alstublieft.',
                );

                exit(json_encode($msg));
            }
            $this->terms_check();
//            $msg = array(
//                'response' => 'captcha goed.',
//            );
//
//            exit(json_encode($msg));
        } else {
            show_error("No direct access allowed.");
        }
    }

    private function terms_check() {
        if (($this->input->post('terms') == "off")) {

//
            $msg = array(
                'response' => 'Accepteer de algemene voorwaarden alstublieft.',
            );

            exit(json_encode($msg));
        }


        $this->firstname_check();
    }

    private function firstname_check() {
        $firstname = strlen($this->input->post('firstname'));
        $minfn = 2;
        $maxfn = 20;

        if ($firstname >= $minfn && $firstname <= $maxfn) {
//            $msg = array(
//                'response' => 'Voornaam is te kort of te lang.',
//            );
//
//            exit(json_encode($msg));
            $this->lastname_check();
        } else {
            $msg = array(
                'response' => 'Voornaam is te kort of te lang.',
            );

            exit(json_encode($msg));
        }
        //$this->lastname_check();
    }

    private function lastname_check() {
        $lastname = strlen($this->input->post('lastname'));
        $minln = 1;
        $maxln = 60;

        if ($lastname >= $minln && $lastname <= $maxln) {
            $msg = array(
                'response' => 'Achternaam is te kort of te lang.',
            );

            exit(json_encode($msg));
        }
        $this->email_valid();
    }

    private function email_valid() {
        $email = $this->input->post('emailaddress');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) === TRUE) {
            $msg = array(
                'response' => 'email is not valid.',
            );

            exit(json_encode($msg));
        }
        if (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $email)) {
            $this->age_check();
        } else {
            $msg = array(
                'response' => 'email is niet correct.',
            );

            exit(json_encode($msg));
        }
    }

    private function age_check() {

        $bday = strtotime($this->input->post('birthday'));
        $minage = strtotime('+13 years', $bday);

        if (time() < $minage) {
            $msg = array(
                'response' => 'Je moet ouder dan 13 jaar zijn.',
            );

            exit(json_encode($msg));
        }

        //exit("ouder dan 13 jaar.");
        $this->register_action();
    }

    private function register_action() {

        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');

        $user_email = $this->input->post('emailaddress');
        $birthday = $this->input->post('birthday');

        $register_data = array(
            'emailaddress' => $user_email,
        );

        $account_data = array(
            'firstname' => $firstname,
            'lastname' => $lastname,
            'emailaddress' => $user_email,
            'birthday' => $birthday,
        );

        $arr_userdata = $this->register_model->get_data($register_data);
        if (empty($arr_userdata) === FALSE) {
            $msg = array(
                'response' => 'email is al bezet.',
            );

            exit(json_encode($msg));
        }

        $user_id = $this->register_model->register_data($account_data);
        if ($user_id < 0) {
            $msg = array(
                'response' => 'ID kan niet 0 zijn.',
            );

            exit(json_encode($msg));
        }
        //exit('ID is groter dan 0');
        $this->login_data_action($user_id);
    }

    private function login_data_action($user_id) {
        $user_email = $this->input->post('emailaddress');

        //$user_id = $this->session->userdata('user_id');
        $send_userdata = $this->register_model->send_login_data($user_id, $user_email);
        if ($send_userdata === FALSE) {
            $msg = array(
                'response' => 'data niet in database.',
            );

            exit(json_encode($msg));
        }
        //exit('data in database');
        $this->send_mail($user_id);
    }

    private function send_mail($user_id) {

        $user_email = $this->input->post('emailaddress');

        $user_info = $user_id . '_' . $user_email;

        $firstname = $this->input->post('firstname');
        $data["h4"] = $firstname;
        $encryptkey = $this->encryption->encrypt($user_info);
        $data ["encryptcode"] = rawurlencode($encryptkey);

//        echo $encryptkey;
//        echo '<br>';
//        echo serialize($data);
//        exit;

        $this->load->library('email');

        $this->email->from('j.iedema@ddrive.org');
        $this->email->to('j.iedema@ddrive.org');
        //$this->email->cc('jorrit.iedema001@fclive.nl');
        $this->email->subject('Wachtwoord maken.');
        $this->email->message($this->load->view('admin/emailview', $data, TRUE));
        $this->email->set_mailtype('html');

        //$this->email->send();
        if ($this->email->send() === FALSE) {
            $msg = array(
                'response' => 'Niks verstuurd.',
            );

            exit(json_encode($msg));
        }
        //echo $this->email->print_debugger();
        $msg = array(
            'response' => 'Er is een mail naar u toegestuurd.',
        );

        exit(json_encode($msg));
    }

}
