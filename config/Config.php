<?php

namespace Config;

if (basename($_SERVER['PHP_SELF']) == 'Config.php') {
    exit("Direct access to this file is not allowed.");
}


class Config
{
    // Set to false in Production
    protected const APP_EDIT = true;

    //Local Server Database Configuration
    protected const LOCAL_URL = "http://localhost/viperphp";
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
    
    //Site Info Sonfiguration
    protected const SITE_NAME = "ViperPHP v.0.1.0";
    protected const PLACE_NAME = "Indonesia";
    protected const SITE_ADDRESS = "";
    protected const SITE_EMAIL = "";
    protected const SITE_PHONE = "xxxx";
    
    //Email Configutaion
    protected const MAIL_HOST = "";
    protected const MAIL_USER = "";
    protected const MAIL_PASS = "";
    protected const MAIL_PORT = 465;
    protected const MAIL_SMTP_SECURE = "ssl";
    
    //Keys
    protected const KEYS = array( //You can add any keys here.
        'Viper' => "ca3487a3bec25de3a43b67b7921dee694ea9b0f3801f0211b2111c03c226ba4c", //create another long random key for your app.
    );

    /**
     * @param none If APP_EDIT is set to true, it will return localhost URL. Otherwise, it will return server URL.
     * @return string Base URL.
     */

    public static function getBaseUrl()
    {
        if(self::APP_EDIT == true) {
            return self::LOCAL_URL;
        }else {
            return self::BASE_URL;
        }
    }
    
    /**
     * @return string Site name.
     */
     
    public static function getSiteName()
    {
        return self::SITE_NAME;
    }

    public static function getSiteInfo() {
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
        if(self::APP_EDIT == true) {
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

    public static function get_key(string $key){
        return self::KEYS[$key];
    }
}
