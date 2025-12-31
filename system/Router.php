<?php

namespace System;
if (basename($_SERVER['PHP_SELF']) == 'Router.php') {
    exit("Direct access to this file is not allowed.");
}

class Router {
    protected $currentController = 'Home';
    protected $currentMethod = 'index'; 
    protected $params = [];

    public function __construct() {
        $url = $this->getUrl();

        if (isset($url[0])) {
            $controllerPath = '../app/Controllers/' . ucwords($url[0]) . '.php';
            if (file_exists($controllerPath)) {
                $this->currentController = ucwords($url[0]);
                unset($url[0]);
            } else {
                die("404 - Controller Not Found");
            }
        }

        require_once '../app/Controllers/' . $this->currentController . '.php';

        $fullNamespace = 'App\\Controllers\\' . $this->currentController;
        $this->currentController = new $fullNamespace;

        if (isset($url[1])) {
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return [];
    }
}