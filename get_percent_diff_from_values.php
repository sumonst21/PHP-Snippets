<?php
$current_value = 49.99;
$total_value = 59.88;
if (php_sapi_name() == 'cli' && isset($argv[1]) && isset($argv[2])) {
    $current_value = $argv[1];
    $total_value = $argv[2];
}
$discounted_value = $total_value - $current_value;
$percent_diff = ($discounted_value/$total_value) * 100;
echo "raw diff    : $percent_diff \n";
echo 'rounded diff: ' . round($percent_diff) . "\n";
