<?php

//get the last-modified-date of this very file
$lastModified=filemtime(__FILE__);
//get a unique hash of this file (etag)
$etagFile = md5_file(__FILE__);
//get the HTTP_IF_MODIFIED_SINCE header if set
$ifModifiedSince=(isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : false);
//get the HTTP_IF_NONE_MATCH header if set (etag: unique file hash)
$etagHeader=(isset($_SERVER['HTTP_IF_NONE_MATCH']) ? trim($_SERVER['HTTP_IF_NONE_MATCH']) : false);

//set last-modified header
header("Last-Modified: ".gmdate("D, d M Y H:i:s", $lastModified)." GMT");
//set etag-header
header("Etag: $etagFile");
//make sure caching is turned on
header('Cache-Control: public');

/*
// uncomment these two lines if script does not work on your php env
session_cache_limiter('public'); //This stop php’s default no-cache
session_cache_expire(5); // Optional expiry time in minutes
*/

//check if page has changed. If not, send 304 and exit
//if (@strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE'])==$lastModified || $etagHeader == $etagFile)
if (@strtotime($ifModifiedSince)==$lastModified || $etagHeader == $etagFile)
{
       header("HTTP/1.1 304 Not Modified");
       exit;
}

//your normal code
echo "This page was last modified: ".date("d.m.Y H:i:s",time());

?>
