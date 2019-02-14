<?php

//-----------------
// Input:
//-----------------
$input = ' 
<a href="" class ="link">Hello</a>
<iframe class="cust-embed"width="560" height="315" src="//www.youtube.com/embed/_dGc1lWadaQ" frameborder="0" allowfullscreen></iframe>
<iframe class="cust-embed"width="560" height="315" src="https://www.youtube.com/watch?v=6JQm5aSjX6g" frameborder="0" allowfullscreen></iframe>
<img class="front" src="http://example.com/cars.jpg"/>
<h1>Hello Agian</h1>
<img width="100" height="50" src="ships.jpg"/>
<br/>
';

//-------------------------
// Display all iframe src:
//-------------------------

$sources = get_iframe_src( $input );

foreach( (array) $sources as $source ) {
echo $source . PHP_EOL; 
}

//-------------------------
// Display all image src:
//-------------------------

$sources = get_img_src( $input );

foreach( (array) $sources as $source ) {
echo $source . PHP_EOL; 
}

//-------------------------
// Helper functions:
//-------------------------

/**
* Grab all iframe src from a string
*/
function get_iframe_src( $input ) {
preg_match_all("/<iframe[^>]*src=[\"|']([^'\"]+)[\"|'][^>]*>/i", $input, $output );
$return = array();
if( isset( $output[1][0] ) ) {
$return = $output[1];
}
return $return;
}

/**
* Grab all img src from a string
*/
function get_img_src( $input ) {
preg_match_all("/<img[^>]*src=[\"|']([^'\"]+)[\"|'][^>]*>/i", $input, $output );
$return = array();
if( isset( $output[1][0] ) ) {
$return = $output[1];
}
return $return;
}
