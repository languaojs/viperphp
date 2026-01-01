<?php

/**
 * 1. Load the Composer Autoloader
 * This handles all our namespacing (App\ and System\) automatically.
 */
require_once '../vendor/autoload.php';

use Config\Config;

$environment = Config::getEnvironment();


/**
 * 3. Start Session (Optional but recommended)
 * This allows you to use $_SESSION across your controllers.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * 4. Error Handling Wrapper (Optional)
 * In a framework, it's nice to catch exceptions so they don't 
 * look ugly to the end user in production.
 */
try {
    // Initialize the Core Library (The Router)
    $init = new System\Router();
} catch (\Exception $e) {
    if ($environment === 'development') {
        echo '<b>Framework Error:</b> ' . $e->getMessage();
    } else {
        // In production, log it and show a generic 500 page
        error_log($e->getMessage());
        header('HTTP/1.1 500 Internal Server Error');
        echo 'Something went wrong on our end. Please try again later.';
    }
}