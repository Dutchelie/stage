<?php

class Ajaxck_model extends CI_Model {

    private $all_type = array("username", "date", "zipcode", "email", "phone");

    public function ck_value($type = NULL, $value = NULL, $msg = NULL) {
        $json = array();
        if (empty($type) === TRUE) {
            $json["msg"] = "Er is geen type gevonden!";
            $json["status"] = "error";
            exit(json_encode($json));
        }

        if (empty($value) === TRUE) {
            $json["msg"] = $msg;
            $json["status"] = "error";
            exit(json_encode($json));
        }

        if (in_array($type, $this->all_type) === TRUE) {
            if ($this->is_validate_value($type, $value) === FALSE) {
                $json["msg"] = $msg;
                $json["status"] = "error";
                exit(json_encode($json));
            }
        }
    }

    public function ck_length($str, $max = 50, $min = 2) {
        $len = strlen($str);
        if ($len < $min) {
            return FALSE;
        } elseif ($len > $max) {
            return FALSE;
        }
        return TRUE;
    }

    private function is_validate_value($type, $value) {
        if (empty($type) === TRUE || empty($value) === TRUE) {
            return FALSE;
        }

        switch ($type) {
            case 'email':
                return (bool) filter_var($value, FILTER_VALIDATE_EMAIL) && preg_match('/^([\w-\.]+@([\w-]+\.)+[\w-]{2,9})$/', $value);
            case 'phone':
                return (bool) preg_match('/^[0-9]{10}$/', $value);
            case 'username':
                return (bool) preg_match('/^[a-z0-9_-]{5,30}$/', $value);
            case 'zipcode';
                return (bool) preg_match('/([1-9]{1}[0-9]{3})([a-zA-Z]{2})$/', $value);
            case 'date':
                return $this->validateDate($value);
            default:
                return FALSE;
        }

        return FALSE;
    }

    private function validateDate($date, $format = 'd-m-Y') {
        if (!preg_match('/([0-3]{1}[0-9]{1})-([0-1]{1}[0-9]{1})-([1-2]{1}[0-9]{3})$/', $date)) {
            return FALSE;
        }
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

}
