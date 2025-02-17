<?php
<<<<<<< HEAD
namespace App\Validators;

use App\Exceptions\ValidationException;

class ReservationValidator
{
    public function validate(array $data): void
    {
        $errors = [];

        if (!$this->validateId($data['user_id'])) {
            $errors['user_id'] = 'ID utilisateur invalide';
        }
        if (!$this->validateId($data['property_id'])) {
            $errors['property_id'] = 'ID propriété invalide';
        }

        if (!$this->validateDates($data['start_date'], $data['end_date'])) {
            $errors['dates'] = 'Les dates sont invalides';
        }

        if (!$this->validatePrice($data['total_price'])) {
            $errors['total_price'] = 'Le prix total est invalide';
        }

        if (!empty($errors)) {
            throw new ValidationException('Données invalides', $errors);
        }
    }

    private function validateId($id): bool
    {
        return is_numeric($id) && $id > 0;
    }

    private function validateDates(string $startDate, string $endDate): bool
    {
        $start = strtotime($startDate);
        $end = strtotime($endDate);
        $today = strtotime('today');

        return $start && $end && $start >= $today && $end > $start;
    }

    private function validatePrice($price): bool
    {
        return is_numeric($price) && $price > 0;
    }
}
=======

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

    public static function validRegistration($user)
    {
        $role = $user->getRole()->getTitle();
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
