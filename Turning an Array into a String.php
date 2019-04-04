<?php
/*
4.9.1. Problem
You have an array, and you want to convert it into a nicely formatted string.

4.9.2. Solution

Use join( ):
*/
// make a comma delimited list
$string = join(',', $array);
//Or loop yourself:

$string = '';

foreach ($array as $key => $value) {
    $string .= ",$value";
}

$string = substr($string, 1); // remove leading ","
//4.9.3. Discussion
//If you can use join( ), do; it's faster than any PHP-based loop. However, join( ) isn't very flexible. First, it places a delimiter only between elements, not around them. To wrap elements inside HTML bold tags and separate them with commas, do this:

 $left  = '<b>';
$right = '</b>';

$html = $left . join("$right,$left", $html) . $right;
//Second, join( ) doesn't allow you to discriminate against values. If you want to include a subset of entries, you need to loop yourself:

 $string = '';

foreach ($fields as $key => $value) {
    // don't include password
    if ('password' != $key) {
        $string .= ",<b>$value</b>";
    }
}

$string = substr($string, 1); // remove leading ","
//Notice that a separator is always added to each value, then stripped off outside the loop. While it's somewhat wasteful to add something that will be later subtracted, it's far cleaner and efficient (in most cases) then attempting to embed logic inside of the loop. To wit:

$string = '';
foreach ($fields as $key => $value) {
    // don't include password
    if ('password' != $value) {
        if (!empty($string)) { $string .= ','; }
        $string .= "<b>$value</b>";
    }
}
//Now you have to check $string every time you append a value. That's worse than the simple substr( ) call. Also, prepend the delimiter (in this case a comma) instead of appending it because it's faster to shorten a string from the front than the rear.


// src: https://docstore.mik.ua/orelly/webprog/pcook/ch04_09.htm
