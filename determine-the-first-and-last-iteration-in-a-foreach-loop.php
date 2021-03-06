<?php
//Solution for PHP 7.3 and up:
foreach($array as $key => $element) {
    if ($key === array_key_first($array))
        echo 'FIRST ELEMENT!';

    if ($key === array_key_last($array))
        echo 'LAST ELEMENT!';
}
//Solution for all PHP versions:
foreach($array as $key => $element) {
    reset($array);
    if ($key === key($array))
        echo 'FIRST ELEMENT!';

    end($array);
    if ($key === key($array))
        echo 'LAST ELEMENT!';
}


/*
 * more styels
 */
// First
foreach($array as $value) {

    if ($value === reset($array)) {
        echo 'FIRST ITEM!';
    }

}

// Last
foreach($array as $value) {

    if ($value === end($array)) {
        echo 'LAST ITEM!';
    }

}


// Combined
foreach($array as $value) {

    if ($value === reset($array)) {
        echo 'FIRST ELEMENT!';
    }

    if ($value === end($array)) {
        echo 'LAST ITEM!';
    }
    
}
