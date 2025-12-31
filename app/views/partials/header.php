<?php 
use App\Libraries\Assets;
$header_css = Assets::loadCssAssets($pdata['assets']['source'], $pdata['assets']['header_css']);
$header_js = Assets::loadJsAssets($pdata['assets']['source'], $pdata['assets']['header_js']);

?>
<!DOCTYPE html>
<html lang="en" translate="no">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="revisit-after" content="1 days">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $pdata['meta_desc']; ?>">
    <meta name="robots" content="<?= $pdata['meta_robots']; ?>">
    <?php 
        foreach($header_css as $css) {
            echo $css;
        };

        foreach($header_js as $js) {
            echo $js;
        };
    ?>
    <title><?= $pdata['title']; ?></title>
</head>

<body>
        <!--Navbar (if any) and View begin here -->