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
        self::set('user', [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'role' => $user->getRole(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'is_connected' => true
        ]);
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function remove($key)
    {
        unset($_SESSION[$key]);
    }

    public static function destroy()
    {
        session_destroy();
    }

}
?>