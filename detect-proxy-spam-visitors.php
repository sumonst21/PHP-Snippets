<?php
/**
 * Just run this function to detect if proxy is used, and if so, you can use whatever analytics code you want or block the user.
 */
 
 function proxy_detected()
{
  if (
     $_SERVER['HTTP_X_FORWARDED_FOR']
  || $_SERVER['HTTP_X_FORWARDED']
  || $_SERVER['HTTP_FORWARDED_FOR']
  || $_SERVER['HTTP_CLIENT_IP']
  || $_SERVER['HTTP_VIA']
  || in_array($_SERVER['REMOTE_PORT'], array(8080,80,6588,8000,3128,553,554))
  || @fsockopen($_SERVER['REMOTE_ADDR'], 80, $errno, $errstr, 30))
  {
      return true;
  } else {
      return false;
  }
}

echo ( proxy_detected() ) ? "Proxy detected" : "No proxy detected";

// change timeout on fsockopen from 30 to 1 and to make it works more quickly

// src: https://stackoverflow.com/questions/21765366/how-to-detect-proxy-spam-visitors
