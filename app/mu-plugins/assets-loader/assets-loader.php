<?php
/*
Plugin Name: Assets Loader
*/

if (!defined('ASSETS_LOADER_CORE_DIR')) {
    define('ASSETS_LOADER_CORE_DIR', plugin_dir_path(__FILE__));
}

if (!defined('ASSETS_LOADER_CORE_DIR_URL')) {
    define('ASSETS_LOADER_CORE_DIR_URL', plugin_dir_url(__FILE__));
}

(AssetsLoader\App::getInstance())->initialize();
