<?php
function multiply_arrays(array $arr1, array $arr2) {
  $ret = array();
  foreach ($arr1 as $v1) {
    foreach ($arr2 as $v2) {
      $ret[] = $v1 . $v2;
    }
  }
  return $ret;
}
