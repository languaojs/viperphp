<?php

namespace App\Models;

if (basename($_SERVER['PHP_SELF']) == 'Home_model.php') {
    exit("Direct access to this file is not allowed.");
}

use System\Database;

class Home_model
{

    /***
     * Database connection can only be made if all database credentials are provided
     */

    // private $con;
    // public function __construct()
    // {
    //     $this->con = new Database();
    // }

    public function sayHello(){
        return "Hello, there!";
    }
}
