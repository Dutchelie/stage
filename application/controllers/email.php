<?php

class email extends CI_Controller{
    
    function auto_mail(){
//        $config['protocol']     = 'smtp';
//        $config['smtp_host']     = 'j.';
//        $config['smtp_port']    = '465';
//        $config['smtp_user']    = 'j.iedema@ddrive.org';
//        $config['smtp_pass']    = '6PgRcKLWD';
//        $config['mailtype']     = 'text'; 
//        $config['charset']      = 'utf-8';
//        
//        $this->load->library('email', $config);
//        $this->email->set_newline("\r\n");
        
        $email_send = $this->send_email_model->send_mail();
        
        if ($email_send === TRUE) {
            echo'mail has been send';
        }else {
            echo'nothing has been send';
        }
    }
}
