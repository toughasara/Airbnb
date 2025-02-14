<?php
namespace App\Validators;

use App\Exceptions\ValidationException;

class ReservationValidator
{
    public function validate(array $data): void
    {
        $errors = [];

        // Validation des IDs
        if (!$this->validateId($data['user_id'])) {
            $errors['user_id'] = 'ID utilisateur invalide';
        }
        if (!$this->validateId($data['property_id'])) {
            $errors['property_id'] = 'ID propriété invalide';
        }

        // Validation des dates
        if (!$this->validateDates($data['start_date'], $data['end_date'])) {
            $errors['dates'] = 'Les dates sont invalides';
        }

        // Validation du prix
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
