<?php

namespace App\Libraries;

use Config\Config;

class Assets
{

    private string $baseUrl;
    private string $localCssPath;
    private string $localJsPath;

    public function __construct()
    {
        $this->baseUrl = Config::getBaseUrl();
        $this->localCssPath = $this->baseUrl . '/public/assets/css/';
        $this->localJsPath = $this->baseUrl . '/public/assets/js/';
    }

    //First, register CSS and JS assets.
    protected static function registered_css()
    {
        return [
            'viper' => [ //this is a "nickname" for the asset.
                'local' => 'Viper.css', //if inside a subfolder (e.g., viper/Viper.css); set to 'none' if not exist.
                'cdn' => 'none' //do not remove this key, even when the value is none (do not use null).
            ]
            //, add more css assets. 

        ];
    }

    protected static function registered_js()
    {
        return [
            'viper' => [ //this is a "nickname" for the asset.
                'local' => 'Viper.js', //if inside a subfolder (e.g., viper/Viper.js); set to 'none' if not exist.
                'cdn' => 'none' //do not remove this key, even when the value is none (do not use null).
            ]
            //, add more js assets.
        ];
    }

    /**
     * Set assets to be loaded in every controllers.
     */
    protected static function setDefaultAssets()
    {

        //Consider the order of the array values; do not duplicate assets in array.
        $header_css_assets = ['viper']; //add default CSS to the header.
        $header_js_assets = []; //add defaul JS assets to the header.
        $footer_js_assets = ['viper']; //add defaul JS assets to the footer.

        return array(
            'header_css' => $header_css_assets,
            'header_js' => $header_js_assets,
            'footer_js' => $footer_js_assets
        );
    }

    /**
     * Adding and merging assets by nicknames.
     */
    public static function setAssets(string $source, array $add_to_header_css = [], array $add_to_header_js = [], array $add_to_footer_js = [])
    {
        //Getting default CSS and JS assets.
        $assets = self::setDefaultAssets();
        $header_css = $assets['header_css'];
        $header_js = $assets['header_js'];
        $footer_js = $assets['footer_js'];

        //Merging with additional assets.
        if (!empty($add_to_header_css)) {
            $header_css = array_merge($header_css, $add_to_header_css);
        }
        if (!empty($add_to_header_js)) {
            $header_js = array_merge($header_js, $add_to_header_js);
        }
        if (!empty($add_to_footer_js)) {
            $footer_js = array_merge($footer_js, $add_to_footer_js);
        }

        $final_assets = array(
            'source' => $source,
            'header_css' => array_unique($header_css),
            'header_js' => array_unique($header_js),
            'footer_js' => array_unique($footer_js)
        );
        return $final_assets;
    }

    /**
     * Generating tags for CSS assets;
     * @param string $source: local or cdn;
     * @param array @cssAssetsNickname: assets nickname to add;
     * @return array CSS tags
     */
    public static function loadCssAssets(string $source, array $cssAssetsNickname)
    {
        static $instance = null;
        if ($instance === null) {
            $instance = new self();
        }

        $tags = [];

        $registeredCssAssets = self::registered_css();

        foreach ($cssAssetsNickname as $cssNickname) {
            if (isset($registeredCssAssets[$cssNickname]) && $registeredCssAssets[$cssNickname]['local'] !== 'none') {
                if ($source === 'cdn' && $registeredCssAssets[$cssNickname]['cdn'] !== 'none') {
                    $tags[] = '<link rel="stylesheet" href="' . htmlspecialchars($registeredCssAssets[$cssNickname]['cdn']) . '">';
                } else {
                    $localPath = $instance->localCssPath . $registeredCssAssets[$cssNickname]['local'];
                    $tags[] = '<link rel="stylesheet" href="' . htmlspecialchars($localPath) . '">';
                }
            }
        }

        return $tags;
    }

    /**
     * Generating tags for JS assets;
     * @param string $source: local or cdn;
     * @param array @jsAssetsNickname: assets nickname to add;
     * @return array JS tags
     */
    public static function loadJsAssets(string $source, array $jsAssetsNickname)
    {
        static $instance = null;
        if ($instance === null) {
            $instance = new self();
        }

        $tags = [];
        $registeredJsAssets = self::registered_js();
        foreach ($jsAssetsNickname as $jsNickname) {
            if (isset($registeredJsAssets[$jsNickname]) && $registeredJsAssets[$jsNickname]['local'] !== 'none') {
                if ($source === 'cdn' && $registeredJsAssets[$jsNickname]['cdn'] !== 'none') {
                    $tags[] = '<script src="' . htmlspecialchars($registeredJsAssets[$jsNickname]['cdn']) . '"></script>';
                } else {
                    $localPath = $instance->localJsPath . $registeredJsAssets[$jsNickname]['local'];
                    $tags[] = '<script src="' . htmlspecialchars($localPath) . '"></script>';
                }
            }
        }
        return $tags;
    }
}
