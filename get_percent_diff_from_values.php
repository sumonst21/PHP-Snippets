<?php
$current_value = 16.58;
$total_value = 19.99;
$discounted_value = $total_value - $current_value;
$percent_diff = ($discounted_value/$total_value) * 100;
echo "raw diff    : $percent_diff \n";
echo 'rounded diff: ' . round($percent_diff);
