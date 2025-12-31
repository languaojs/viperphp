<?php

use Config\Config;
use System\Libraries\Flasher;

/**
 * Get the base URL
 * @param string $path (optional)
 * @return string base_url and path
 */
function base_url($path = '') {
    return Config::getBaseUrl() . ltrim($path, '/');
}

function app_name() {
    return Config::getSiteName();
}

/**
 * Simple Redirect
 * @param string $path
 */
function redirect($path) {
    header('Location: ' . base_url($path));
    exit;
}

/**
 * Redirect with flasher
 * @param string $path
 * @param string $type flasher type
 * @param string $title flasher title
 * @param string $message flasher message
 */

function go_to($path, $type, $title, $message) {
    Flasher::set($type, $title, $message);
    redirect($path);
}

/**
 * Path to logo
 */
function logo(){
    return base_url() . '/public/assets/img/logo.png';
}

/**
 * Path to media
 * @param string $path: include subfolder and filename.
 */
function get_media($path) {
    return base_url() . '/public/media/' . $path;
}

/**
 * Debugging helper
 */
function dd($data) {
    echo "<pre style='background: #333; color: #fff; padding: 15px; border-radius: 5px;'>";
    print_r($data);
    echo "</pre>";
}

