<?php

if (!function_exists('asset_url')) {

    function asset_url($path = "") {
        if (empty($path) === TRUE) {
            return;
        }
        return base_url("assets/$path");
    }

}

if (!function_exists('add_csrf_token')) {
    
    function add_csrf_token() {
        $ci = get_instance();
        $csrf = array(
            'name' => $ci->security->get_csrf_token_name(),
            'hash' => $ci->security->get_csrf_hash()
        );
//        $name = $csrf['name'];
//        $value = $csrf['hash'];
        //return $csrf;
        return "<input type='hidden' name='{$csrf["name"]}' id='csrf' value='{$csrf["hash"]}'>"; 
        
    }
}

if (!function_exists('get_curl')) {

    function get_curl($url = NULL, $params = array(), $methode = "POST") {
        if (empty($url) === TRUE) {
            return;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        switch ($methode) {
            case "POST":
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                break;
            default:
                break;
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            return;
        }
        curl_close($ch);
        if ($response === FALSE || empty($response) === TRUE) {
            return;
        }
        return $response;
    }

}

if (!function_exists('highlight_keyword')) {

    function highlight_keyword($keyword, $result) {
        $str = highlight_phrase($result, $keyword, '<span style="background-color:#FFFF66; color:#FF0000;">', '</span>');
        return $str;
    }

}

if (!function_exists('fetch_quarter_name')) {

    function fetch_quarter_name($n) {
        switch ($n) {
            case 1:
                return "Januari t/m Maart";
            case 2:
                return "April t/m Juni";
            case 3:
                return "Juli t/m September";
            case 4:
                return "Oktober t/m December";
            default:
                return;
        }
    }

}


if (!function_exists('fetch_month_name')) {

    function fetch_month_name($n) {
        switch ($n) {
            case 1:
                return "Januari";
            case 2:
                return "Februari";
            case 3:
                return "Maart";
            case 4:
                return "April";
            case 5:
                return "Mei";
            case 6:
                return "Juni";
            case 7:
                return "Juli";
            case 8:
                return "Augustus";
            case 9:
                return "September";
            case 10:
                return "Oktober";
            case 11:
                return "November";
            case 12:
                return "December";
            default:
                return;
        }
    }

}

if (!function_exists('cal_age')) {

    function cal_age($date, $return_obj = FALSE) {
        $arr_result = array();
        $bday = new DateTime($date);  //Y-m-d
        $date_now = date("Y-m-d");
        $today = new DateTime($date_now);
        $diff = $today->diff($bday);
        if ($return_obj === TRUE) {
            return $diff;
        }
        $arr_result["year"] = $diff->y;
        $arr_result["month"] = $diff->m;
        $arr_result["days"] = $diff->d;
        return $arr_result;
    }

}

if (!function_exists('generate_random_string')) {

    function generate_random_string($length = 8) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}



if (!function_exists('min_conver_hour')) {

    function min_conver_hour($total_min = 0) {
        if ($total_min <= 0) {
            return "0(u): 0(m)";
        }
        $hour = floor($total_min / 60);
        $minute = $total_min % 60;
        return $hour . " (u):" . $minute . " (m)";
    }

}

if (!function_exists('add_app_log')) {

    function add_app_log($description = "", $uid = 0) {
        if (empty($description) === TRUE) {
            return;
        }
        $CI = & get_instance();
        $CI->app_log_model->add($description, $uid);
    }
}

if (!function_exists('show_page')) {

    function show_page($url, $total, $per_page = NULL) {
        $CI = & get_instance();
        $query_string_segment = "page_number";
        $config = array();
        $config["per_page"] = $per_page;
        if (empty($per_page) === TRUE) {
            $config["per_page"] = $CI->config->item('webapp_default_show_per_page');
        }
        $config["base_url"] = $url;
        $config["total_rows"] = $total;

        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = $query_string_segment;
        $config["use_page_numbers"] = TRUE;
        $query_string = $_GET;
        if (isset($query_string[$query_string_segment])) {
            unset($query_string[$query_string_segment]);
        }

        if (count($query_string) > 0) {
            $config['suffix'] = '&' . http_build_query($query_string, '', "&");
            $config['first_url'] = $config['base_url'] . '?' . http_build_query($query_string, '', "&");
        }
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'Eerste';
        $config['last_link'] = 'Laatste ';
        $config['num_links'] = 5;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $CI->pagination->initialize($config);
        return $CI->pagination->create_links();
    }

}