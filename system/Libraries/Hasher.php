<?php 

namespace System\Libraries;

if (basename($_SERVER['PHP_SELF']) == 'Hasher.php') {
    exit("Direct access to this file is not allowed.");
}

/**
 * Use to generate UUID version 4, hash password, and verify password
 * @param function hashIt (to hash password)
 * @param function dehashIt (to verify password)
 * @param function generateUUIDv4 (to generate UUID version 4)
 */
class Hasher {

    /**
     * Use for generating password
     * @param string $string password to hash
     * @return string Hashed password
     */
    public static function hashIt($string) {
        $option = ['cost'=>10];
        $password = password_hash($string, PASSWORD_BCRYPT, $option);
        return $password;
    }

    /**
     * Use for verifying password
     * @param string $hash hashed password
     * @param string $string password to verify
     * @return bool
     */
    public static function dehashIt($hash, $string) {
        if(!password_verify($string, $hash)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Use for generating an UUID version 4
     * @return string UUID version 4
     */
    public static function generateUUIDv4(){
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        $uuid = bin2hex(substr($data, 0, 4)) . '-' .
                bin2hex(substr($data, 4, 2)) . '-' .
                bin2hex(substr($data, 6, 2)) . '-' .
                bin2hex(substr($data, 8, 2)) . '-' .
                bin2hex(substr($data, 10, 6));

        return $uuid;
    }
}