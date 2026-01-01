<?php 
use Config\Config;
use App\Libraries\Assets;
$footer_js = Assets::loadJsAssets($pdata['assets']['source'], $pdata['assets']['footer_js']);
?>
<!-- View ends here -->
<footer class="footer">
        <p>&copy; <?php echo date('Y'); ?> <?= app_name(); ?></p>
    </footer>

<?php

foreach ($footer_js as $js) {
    echo $js;
}

?>
</body>

</html>