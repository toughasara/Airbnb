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

    /**
     * Crée une réservation en utilisant les setters et enregistre en base.
     * 
     * @param array $data Données de réservation
     * @return Reservation|null Retourne l'objet Reservation ou null si échec
     */
    public function createReservation(array $data): ?Reservation
    {
        if (!$this->validateReservationData($data)) {
            return null;
        }

        // Création d'une nouvelle instance de réservation
        $reservation = new Reservation();
        $reservation->setUserId((int)$data['user_id']);
        $reservation->setPropertyId((int)$data['property_id']);
        $reservation->setStartDate($data['start_date']);
        $reservation->setEndDate($data['end_date']);
        $reservation->setTotalPrice((float)$data['total_price']);
        $reservation->setStatus('pending'); // Statut par défaut

        // Enregistrer la réservation en base
        $reservationId = $this->reservationModel->insertReservation($reservation);
        if ($reservationId) {
            return $reservation;
        }

        return null;
    }

    /**
     * Valide les données de réservation avant l'enregistrement.
     * 
     * @param array $data
     * @return bool
     */
    private function validateReservationData(array $data): bool
    {
        if (empty($data['user_id']) || empty($data['property_id']) || empty($data['start_date']) || empty($data['end_date']) || empty($data['total_price'])) {
            return false;
        }

        if (strtotime($data['end_date']) <= strtotime($data['start_date'])) {
            return false; // La date de fin doit être après la date de début
        }

        if ((float)$data['total_price'] <= 0) {
            return false; // Le prix total doit être positif
        }

        return true;
    }

    /**
     * Confirme une réservation après un paiement réussi.
     * 
     * @param array $data Données de confirmation
     * @return bool
     */
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
