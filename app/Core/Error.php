<?php 

namespace App\Core;

class Error {

    public static function passwordMismatch() {
        $_SESSION['error'] = [
            'message'=> 'verifier votre mot de passe .'
        ];
        return ;
    }

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

    public static function findemail() {
        $_SESSION['error'] = [
            'message'=> 'cet email est deja inscrie , connectez vous .'
        ];
        return ;
    }

    public static function roleinvalid() {
        $_SESSION['error'] = [
            'message'=> 'veullez choisir votre role.'
        ];
        return ;
    }

    public static function firstnameinvalid() {
        $_SESSION['error'] = [
            'message'=> 'veullez remplir votre nom.'
        ];
        return ;
    }

    public static function lastnameinvalid() {
        $_SESSION['error'] = [
            'message'=> 'veullez remplir votre prenom.'
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