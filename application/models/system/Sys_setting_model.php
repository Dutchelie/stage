<?php

class Sys_setting_model extends CI_Model {

    private $file = "sys_setting.php";

    private function get_file_path() {
        return APPPATH . 'config/' . ENVIRONMENT . '/' . $this->file;
    }

    public function write_config($data = array()) {
        if (empty($data) === TRUE) {
            $json["msg"] = "Geen data gevonden!";
            $json["status"] = "error";
            exit(json_encode($json));
        }

        $file_path = $this->get_file_path();

        if (file_exists($file_path) === FALSE) {
            $json["msg"] = "$file_path kan het niet vinden!";
            $json["status"] = "error";
            exit(json_encode($json));
        }

        $writefile = "<?php\r\n";
        foreach ($data as $key => $value) {
            $writefile .= "\$config['$key']='$value';\r\n";
        }

        if (write_file($file_path, $writefile) === FALSE) {
            $json["msg"] = "$file_path heeft geen toegang!";
            $json["status"] = "error";
            exit(json_encode($json));
        }

        $json["msg"] = "Instelling is success opgeslagen";
        $json["status"] = "good";
        exit(json_encode($json));
    }

    public function get_list() {
        $file_path = $this->get_file_path();
        $config = array();
        if (file_exists($file_path)) {
            $config = $file_path;
        }
        return $config;
    }

}
