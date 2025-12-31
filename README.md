# ViperPHP Framework `v0.1.0`

ViperPHP is a lightweight, easy-to-use, and secure PHP framework designed for rapid development. It features a clean structure, a built-in CLI tool, and a flexible asset management system.

## 🚀 Installation

Install ViperPHP using Composer:

```bash
composer create-project languaojs/viperphp your-app-name
```
## 🛠 Getting Started
### 1. The Home Page
To edit the main landing page, go to:
```
app/views/home/index.php
```
### 2. The Navigation Menu
To edit the global navbar, go to:
```
app/views/partials/home-menu.php
```
### 3. Configuration
To set your App Name, Security Keys, or Database Credentials, open:
```
config/config.php
```
## 📄 Creating a New Page
To create a new page (e.g., About), follow these steps:
### 1. Create a Controller:
Open your terminal and type:
```bash
php craft make:controller About
```
Alternatively, manually create ```app/controllers/About.php```.
### 2. Set up the logic
Inside your new controller, ensure you have an ```index()``` method. You can copy the structure from ```Home.php```.
### 3. Create the view
* Create a folder: ```app/views/about/```
* Create a file: ```app/views/about/index.php```
### 4. Connect Controller to a view
In your About.php controller, update the view call:
```PHP
$this->view('about/index');
```
## 🎨 Asset Management (CSS & JS)
ViperPHP uses a unique method to register and load assets, allowing you to load only what you need per page.
### Registering Assets

Go to ```app/Libraries/Assets.php``` to register your files. You can use local files or CDN links:
* Place local files in public/assets/css/ or public/assets/js/.
* Register them in the ```Assets.php``` library.
* Set Default Assets in this file to load them on every page automatically.
### Loading Assets in the Controller
You can determine which assets load for a specific method directly in the controller.
## 🖼 Media & Images
All images and media files should be placed in public/media/.
### Retrieving Media
Use the ```get_media($path)``` helper function to generate the correct URL. This function supports subfolders and filenames.
Example Usage:
```HTML
<!-- To get an image named code2.png -->
<img src="<?php echo get_media('code2.png'); ?>" alt="My Image">
```
