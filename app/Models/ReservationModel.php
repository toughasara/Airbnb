<?php
namespace App\Models;

use PDO;
use App\Classes\Reservation;
use App\Config\Database;

class ReservationModel
{



    private $conn;

    public function __construct()
    {
        
        $db = Database::getInstance();
        $this->conn = $db->connect();

    }

    /**
     * Insère une nouvelle réservation en base de données.
     */
    public function insertReservation(Reservation $reservation): ?int
    {
        $sql = "INSERT INTO booking (user_id, property_id, check_in_date, check_out_date, total_price, status) 
                VALUES (:user_id, :property_id, :start_date, :end_date, :total_price, :status) RETURNING id";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':user_id', $reservation->getUserId(), PDO::PARAM_INT);
        $stmt->bindValue(':property_id', $reservation->getPropertyId(), PDO::PARAM_INT);
        $stmt->bindValue(':start_date', $reservation->getStartDate());
        $stmt->bindValue(':end_date', $reservation->getEndDate());
        $stmt->bindValue(':total_price', $reservation->getTotalPrice());
        $stmt->bindValue(':status', $reservation->getStatus());

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return null;
    }

    /**
     * Met à jour une réservation après un paiement réussi.
     */
    public function confirmReservation(int $id, string $transactionId): bool
    {
        $sql = "UPDATE booking SET status = 'confirmed', paypal_transaction_id = :transaction_id WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':transaction_id', $transactionId);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Trouve une réservation en attente.
     */
    public function findPendingReservation(int $user_id, int $property_id, string $start_date, string $end_date): ?Reservation
    {
        $sql = "SELECT * FROM booking WHERE user_id = :user_id AND property_id = :property_id 
                AND check_in_date = :start_date AND check_out_date = :end_date AND status = 'pending'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':property_id', $property_id, PDO::PARAM_INT);
        $stmt->bindValue(':start_date', $start_date);
        $stmt->bindValue(':end_date', $end_date);

        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $reservation = new Reservation();
            $reservation->setUserId($data['user_id']);
            $reservation->setPropertyId($data['property_id']);
            $reservation->setStartDate($data['check_in_date']);
            $reservation->setEndDate($data['check_out_date']);
            $reservation->setTotalPrice((float) $data['total_price']);
            $reservation->setStatus($data['status']);
            return $reservation;
        }

        return null;
    }
}

