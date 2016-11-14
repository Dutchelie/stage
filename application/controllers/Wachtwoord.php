<?php

class Wachtwoord extends CI_Controller {

    public function index() {

        if ($this->input->is_ajax_request()) {
            $this->equal_password();
        }

        $data["title"] = "Wachtwoord";
        $data["h3"] = "<strong>Maken</strong> van uw wachtwoord";
        $data["p"] = "Voer uw wachtwoord in:";
        $this->load->view("login/head", $data);
        $this->load->view("login/wachtwoord", $data);
        $this->load->view("login/foot");
    }

    private function equal_password() {

        //$encryptcode = $this->session->flashdata('item');

        if ($this->input->post('password') === $this->input->post('repeatpassword')) {
            $this->password_rules();
        } else {
            $msg = array(
                'response' => 'Vul 2 keer hetzelfde wachtwoord in alstublieft.',
            );

            exit(json_encode($msg));
        }
    }

    private function password_rules() {
        $password = $this->input->post('password');
        $lengte = strlen($password) >= 8 && strlen($password) <= 32;

        if ($lengte && preg_match_all('/[a-z+]/', $password, $matches) && preg_match('/[A-Z]/', $password) && preg_match('/\d/', $password) && preg_match('/\W+/', $password)) {
            //$result = count($matches[0]);
            if (count($matches[0]) < 5) {
                $msg = array(
                    'response' => 'Password voldoet niet aan de regels.',
                );

                exit(json_encode($msg));
            }
//            $msg = array(
//                'response' => $matches,
//            );
//
//            exit(json_encode($msg));
            $this->check_encryption();
        } else {
            $msg = array(
                'response' => 'Password voldoet niet aan de regels.',
            );

            exit(json_encode($msg));
        }
    }

    private function check_encryption() {

        $encryptcode = rawurlencode($_GET["hash"]);
        //exit(json_encode($encryptcode));
        $decrypt = rawurldecode($encryptcode);
        $hash_pw = md5($this->input->post('password'));

        $decryptcode = $this->encryption->decrypt($decrypt);
        //exit(json_encode($decryptcode));

        $key = explode('_', $decryptcode);
        $arr_key = array();
        foreach ($key as $item) {
            $arr_key[] = $item;
        }
        
        $user_id = $arr_key[0];
        //exit(json_encode($user_id));

        $check_key = $this->wachtwoord_model->check_key($arr_key);

        if (empty($check_key) === TRUE) {
            //key is good
            $wachtwoord_data = array(
                'password' => $hash_pw,
                //'user_id' => $user_id,
            );

            $arr_pwdata = $this->wachtwoord_model->store_password($wachtwoord_data, $user_id);

            if ($arr_pwdata === FALSE) {
                $msg = array(
                    'response' => 'data niet in database.',
                );

                exit(json_encode($msg));
            }
            $msg = array(
                'response' => 'Wachtwoord gemaakt.',
            );

            exit(json_encode($msg));
        }
        $msg = array(
            'response' => 'encryption key is fout.',
        );

        exit(json_encode($msg));
    }

}
