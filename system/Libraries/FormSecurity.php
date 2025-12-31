<?php
namespace System\Libraries;

if (basename($_SERVER['PHP_SELF']) == 'FormSecurity.php') {
    exit("Direct access to this file is not allowed.");
}

/**
 * This class is to prevent CSRF Attack
 * @param function getInstance to instantiate
 * @param function setTokenField to add CSRF token to the form
 * @param function validateToken to validate CSRF token sent via form
 * @param function sanitizeInput to sanitize input data sent via form
 */
class FormSecurity
{
    private static $instance = null;
    private string $tokenKey = '_csrf_token';
    private int $tokenLength = 32;
    private string $sessionKey = '_form_security_tokens';

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION[$this->sessionKey])) {
            $_SESSION[$this->sessionKey] = [];
        }
    }

    public static function getInstance(): FormSecurity
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function generateToken(): string
    {
        $token = bin2hex(random_bytes($this->tokenLength));
        $_SESSION[$this->sessionKey][$token] = time();
        return $token;
    }

    public function getTokenKey(): string
    {
        return $this->tokenKey;
    }

    /**
     * Adding a CSRF token field in a form
     */
    public function setTokenField(): string
    {
        return '<input type="hidden" name="' . $this->tokenKey . '" value="' . $this->generateToken() . '">';
    }

    /**
     * Validating the CSRF token, typically in the controller
     * @return bool true if token valid, false is token invalid or not exist
     */
    public function validateToken(): bool
    {
        if (
            isset($_POST[$this->tokenKey]) &&
            isset($_SESSION[$this->sessionKey][$_POST[$this->tokenKey]])
        ) {
            unset($_SESSION[$this->sessionKey][$_POST[$this->tokenKey]]); // Optional: one-time use
            return true;
        }
        return false;
    }

    /**
     * Sanitizing form input
     * @param array input data
     * @return array sanitized data
     */
    public function sanitizeInput($data)
    {
        if (is_array($data)) {
            return array_map([$this, 'sanitizeInput'], $data);
        }

        if (is_object($data)) {
            foreach ($data as $key => $value) {
                $data->{$key} = $this->sanitizeInput($value);
            }
            return $data;
        }

        return htmlspecialchars(trim((string)$data), ENT_QUOTES, 'UTF-8');
    }
}
