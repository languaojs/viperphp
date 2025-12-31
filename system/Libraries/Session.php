<?php

namespace System\Libraries;

use Config\Config;

if (basename($_SERVER['PHP_SELF']) == 'Session.php') {
    exit("Direct access to this file is not allowed.");
}

/**
 * For session and cookie management
 */
class Session
{

    private static $_sessionStarted = FALSE;

    // SESSION MANAGEMENT

    public static function start()
    {
        if (!session_id()) {
            if (self::$_sessionStarted == FALSE) {
                session_start();
                self::$_sessionStarted = TRUE;
            }
        }
    }

    /**
     * Encoding session data into a $_SESSION variable;
     */
    public static function encrypt_session(string $session_name, array $session_data)
    {
        $key = Config::get_key('Viper');
        $cipher = "AES-256-CBC";
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
        $jsonData = json_encode($session_data);
        $encrypted = openssl_encrypt($jsonData, $cipher, $key, 0, $iv);
        $encrypted_session = base64_encode($iv . $encrypted);
        $_SESSION[$session_name] = $encrypted_session;
    }

    
    /**
     * Check if a session exists based on session name
     * @param string $session_name
     * @return bool true or false
     */
    public static function check_session(string $session_name)
    {
        if (isset($_SESSION[$session_name])) {
            return true;
        } else {
            return false;
        }
    }
    
    
    /**
     * Decoding session data from a $_SESSION variable;
     * @param string $session_name
     * @return array session data (session name, keys, and values) or false
     */
    public static function decrypt_session($session_name)
    {
        $key = Config::get_key('Viper');
        $cipher = "AES-256-CBC";
        if (isset($_SESSION[$session_name])) {
            $encryptedData = $_SESSION[$session_name];
            $decrypt = base64_decode($encryptedData);
            $ivLength = openssl_cipher_iv_length($cipher);
            $iv = substr($decrypt, 0, $ivLength);
            $encrypted = substr($decrypt, $ivLength);
            $decrypted_data = openssl_decrypt($encrypted, $cipher, $key, 0, $iv);
            return json_decode($decrypted_data, true);
        } else {
            return false;
        }
    }
    

    /**
     * Getting a value of a session based on session name and key;
     * @param string $session_name
     * @param string $session_key
     * @return string session value or error
     */
    public static function get_decrypted_session_val($session_name, $session_key)
    {
        $decrypted_data = self::decrypt_session($session_name);
        if ($decrypted_data) {
            if (array_key_exists($session_key, $decrypted_data)) {
                $value = $decrypted_data[$session_key];
                return $value;
            } else {
                return 'Array key does not exist';
            }
        } else {
            return 'There is no session in that name';
        }
    }

    /**
     * Getting raw session data
     * @param string $session_name
     * @return string or bool false
     */
    public static function get_raw_session_data(string $session_name)
    {
        if (isset($_SESSION[$session_name])) {
            return $_SESSION[$session_name];
        } else {
            return false;
        }
    }



    // COOKIE MANAGEMENT

    /**
     * Encoding cookie data into a $_COOKIE variable;
     * @param array $cookie_data
     * @return string
     */
    public static function encrypt_cookie(array $cookie_data)
    {
        $cookie_value = base64_encode(json_encode($cookie_data));
        return $cookie_value;
    }

    /**
     * Setting cookie data;
     * @param string $cookie_name
     * @param string $cookie_data
     * @return bool true or false
     */
    public static function set_cookie(string $cookie_name, string $cookie_data)
    {
        if (setcookie($cookie_name, $cookie_data, time() + (30 * 24 * 60 * 60), '/')) {
            return true;
        } else {
            return false;
        };
    }

    /**
     * Check if a cookie exists based on cookie name
     * @param string $cookie_name
     * @return bool true or false
     */
    public static function check_cookie(string $cookie_name)
    {
        if (isset($_COOKIE[$cookie_name])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Decoding cookie data from a $_COOKIE variable;
     * @param string $cookie_name
     * @return array json or bool false
     */
    public static function decrypt_cookie(string $cookie_name)
    {
        if (isset($_COOKIE[$cookie_name])) {
            $decrypted_cookie = json_decode(base64_decode($_COOKIE[$cookie_name]), true);
            return $decrypted_cookie;
        } else {
            return false;
        }
    }

    /**
     * Getting a value of a cookie based on cookie name and key;
     * @param string $cookie_name
     * @param string $cookie_key
     * @return string 
     */
    public static function get_decrypted_cookie_val($cookie_name, $cookie_key)
    {
        $decrypted_cookie = self::decrypt_cookie($cookie_name);
        if ($decrypted_cookie) {
            if (array_key_exists($cookie_key, $decrypted_cookie)) {
                $value = $decrypted_cookie[$cookie_key];
                return $value;
            } else {
                return 'Array key does not exist';
            }
        }
    }

    /**
     * Getting raw cookie data
     * @param string $cookie_name
     * @return string or bool false
     */
    public static function get_raw_cookie_data(string $cookie_name)
    {
        if (isset($_COOKIE[$cookie_name])) {
            return $_COOKIE[$cookie_name];
        } else {
            return false;
        }
    }

    /**
     * Logout
     * Clearing Session and Cookie data
     * @param string $session_name
     * @param string $cookie_name
     */

    public static function logout(?string $session_name = null, ?string $cookie_name = null)
    {
        session_start();

        if ($session_name !== null) {
            unset($_SESSION[$session_name]);
        }

        if ($cookie_name !== null) {
            if (isset($_COOKIE[$cookie_name])) {
                setcookie($cookie_name, '', time() - 3600, '/');
            }
        }

        header("location:" . Config::getBaseUrl());
    }
}
