<?php

namespace System;

if (basename($_SERVER['PHP_SELF']) == 'Controller.php') {
    exit("Direct access to this file is not allowed.");
}

class Controller {
    
    /**
     * Load model
     * @param $model String Model Name
     * @return object
     */
    public function model($model) {
        $modelClass = 'App\\Models\\' . $model;
        return new $modelClass();
    }

    /**
     * Load view (main body)
     * @param $view String View Path
     * @param $data Array
     */
    public function view($view, $data = []) {
        // Check if view file exists
        if (file_exists('../app/Views/' . $view . '.php')) {
            require_once '../app/Views/' . $view . '.php';
        } else {
            die("View does not exist.");
        }
    }

    /**
     * Load Partials (header/navbar/footer)
     * @param $path String Partial Path
     * @param $pdata Array Partial Data
     */
    public function partial($path, $pdata = []) {
        $file = '../app/Views/partials/' . $path . '.php';
        if (file_exists($file)) {
            require $file;
        }
    }
}