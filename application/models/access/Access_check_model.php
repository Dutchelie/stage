<?php

class Access_check_model extends CI_Model {

    static $admin_group_id = 1;
    static $user_group_id = 2;

    public function admin() {
        if ($this->login_model->group_id() != self::$admin_group_id) {
            redirect(site_url("login"));
        }
    }

    public function user() {
        if ($this->login_model->group_id() != self::$user_group_id) {
            redirect(site_url("login"));
        }
    }

    public function double() {
        if ($this->login_model->check_double_login() === TRUE) {
            $this->session->unset_userdata('referred_from');
            $this->login_model->logout();
            //redirect(site_url("login"));
        }
    }

    public function token() {
        $this->load->library('oauth2_service');
        $access_token = $this->oauth2_service->show_access_token();
        if (empty($access_token) === TRUE) {
            return;
        }
        if ($this->oauth2_service->check_resource() === FALSE) {
            $this->session->unset_userdata('referred_from');
            $this->login_model->logout();
            redirect(site_url("login"));
        }
    }

    public function redirect_url() {
        $group_id = $this->login_model->group_id();
        //$site_url = site_url();
        if ($group_id <= 0) {
            $page_url = NULL;
        }
        switch ($group_id) {
            case 1:
                $page_url = 'Admin is ingelogd!';
                break;
                //return'Admin logged in!';
            case 2:
                $page_url = 'User is ingelogd!';
                break;
                //return'User logged in!';
            default:
                $page_url = 'home';
                break;
        }

        return $page_url;
    }

    public function auto_redirect() {
        if ($this->login_model->group_id() > 0) {
            redirect($this->redirect_url());
        }
        return;
    }

}
