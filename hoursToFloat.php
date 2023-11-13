<?php

/**
 * Function to convert hours string to numerical value
 * e.g 1:30 to 1.5
 * @param string $hours
 * @return float
 */
function hoursToFloat($hours) {
    $minutes = 0;
    if (strpos($hours, ':') !== false) {
        $exploded = explode(':', $hours);
        $hours = $exploded[0];
        $minutes = $exploded[1];
    }
    return floatval($hours) + ($minutes / 60);
}

// 38h 55m
echo hoursToFloat('38:55'); //38.916666666667
//47h 01m
echo hoursToFloat('47:01'); //47.016666666667
