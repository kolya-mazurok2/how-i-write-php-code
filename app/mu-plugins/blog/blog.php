<?php
/*
Plugin Name:    Blog
*/

if (!defined('BLOG_DIR')) {
    define('BLOG_DIR', plugin_dir_path(__FILE__));
}

if (!defined('BLOG_DIR_URL')) {
    define('BLOG_DIR_URL', plugin_dir_url(__FILE__));
}

(Blog\App::getInstance())->initialize();
