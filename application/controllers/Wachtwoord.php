<?php

class Wachtwoord extends CI_Controller {
    //first function loaded on page load
    public function index() {
        //straight goes to user_device
        $this->user_device();
    }
    //checking what program and platform the user uses
    private function user_device() {
        //Load the agent library.
        $this->load->library('user_agent');
        //Getting the browser and the platform.
        //For example Chrome Windows
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

        //Makes session of agent output.
        $this->session->set_userdata('browser', $agent);
        //if a program or platform is there go to link_used
        $this->link_used();
    }
    //check if the link is already used
    private function link_used() {
        //session->userdata('device') is coming from the register controller
        //if the program and platform is not NULL
        if (($this->session->userdata('device') === NULL) === FALSE) {
            //go to time_expire
            $this->time_expire();
        } else {
            //on the end of this controller and Wwinstellen controller the session->userdata('device') gets destroyed
            //by doing this the user cant use the same link another time
            //tell the user he cant use the same link twice
            $data["title"] = "Link is al gebruikt.";
            $data["h3"] = "U kunt de <strong>link</strong> niet nog een keer gebruiken.";
            $data["p"] = "";
            $this->load->view("login/head", $data);
            $this->load->view("login/msgpage", $data);
            $this->load->view("login/foot");
        }
    }
    //check if the time is expired or not
    private function time_expire() {
        //if session->tempdata('timer') is not NULL
        if (($this->session->tempdata('timer') === NULL) === FALSE) {
            //go to get_hash
            $this->get_hash();
        } else {
        //if the session->tempdata('timer') = NULL
        //the 5 minutes to use the link is expired and you need to register again
        $data["title"] = "Link werkt niet meer.";
        $data["h3"] = "U had 5 <strong>minuten</strong> om uw link te gebruiken. Registreer opnieuw!";
        $data["p"] = "";
        $this->load->view("login/head", $data);
        $this->load->view("login/msgpage", $data);
        $this->load->view("login/foot");
        }
    }
    //get the client and server sided code
    public function get_hash() {
        //Here you get the encryptcode from the client side.
        $encryptcode = rawurlencode($this->input->get("hash"));
        $decrypt = rawurldecode($encryptcode);
        $decryptcode_client = $this->encryption->decrypt($decrypt);
        //make an array of the client sided code
        $arr_key = explode('_', $decryptcode_client);
        //Here you get the encryptcode from the server side.
        $server_value = $this->session->userdata("encryptcode");
        $decrypt_server = rawurldecode($server_value);
        $decryptcode_server = $this->encryption->decrypt($decrypt_server);

        //Session of the informatie used later on.
        $this->session->set_userdata('arr_key', $arr_key);
        $this->session->set_flashdata('client', $decryptcode_client);
        $this->session->set_flashdata('server', $decryptcode_server);
        //go the check_active
        $this->check_active($arr_key);
    }
    //check if account is active
    private function check_active($arr_key) {
        $result = $this->wachtwoord_model->get_active($arr_key);
        //Checks if the account is already activated or not.
        //You account will be active when you already used your account and you just forgot your password or something like that.
        if ($result["is_active"] === "0") {
            //If not active, he/she will go to Wwinstellen.
            //redirect to Wachtwoord instellen
            redirect(site_url('Wwinstellen/'));
        } else {
            //Othwerwise he will continue in this controller.
            //Wachtwoord = wachtwoord herstellen\
            //go to check_device
            $this->check_device();
        }
    }
    //check if the user uses the same browser
    private function check_device() {
        //get the arr_key for the client sided information
        $arr_key = $this->session->userdata('arr_key');
        //make a variable from the browser in arr_key
        $browser = explode(' ', $arr_key["2"]);
        //here you basically make the browser name more specific
        if (($browser[0] === "Chrome") === TRUE) {$browser[0] = "Google Chrome";}
        if (($browser[0] === "Spartan") === TRUE) {$browser[0] = "Microsoft Edge";}
        if (($browser[0] === "Internet") === TRUE) {$browser[0] = "Internet Explorer";}
        //Get the client and server sided encryptcodes.
        $client = $this->session->flashdata('client');
        $server = $this->session->flashdata('server');
        //If the encryptcodes are equal to each other you can go further to complete your registration.
        if (($client === $server) === TRUE) {
            //go to form_page
            $this->form_page();
        } else {
            //here you say what browser the user needs to use instead
            $data["title"] = "Oops Verkeerde Browser.";
            $data["h3"] = "Gebruik de browser <strong>$browser[0]</strong> waar u uw wachtwoord herstel heeft opgevraagd.";
            $data["p"] = "";
            $this->load->view("login/head", $data);
            $this->load->view("login/msgpage", $data);
            $this->load->view("login/foot");
        }
    }
    //the actualy password page
    private function form_page() {
        //An ajax call is necessary to continue.
        if ($this->input->is_ajax_request()) {
            //go to equal_password
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
            //Counts how many lower characters are in the password.
            //If there are 5 or more lower case characters you will continue.
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
        $arr_pwdata = $this->wachtwoord_model->store_password($wachtwoord_data, $user_id);
        //If the password didnt get stored
        if ($arr_pwdata === FALSE) {
            //tell the user something went wrong
            $msg = array(
                'response' => 'data niet in database.',
            );

            exit(json_encode($msg));
        }
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
