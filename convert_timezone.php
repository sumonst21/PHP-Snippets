<?php
/**
 * Convert a datetime from one timezone to another
 *
 * @param  mixed $time
 * @param  mixed $from_tz
 * @param  mixed $to_tz
 * 
 * @return string
 * @author sumonst21 <sumonst21@gmail.com>
 */
function convert_timezone($time, $from_tz, $to_tz) {
    $from_tz = new DateTimeZone($from_tz);
    $to_tz = new DateTimeZone($to_tz);
    $date = new DateTime($time, $from_tz);
    $date->setTimezone($to_tz);
    return $date->format('Y-m-d H:i:s');
}
//convert_timezone('2016-01-01 00:00:00', 'UTC', 'Asia/Tokyo');
$converted_datetime = convert_timezone('09/12/2021 13:56', 'UTC', 'Asia/Dhaka');
echo $converted_datetime."\n";
$converted_datetime = convert_timezone('09/12/2021 13:56', 'EST', 'Asia/Dhaka');
echo $converted_datetime;
/*
output:
2021-09-12 19:56:00
2021-09-13 00:56:00
*/
