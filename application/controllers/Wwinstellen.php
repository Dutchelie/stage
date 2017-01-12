<?php

class Wwinstellen extends CI_Controller {
    //first function loaded on page load
    public function index() {
        //straight goes to form_page
        $this->form_page();
    }
    //loading the actualy view with the form
    private function form_page() {
        //An ajax call is necessary to continue.
        if ($this->input->is_ajax_request()) {
            //goes to equal_password
            $this->equal_password();
        }
        //load the view
        $data["title"] = "Wachtwoord";
        $data["h3"] = "<strong>Maken</strong> van uw wachtwoord";
        $data["p"] = "Voer uw wachtwoord in:";
        $this->load->view("login/head", $data);
        $this->load->view("login/wachtwoord", $data);
        $this->load->view("login/foot");
    }
    //here you check if the passwords are equal to each other
    private function equal_password() {
        //checking if the passwords are equal to each other.
        if ($this->input->post('password') === $this->input->post('repeatpassword')) {
            //if the password are equal, go to password_rules
            $this->password_rules();
        } else {
            //tell the user to have 2 of the same passwords
            $msg = array(
                'response' => 'Vul 2 keer hetzelfde wachtwoord in alstublieft.',
            );

            exit(json_encode($msg));
        }
    }
    //check if the password are by the rules
    private function password_rules() {
        //get the password from the form
        $password = $this->input->post('password');
        //Characters in length what the passwords needs to be.
        $lengte = strlen($password) >= 8 && strlen($password) <= 32;
        //The password rules.
        if ($lengte && preg_match_all('/[a-z+]/', $password, $matches) && preg_match('/[A-Z]/', $password) && preg_match('/\d/', $password) && preg_match('/\W+/', $password)) {
            //Count how many lower characters are in the password.
            //If there are 5 or more lower case characters you will contrinue.
            if (count($matches[0]) < 5) {
                //tell the user they need to follow the password rules
                $msg = array(
                    'response' => 'Wachtwoord voldoet niet aan de regels.',
                );

                exit(json_encode($msg));
            }
            //go to store_data when the password has 5 lower characters
            $this->store_data();
        } else {
            //tell the user they need to follow the password rules
            $msg = array(
                'response' => 'Wachtwoord voldoet niet aan de regels.',
            );

            exit(json_encode($msg));
        }
    }
    //store password in database
    private function store_data() {
        //Get the session arr_key just to get the right user_id.
        $user_id = $this->session->userdata('arr_key');
        //encrypt the password, so it is in the database protected
        $pw_hash = $this->encryption->encrypt($this->input->post('password'));
        $this->session->set_userdata("password", $pw_hash);
        //make an array of the password
        $wachtwoord_data = array(
            'password' => $pw_hash,
        );
        //Stores the password at the right user_id in user_login.
        $arr_pwdata = $this->wwinstellen_model->store_password($wachtwoord_data, $user_id);
        //If the password didnt get stored
        if ($arr_pwdata === FALSE) {
            //tell the user something went wrong
            $msg = array(
                'response' => 'data niet in database.',
            );

            exit(json_encode($msg));
        }
        //go to active_user when the data is in the database succesfully
        $this->active_user($user_id);
    }
    //make account active and give group_id
    private function active_user($user_id) {
        //make this array for is_active in the database
        $active = array('is_active' => 1);
        //Here you give get_active 1 in the database so the account gets activated.
        $active_acc = $this->wwinstellen_model->active_login($user_id, $active);
        //if account is not active
        if ($active_acc === FALSE) {
            //tell the user their account isnt active
            $msg = array(
                'response' => 'account is niet actief.',
            );

            exit(json_encode($msg));
        }
        //make an array for a group_id
        $user_group = array(
            'group_id' => 2,
        );
        //add group_id to the users account
        $acc_group = $this->wwinstellen_model->group_user($user_id, $user_group);
        //if the user has no group
        if ($acc_group === FALSE) {
            //tell the user their account is not selected in a group
            $msg = array(
                'response' => 'Account heeft geen groep.',
            );

            exit(json_encode($msg));
        }
        //go to active_acc when user got an group_id
        $this->active_acc($user_id);
    }
    //check if account is active and send a mail to the user
    private function active_acc($user_id) {
        //get id of the current user
        $id = array(
            'user_id' => $user_id["0"]
        );
        //get the firstname of the user with the id
        $data["name"] = $this->wwinstellen_model->get_firstname($id);
        //Send thank you mail.
        $this->load->library('email');
        $this->email->from('j.iedema@ddrive.org');
        $this->email->to('j.iedema@ddrive.org');
        //$this->email->cc('jorrit.iedema001@fclive.nl');
        $this->email->subject('Wachtwoord maken.');
        $this->email->message($this->load->view('admin/bedankt', $data, TRUE));
        $this->email->set_mailtype('html');
        $this->email->send();
        //Check if account is activated with the users id
        $result = $this->wwinstellen_model->get_active($user_id);
        //if is_active === 1
        //then the users account is active
        if ($result["is_active"] === "1") {
            //destroying the encryptcode session
            //By doing this the email link is not usable anymore because you need this session $this->session->unset_userdata("device");
            $this->session->unset_userdata("device");
            //tell the user he can log in now
            $msg = array(
                'response' => 'U kunt inloggen.',
            );
            exit(json_encode($msg));
        }
    }

}
