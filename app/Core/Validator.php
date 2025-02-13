<?php

namespace App\Core;
use App\Core\Error;

class Validator
{
    public static function validPassword($password)
    {
        $passwordPattern = "/^.{4,}$/";
        if (!preg_match($passwordPattern, $password)) {
            Error::passwordinvalid();
            return false;
        }
        return true;
    }

    public static function validlogin($user)
    {
        $email = $user->getEmail();
        $password = $user->getPassword();

        $passwordPattern = "/^.{4,}$/";
        $emailPattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

        if (!preg_match($emailPattern, $email)) {
            Error::emailinvalid();
            return false;
        }
        
        if (!preg_match($passwordPattern, $password)) {
            Error::passwordinvalid();
            return false;
        }

        return true;
    }

    public static function validRegistration($role, $first_name, $last_name, $email, $password, $phone_number)
    {
        $role = $user->$role->getRole();
        $first_name = $user->getFirstName();
        $last_name = $user->getLastName();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $phone_number = $user->getPhoneNumber();

        $emailPattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
        $passwordPattern = "/^.{4,}$/";
        $phonePattern = "/^\+?[0-9]{10,15}$/";

        if($role == ""){
            Error::roleinvalid();
            return false;
        }

        if($first_name == ""){
            Error::firstnameinvalid();
            return false;
        }

        if($last_name == ""){
            Error::lastnameinvalid();
            return false;
        }

        if (!preg_match($emailPattern, $email)) {
            Error::emailinvalid();
            return false;
        }

        if (!preg_match($passwordPattern, $password)) {
            Error::passwordinvalid();
            return false;
        }

        if (!preg_match($phonePattern, $phone_number)) {
            Error::phoneinvalid();
            return false;
        }

        return true;
    }
}
?>