<?php
//de login modules heb ik van mijn praktijkbegeleider gekregen, ik zal commenten wat ik kan
class Login extends CI_Controller {
    //first function loaded on page load
    public function index() {
        //this variable is for the login tries later on
        $poging = 1;
        $this->session->set_userdata('poging', $poging);
        //if the group_id is higher then 0 
        if ($this->login_model->group_id() > 0) {
            //redirech to the url with the right group_id
            redirect($this->access_check_model->redirect_url());
        }
        //if username and password has value
        if ($this->input->post('username') && $this->input->post('password')) {
            $this->login_action();
        }
        //loading view with all the data
        $data["title"] = "Welkom bij login";
        $data["h3"] = "<strong>Inloggen</strong> met uw gegevens";
        $data["p"] = "Voer uw gebruikersnaam en wachtwoord in:";
        $this->load->view("login/head", $data);
        $this->load->view("login/login", $data);
        $this->load->view("login/foot");
    }
    //check if we can login
    private function login_action() {
        //get information needed (ip, username, password)
        $ip = $this->input->ip_address();
        $username = $this->input->post("username");
        $password = $this->input->post("password");
        //get the password stored in the database, at the right username
        $pw_check = $this->login_model->get_password($username);
        //decrypt this password
        $db_pw = $this->encryption->decrypt($pw_check["password"]);
        //if the 2 password are not equal
        if (($password === $db_pw) === FALSE) {
            //go to data_false
            $this->data_false($ip);
        }
        //put the variable poging from earlier in this array
        $num = array(
            'number' => $this->session->userdata('poging'),
        );
        //go to update_fail
        $this->login_model->update_fail($ip, $num);
        //go to login_true
        $this->login_true($username, $pw_check, $ip);
    }
    //when your login failed
    private function data_false($ip) {
        //check if ip is in database
        $check_ip = $this->login_model->check_ip($ip);
        //put the ip and the variable poging in one array
        $number = array(
            'ip_address' => $this->input->ip_address(),
            'number' => $this->session->userdata('poging'),
        );
        //if ip is not empty
        //ip is in the database
        if (empty($check_ip) === FALSE) {
            //array with number of login fails
            $num = array(
                'number' => $check_ip['number'] + 1,
            );
            //update num array in the database
            $this->login_model->update_fail($ip, $num);
        } else {
            //insert a new row in database at login_fails
            $this->login_model->insert_fail($number);
        }
        //go to login_timer
        $this->login_timer($check_ip, $ip);
    }
    //number of fails
    private function login_timer($check_ip, $ip) {
        //if number of fails is not equal to 5
        if ($check_ip['number'] !== "5") {
            //do 5 - amount of login fails(number under 5)
            $num = 5 - $check_ip['number'];
            //tell user he has (num) tries left
            $msg = array(
                'response' => "U heeft nog $num pogingen over.",
            );

            exit(json_encode($msg));
        }
        //when you have 5 login fails
        //reset amount of fails to 1 if amout of fails reached 5
        $num = array(
            'number' => $check_ip['number'] - 4,
        );
        //update amount of fails to 1 in database
        $this->login_model->update_fail($ip, $num);
        //tell the user they need to wait 5 minutes before they can try to login again
        $msg = array(
            'response' => "Wacht 5 minuten voordat u weer kan inloggen.",
        );
        
        exit(json_encode($msg));
    }
    //when loging in
    private function login_true($username, $pw_check) {
        //check if username and password are matched
        $login = $this->login_model->check_data($username, $pw_check["password"]);
        //if variable login is true
        if ($login === TRUE) {
            //making session so you login
            $this->login_model->add_user_session();
            //destroys session->unset_tempdata('timer')
            $this->session->unset_tempdata('timer');
            //redirects url
            $msg = array(
                'response' => $this->access_check_model->redirect_url(),
            );

            exit(json_encode($msg));
        }
        //tell user something went wrong
        $msg = array(
            'response' => 'fout',
        );

        exit(json_encode($msg));
    }
    //for loging out 
    public function logout() {
        //this session is made when logged in
        $this->session->unset_userdata('referred_from');
        //destroys the session to user/admin is getting logged out
        $this->login_model->logout();
        //redirect to given site_url in config
        redirect(site_url());
    }

}
