<?php
namespace App\Services;

use App\Classes\Reservation;
use App\Models\ReservationModel;

class ReservationService
{
    private ReservationModel $reservationModel;

    public function __construct()
    {
        $this->reservationModel = new ReservationModel();
    }


    public function createReservation(array $data): ?Reservation
    {
        if (!$this->validateReservationData($data)) {
            return null;
        }

        $reservation = new Reservation();
        $reservation->setUserId((int)$data['user_id']);
        $reservation->setPropertyId((int)$data['property_id']);
        $reservation->setStartDate($data['start_date']);
        $reservation->setEndDate($data['end_date']);
        $reservation->setTotalPrice((float)$data['total_price']);
        $reservation->setStatus('pending');

        $reservationId = $this->reservationModel->insertReservation($reservation);
        if ($reservationId) {
            return $reservation;
        }

        return null;
    }


    private function validateReservationData(array $data): bool
    {
        if (empty($data['user_id']) || empty($data['property_id']) || empty($data['start_date']) || empty($data['end_date']) || empty($data['total_price'])) {
            return false;
        }

        if (strtotime($data['end_date']) <= strtotime($data['start_date'])) {
            return false;
        }

        if ((float)$data['total_price'] <= 0) {
            return false;
        }

        return true;
    }


    public function confirmReservation(array $data): bool
    {
        $reservation = $this->reservationModel->findPendingReservation(
            (int) $data['user_id'],
            (int) $data['property_id'],
            $data['start_date'],
            $data['end_date']
        );

        if (!$reservation) {
            return false;
        }

        return $this->reservationModel->confirmReservation($reservation->getId(), $data['paypal_transaction_id']);
    }
}
