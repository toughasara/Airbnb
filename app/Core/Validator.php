<?php

namespace App\Core;
use App\Core\Error;

class Validation
{
    public static function validlogin($user)
    {
        $email = $user->getEmail();
        $password = $user->getPassword();

        $passwordPattern = "/^.{4,}$/";
        $emailPattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

        if (!preg_match($emailPattern, $email)) {
            ErrorsHandling::emailinvalid();
            return false;
        }
        
        if (!preg_match($passwordPattern, $password)) {
            ErrorsHandling::passwordinvalid();
            return false;
        }

        return true;
    }
}
?>