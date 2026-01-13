<?php 
use System\Libraries\Flasher;

//Uncomment the Flasher below after uncomment its partrner in the Home controller.

// Flasher::flash();
?>
<main class="container">
    <h1><?= $data['from_model'] ?></h1> <!-- This is from the Controller Home -->
    <h2>Welcome to Your New PHP Framework</h2>
    <hr>
    <!-- app_name() is from the system/Helpers/SystemHelpers.php -->
    <p><?= app_name() ?> is a lightweight PHP framework. This framework is easy to use and secure.</p>
    <p>To edit this page, go to <code>app/Views/home/index.php</code>.</p>
    <p>To edit the navbar, go to <code>app/Views/partials/home-menu.php</code>.</p>
    <p>To set your app name, add keys, database credentials, etc., go to <code>config/Config.php</code>.</p>
    <br>
    <p>To create a new page, follow these steps:</p>
    <ol>
        <li>Create a controller in <code>app/Controllers/</code>, e.g., About.php. Or, open your terminal and type <code>php craft make:controller About</code>.</li>
        <li>Copy the <code>public function index(){}</code> from the Home.php controller.</li>
        <li>Create a view: (a) create a folder in the <code>app/Views/</code> e.g., <i>about</i>; (b) create a view file in that folder (e.g., index.php).</li>
        <li>Inside the new controller index(), replace the <code>$this->view("home/index")</code> to <code>$this->view("about/index")</code>.</li>.
    </ol>
    <p>To add more assets (CSS and JS):</p>
    <ol>
        <li>Add your CSS and JS files in the <code>public/assets</code> folder, respectively.</li>
        <li>Register your assets in <code>app/Libraries/Assets.php</code>.</li>
        <li>Set what assets you want to load in the header and footer, right in the controller (see Fig.1 below).</li>
        <li>When register the assets, put the cdn link if you want. To set the assets, you can either use the local assets or the cdn as the source.</li>
        <li>This method allows you to determine whether or not particular assets are needed in a controller.</li>
        <li>Set default assets (assets to load in every controller) in <code>app/Libraries/Assets.php</code>.</li>
    </ol>
    <br>
    <p>Images or any media are placed in the <code>public/media/</code> folder. The url of a media can be retrieved by using the <code>get_media($path)</code> function, where $path is a string, including subfolder and filename. For example, here is an image with the url is retrieved by using <code>get_media('code2.png')</code>.</p>
    <br>
    <figure>
        <!-- get_media() is from the system/Helpers/SystemHelpers.php -->
        <img src="<?= get_media('code2.png') ?>" width="100%" alt="">
        <figcaption>Fig.1 - How to set assets in the controller.</figcaption>
    </figure>
</main>