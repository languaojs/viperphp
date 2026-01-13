<?php

namespace Config;

if (basename($_SERVER['PHP_SELF']) == 'Config.php') {
    exit("Direct access to this file is not allowed.");
}


class Config
{
    // Set to false in Production or when ready to upload to the server
    protected const APP_EDIT = true;

    //Local Server Database Configuration do not add http:// or https://
    protected const LOCAL_URL = "localhost/viperphp";
    protected const LOCAL_DB_HOST = "localhost";
    protected const LOCAL_DB_USER = "root";
    protected const LOCAL_DB_PASS = "";
    protected const LOCAL_DB_NAME = "";

    //Global Server Database Configuration
    protected const BASE_URL = "";
    protected const DB_HOST = "";
    protected const DB_USER = "";
    protected const DB_PASS = "";
    protected const DB_NAME = "";

    //Site Info Configuration
    protected const SITE_NAME = "ViperPHP";
    protected const PLACE_NAME = "Indonesia";
    protected const SITE_ADDRESS = "ViperPHP Official Website";
    protected const SITE_EMAIL = "languaojs@gmail.com";
    protected const SITE_PHONE = "+62 852 4018 52xx";

    //Email Configutaion
    protected const MAIL_HOST = "";
    protected const MAIL_USER = "";
    protected const MAIL_PASS = "";
    protected const MAIL_PORT = 465;
    protected const MAIL_SMTP_SECURE = "ssl";

    //Keys
    protected const KEYS = array( //You can add any keys here.
        'Viper' => "ca3487a3bec25de3a43b67b7921dee694ea9b0f3801f0211b2111c03c226ba4c",
        'Geochart' => "xxxx" // if you have Google Geocharts key, put it in here.
    );

    /**
     * @param none If APP_EDIT is set to true, it will return localhost URL. Otherwise, it will return server URL.
     * @return string Base URL.
     */

    public static function getBaseUrl()
    {
        if (self::APP_EDIT == true) {
            $baseUrl = self::getProtocol() . '://' .self::LOCAL_URL;
            
        } else {
            $baseUrl = self::getProtocol() . '://' .self::BASE_URL;
        }
        return $baseUrl;
    }

    public static function getProtocol()
    {
        if (
            (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
            (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ||
            ($_SERVER['SERVER_PORT'] == 443)
        ) {
            return "https";
        }
        return "http";
    }

    /**
     * @return string Site name.
     */

    public static function getSiteName()
    {
        return self::SITE_NAME;
    }

    public static function getSiteInfo()
    {
        $site_info = [
            'site_name' => self::SITE_NAME,
            'site_address' => self::SITE_ADDRESS,
            'site_email' => self::SITE_EMAIL,
            'site_phone' => self::SITE_PHONE
        ];
        return $site_info;
    }

    /**
     * @return array Database configuration.
     * If APP_EDIT is true, it will return local database configuration. Otherwise, it will return server database configuration.
     */

    public static function getDbConfig()
    {
        if (self::APP_EDIT == true) {
            return [
                'host' => self::LOCAL_DB_HOST,
                'user' => self::LOCAL_DB_USER,
                'password' => self::LOCAL_DB_PASS,
                'database' => self::LOCAL_DB_NAME
            ];
        } else {
            return [
                'host' => self::DB_HOST,
                'user' => self::DB_USER,
                'password' => self::DB_PASS,
                'database' => self::DB_NAME
            ];
        }
    }

    /**
     * @return array Email configuration.
     */

    public static function getEmailConfig()
    {
        return [
            'host' => self::MAIL_HOST,
            'user' => self::MAIL_USER,
            'pass' => self::MAIL_PASS,
            'port' => self::MAIL_PORT,
            'secure' => self::MAIL_SMTP_SECURE
        ];
    }

    /**
     * @param string $key 'Viper'
     * @return string
     */

    public static function get_key(string $key)
    {
        return self::KEYS[$key];
    }

    public static function getEnvironment()
    {
        return self::APP_EDIT ? 'development' : 'production';
    }

    public static function getVersion() {
        return "0.1.2";
    }

    public static function getDescription(){
        $current_version = self::getVersion();
        $description = "ViperPHP $current_version new. This is a PHP framework developed by Zainurrahman.";
        return $description;
    }
    
}
