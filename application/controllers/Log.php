<?php

class Log extends CI_Controller {

    public function view($id = 0) {
       $content = $this->app_log_model->get_one($id);
       exit($content["description"]);
    }

}
