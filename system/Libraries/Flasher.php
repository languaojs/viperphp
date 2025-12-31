<?php

namespace System\Libraries;
if (basename($_SERVER['PHP_SELF']) == 'Flasher.php') {
    exit("Direct access to this file is not allowed.");
}

class Flasher
{
    /**
     * Set a flash message
     * @param string $type (success, info, warning, error)
     * @param string $title
     * @param string $message
     */
    public static function set(string $type, string $title, string $message): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['flash'] = [
            'type'    => $type,
            'title'   => $title,
            'message' => $message
        ];
    }

    /**
     * Fire (display) the flash message and clear the session
     */
    public static function flash(): void {
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            $type = $flash['type'];
            
            // Map types to HTML entities for icons
            $icons = [
                'success' => '&#10004;', // Checkmark
                'info'    => '&#8505;',  // Info symbol
                'warning' => '&#9888;',  // Warning sign
                'error'   => '&#10006;'  // Cross
            ];

            $icon = $icons[$type] ?? $icons['info'];

            echo "
            <div class='flash-container'>
                <div class='flash-message flash-{$type}' id='flash-msg'>
                    <div class='flash-icon'>{$icon}</div>
                    <div class='flash-body'>
                        <div class='flash-title'>{$flash['title']}</div>
                        <div class='flash-text'>{$flash['message']}</div>
                    </div>
                    <button class='flash-close' onclick=\"this.parentElement.remove()\">&times;</button>
                </div>
            </div>
            ";

            unset($_SESSION['flash']);
        }
    }
}
