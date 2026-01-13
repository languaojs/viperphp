<?php

namespace App\Controllers;

//Add this code after the namespace of each controller; adjust based on the file name. In this case, it is Home.php
if (basename($_SERVER['PHP_SELF']) == 'Home.php') {
    exit("Direct access to this file is not allowed.");
} 


//Declare any classes you want to use in this controller
use System\Controller;
use App\Libraries\Assets;
use System\Libraries\Flasher;
use Config\Config;

//Initiate the controller
class Home extends Controller
{

    //If a controller has a view, always begins with an index
    public function index()
    {
        //Try uncomment below, and also in the Views/home/index.php

        // Flasher::set('success', 'Welcome', 'Congratulation! You have installed the framework!');

        $pdata['assets'] = Assets::setAssets($source = 'local', $header_css = ['viper'], $header_js = [], $footer_js = ['viper']);


        $pdata['title'] = 'Home'; //The title of the page
        $pdata['meta_desc'] = Config::getDescription(); 
        $pdata['meta_robots'] = ''; //Set to index, follow for SEO

        $data['from_model'] = $this->model('Home_model')->sayHello(); //This gets something from Models/Home_model.php. This will be displayed in the Views/home/index.php

        //This part renders the View
        $this->partial('header', $pdata); //leave this alone
        $this->partial('home-menu', $pdata); //adjust based on the file name; is removable if not apply
        $this->view('home/index', $data); //home is the controller, index is the page
        $this->partial('footer', $pdata);//leave this alone

        exit;
    }

}
