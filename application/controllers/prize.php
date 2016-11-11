<?php

//$arr = array("Lisheng", "Dennis", "Erik", "Max");
//
//$arr_result = array();
//foreach ($arr as $key => $value) {
//    if ($value == "Erik") {
//        continue;
//    }
//    $arr_result[] = $value;
//}
//
//var_export($arr_result);exit; 

$data = array(
    '1' => array(
        'name' => 'A',
        'min' => '100',
        'max' => '380',
    ),
    '2' => array(
        'name' => 'B',
        'min' => '120',
        'max' => '280',
    ),
    '3' => array(
        'name' => 'C',
        'min' => '400',
        'max' => '600',
    ),
    '4' => array(
        'name' => 'D',
        'min' => '470',
        'max' => '570',
    ),
);
$data_result = array();

$min_s = 570;
$max_s = 700;
//print_r(array_keys($data));
//var_export($data); 
foreach ($data as $key => $value) {

    $min = $value["min"];
    $max = $value["max"];
    
//    var_dump($min_s <= $min && $max_s >= $min);
//    var_dump($min_s <= $max && $max_s >= $max);
            
    $check_with_min = $min_s <= $min && $max_s >= $min;
    $check_with_max = $min_s <= $max && $max_s >= $max;
//    var_dump($check_with_min);
//    var_dump($check_with_max);
    
    if ($check_with_min === FALSE && $check_with_max === FALSE) {
        continue;
    } 
    $data_result[] = $value;
}
//print_r(array_keys($data));
var_export($data_result);
exit;



