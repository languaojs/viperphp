<?php

namespace App\Models;

if (basename($_SERVER['PHP_SELF']) == 'Home_model.php') {
    exit("Direct access to this file is not allowed.");
}

use System\Database;

class Home_model
{
    private $con;
    public function __construct()
    {
        $this->con = new Database();
    }

}
