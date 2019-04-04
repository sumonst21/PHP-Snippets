<?php
$re = '/BLA(?:(?!BLA).)*?LOOK/';
$str = 'BLA text text text  text text text BLA text text text text LOOK text text text BLA text text BLA';

preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);

// Print the entire match result
var_dump($matches);
