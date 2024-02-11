<?php
//  $script_path = str_replace( '\\', '/', __FILE__  );
//  $script_name = basename($script_path);

//  if(strstr($_SERVER['SCRIPT_NAME'], $script_name) === false) {
//     error_log(sprintf("Unauthorized access."));
//     header('HTTP/1.0 403 Forbidden');
//     exit();
//  }

if(!defined('ABSPATH')) {
    error_log(sprintf("Unauthorized access."));
    header('HTTP/1.0 403 Forbidden');
    exit();
}