<?php

namespace App\Core;

class Session
{

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public static function createUserSession($user)
    {
        if (self::get('user')) {
            return;
        }
        self::set('user', [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'role' => $user->getRole()->getId(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'is_connected' => true
        ]);
    }

    public static function set($key, $value)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION[$key] = $value;
    }

    public static function get($key, $default = null)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION[$key] ?? $default;
    }

    public static function remove($key)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION[$key]);
    }

    public static function destroy()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
    }

}
?>