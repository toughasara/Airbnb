<?php 

namespace App\Core;

class Error {

    public static function erreurgoogle() {
        $_SESSION['error'] = [
            'message'=> 'invalid Email'
        ];
        return ;
    }

    public static function affichiererreur() {
        $_SESSION['error'] = [
            'message'=> 'invalid Email or Password '
        ];
        return ;
    }

    public static function emailinvalid() {
        $_SESSION['error'] = [
            'message'=> 'Invalid email.'
        ];
        return ;
    }

    public static function passwordinvalid() {
        $_SESSION['error'] = [
            'message'=> 'Password must be at least 4 characters long.'
        ];
        return ;
    }
}


?>