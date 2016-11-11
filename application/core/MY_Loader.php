<?php

class MY_Loader extends CI_Loader {

    public function __construct() {
        parent::__construct();
    }

    public function switch_view_path($type = "admin") {
        $this->_ci_view_paths = array(VIEWPATH . "$type/" => TRUE);
    }

    public function switch_front_view_path() {
        $this->_ci_view_paths = array(VIEWPATH => TRUE);
    }

}
