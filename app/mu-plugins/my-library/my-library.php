<?php
/*
Plugin Name:    My Library
*/

if (!defined('MY_LIBRARY_CORE_DIR')) {
    define('MY_LIBRARY_CORE_DIR', plugin_dir_path(__FILE__));
}

if (!defined('MY_LIBRARY_CORE_DIR_URL')) {
    define('MY_LIBRARY_CORE_DIR_URL', plugin_dir_url(__FILE__));
}

(MyLibrary\App::getInstance())->initialize();
