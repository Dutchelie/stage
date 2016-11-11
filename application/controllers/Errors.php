<?php

class Errors extends Front_Controller {

    public function page_missing() {
        $data["title"] = "Pagina kon niet worden gevonden";
        $data["message"] = "Er is geen informatie gevonden";
        $this->view_head($data["title"]);
        $this->load->view("errors/page_missing", $data);
        $this->view_foot();
    }

}
