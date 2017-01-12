<?php

class Register extends CI_Controller {
    //first function loaded on page load
    public function index() {
        //if it is an ajax request (ajax call) go to user_defice().
        if ($this->input->is_ajax_request()) {
            $this->user_device();
        }
        //do the default date -13
        $data["date"] = date('d-m-Y', strtotime('-13 year'));

        //Loading view with all the data
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
    //checking what program and platform the user uses
    private function user_device() {
        //Loading the agent library.
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
        //Make session of agent output.
        $this->session->set_userdata("device", $agent);
        //if a program or platform is there go to link_used
        $this->time_expire();
    }
    //check if the time is expired or not
    private function time_expire() {
        //if session->tempdata('timer')is greater or equal to 60
        if ($this->session->tempdata('timer') >= 60) {
            //value of session->tempdata('timer') = seconds
            //convert from seconds to hours:minutes:seconds
            $minute = gmdate("i:s", $this->session->tempdata('timer'));
            //replace the seconds value with the converted value
            $this->session->set_tempdata('timer', $minute);
        }
        //if session->tempdata('timer') is not NULL
        if (($this->session->tempdata('timer') === NULL) === FALSE) {
            //make a variable of the current time left in session->tempdata('timer')
            $tijd = $this->session->tempdata('timer');
            //give the user how much time is remaining
            $msg = array(
                'response' => "U moet $tijd minuten en seconden wachten tot u verder mag.",
            );

            exit(json_encode($msg));
        }
        //if session->tempdata('timer') is NULL
        $this->check_input();
    }
    //checks the input from firstname, lastname, emailaddress and birthday
    private function check_input() {
        //Checking if firstname and lastname and emailaddress and birthday has a value
        if ($this->input->post('firstname') && $this->input->post('lastname') && $this->input->post('emailaddress') && $this->input->post('birthday')) {
            //go to terms_check if firstname, lastname, emailaddress and birthday has an value
            $this->terms_check();
        }
        //if the value of firstname, lastname, emailaddress or birthday is missing
        $msg = array(
            'response' => 'Vul alle velden in alstublieft.',
        );

        exit(json_encode($msg));
    }
    //Checking if the google captcha is checked.
    private function captcha_check() {

        $url = "https://www.google.com/recaptcha/api/siteverify?";
        $secret = "6Lfp_AoUAAAAAOevj1eBx09wFMpllED1yAa4op60";
        $params = array(
            //'url' => $url,
            'secret' => $secret,
            'response' => $this->input->post('g-recaptcha-response')
        );
        //The varaibles that needs to be checked.
        $response = get_curl($url, $params);
        $result = json_decode($response);
        //if result is false tell the user he needs to do the captcha check
        if ($result->success === FALSE) {
            $msg = array(
                'response' => 'Vink het onderste vakje aan alstublieft.',
            );

            exit(json_encode($msg));
        }
        //if $result is true go to terms_check().
        $this->terms_check();
    }
    //Check if the user agreed to your terms.
    private function terms_check() {
        //if the user didnt agree to our terms
        if (($this->input->post('terms') == "off")) {
            //tell the user that he needs to agree to our terms to continue
            $msg = array(
                'response' => 'Accepteer de algemene voorwaarden alstublieft.',
            );

            exit(json_encode($msg));
        }
        //if the user agreed to our terms then go to firstname_check
        $this->firstname_check();
    }
    //check if firstname has the right specifications
    private function firstname_check() {
        //get firstname from the form
        $firstname = strlen($this->input->post('firstname'));
        //minimum length of firstname
        $minfn = 2;//minimum length
        //maximum length of firstname
        $maxfn = 20;//maximum length
        //Check if the length of firstname is between $minfn and $maxfn. 
        if ($firstname < $minfn === TRUE || $firstname > $maxfn === TRUE) {
            //tell the user if firstname is too short or too long
            $msg = array(
                'response' => 'Voornaam is te kort of te lang.',
            );

            exit(json_encode($msg));
        }
        //if the firstname is right by your rules go too lastname_check
        $this->lastname_check();
    }
    //check if lastname has the right specifications
    private function lastname_check() {
        //get lastname from the form
        $lastname = strlen($this->input->post('lastname'));
        //minimum length of lastname
        $minln = 2;//minimum length
        //maximum length of lastname
        $maxln = 60;//maximum length
        
        $check_lastname = $minln <= $lastname && $maxln >= $lastname;
        //Check if the length of lastname is between $minfn and $maxfn.
        if ($check_lastname === FALSE) {
            //tell the user if lastname is too short or too long
            $msg = array(
                'response' => 'Achternaam is te kort of te lang.',
            );

            exit(json_encode($msg));
        }
        //if the lastname is right by your rules go too email_valid
        $this->email_valid();
    }
    //check if the email is valid and correct
    private function email_valid() {
        //get email from the form
        $email = $this->input->post('emailaddress');
        //Validate if the email is the right format.
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
            //tell the user that the emailaddress isnt correct
            $msg = array(
                'response' => 'email is niet correct.',
            );

            exit(json_encode($msg));
        }
        //Check if the emailaddress has the right format
        if (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $email) === FALSE) {
            //tell the user that the emailaddress isnt correct
            $msg = array(
                'response' => 'email is niet correct.',
            );

            exit(json_encode($msg));
        }
        //if the email is correct go to age_check
        $this->age_check();
    }
    //check if the user is old enough
    private function age_check() {
        //get the date of birthday from the form
        $bday = strtotime($this->input->post('birthday'));
        //your birthday needs to be that you are atleast 13 years old.
        $minage = strtotime('+13 years', $bday);
        //Check if you are old enough.
        if (time() < $minage) {
            //tell the user when you are old enough
            $msg = array(
                'response' => 'Je moet ouder dan 13 jaar zijn.',
            );

            exit(json_encode($msg));
        }
        //if the user is old enough go the register_action
        $this->register_action();
    }
    //here you start too put the user in the database
    private function register_action() {
        //get all the information of the form
        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');
        $user_email = $this->input->post('emailaddress');
        $birthday = $this->input->post('birthday');
        //we need to make sure the account gets activated
        $is_active = array('is_active' => "1");
        //put all the information of the form in one array
        $account_data = array('firstname' => $firstname, 'lastname' => $lastname, 'emailaddress' => $user_email, 'birthday' => $birthday,);
        //send the emailaddress to your model
        //if the emailaddress already exists get the id from it
        $email_user = $this->register_model->get_mail($user_email);
        $user_id = $email_user['user_id'];
        //if the returned value of the Register_model is not NULL
        if (($email_user) !== NULL) {
            //if the emailaddress exists you get an user_id with it
            //with that user_id check with your model if that account is activated or not 
            $acc_active = $this->register_model->is_active($user_id);
            // if the existed emailaddress is not activated
            if (($acc_active === $is_active) === FALSE) {
                //if the emailaddress is not used/activated
                //update the emailaddress with the right firstname, lastname and date or birth
                $this->register_model->update_data($account_data);
            } else {
                //tell the user the emailaddress is already taken
                $msg = array('response' => 'email is al bezet.',);
                
                exit(json_encode($msg));
            }
        } else {
            //if the emailaddress doesnt exist, register the new emailaddress
            $this->register_model->register_data($account_data);
        }
        //is the register is succesfull go to login_data_action
        $this->login_data_action($user_id);
    }
    //here you put the emailaddress ready for login purposes
    public function login_data_action($user_id) {
        //get the email from the form
        $user_email = $this->input->post('emailaddress');
        //check if emailaddress is already in use
        $check_mail = $this->register_model->get_login_mail($user_email);
        //make an array of the user_id and your emailaddress for the database
        $user_login = array(
                'user_id' => $user_id,
                //verander de key emailaddress naar username zodat het in de user_login tabel kan als username.
                'username' => $user_email,
        );
        //if the returned value is not empty
        //it exists
        if (empty($check_mail) === FALSE) {
            //update the current value with the new values
            $send_userdata = $this->register_model->update_login_data($user_login, $user_id);
        } else {
            //make a new row for the user
            $send_userdata = $this->register_model->insert_login_data($user_login);
        }
        //if the data is not succesfully in the database.
        if ($send_userdata === FALSE) {
            //tell the user the data wasnt handled properly
            $msg = array(
                'response' => 'data niet in database.',
            );

            exit(json_encode($msg));
        }
        //if the data is in the database correctly go to send_mail
        $this->send_mail($user_id);
    }
    //if all the data is in the database, send a mail for the password
    public function send_mail($user_id) {
        //get the program and the platform the user in on
        $agent = $this->session->userdata("device");
        //get the emailaddres from the form
        $user_email = $this->input->post('emailaddress');
        //make one variable from the user_id, emailaddress and the program, platform the user is on
        $user_info = $user_id . '_' . $user_email . '_' . $agent;
        //get the firstname from the form
        $firstname = $this->input->post('firstname');
        //make the variable $h4 for the value of firstname
        $data["h4"] = $firstname;
        //Here you encrypt $user_info so you can check the code later on for security reasons.
        $data["encryptcode"] = rawurlencode($this->encryption->encrypt($user_info));
        //You also make a session of the encrypted code so it comes in the server side aswell as the client side.
        $this->session->set_userdata($data);
        //Here you make the mail for the user.
        $this->load->library('email');
        $this->email->from('j.iedema@ddrive.org');
        $this->email->to($user_email);
        //$this->email->cc('jorrit.iedema001@fclive.nl');
        $this->email->subject('Wachtwoord maken.');
        $this->email->message($this->load->view('admin/emailview', $data, TRUE));
        $this->email->set_mailtype('html');
        //if the email didnt get send
        if ($this->email->send() === FALSE) {
            //tell the user the email didnt got send
            $msg = array('response' => 'Niks verstuurd.');

            exit(json_encode($msg));
        }
        //set a 5 minute timer so the user cant spam accounts,
        //and doesnt get spammed in his mailbox
        $this->session->set_tempdata('timer', 300);//300 seconds = 5 minutes
        
        //add_app_log($this->load->view('admin/emailview', $data, TRUE));
        //echo $this->email->print_debugger();
        
        //tell the user he/she got an email
        $msg = array('response' => 'Er is een mail naar u toegestuurd.');

        exit(json_encode($msg));
    }

}
