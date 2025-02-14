<?php

namespace App\Controllers;

use App\Services\ReservationService;
use App\Services\PaymentService;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ReservationController
{
    protected $twig;
    protected $reservationService;
    protected $paymentService;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../Views');
        $this->twig = new Environment($loader, ['cache' => false]);
        $this->reservationService = new ReservationService();
        $this->paymentService = new PaymentService();
    }

    /**
     * Gère la création de réservation et redirige vers PayPal pour le paiement.
     */
    public function showReservationForm()
    {

        echo $this->twig->render('Front/reservation.twig');
        exit;

    }
    public function processReservation()
    {
        try {
            // Vérifier que les champs requis sont présents
            $requiredFields = ['user_id', 'property_id', 'start_date', 'end_date', 'total_price'];
            foreach ($requiredFields as $field) {
                if (empty($_POST[$field])) {
                    throw new \Exception("Le champ $field est requis.");
                }
            }

            // Nettoyer et préparer les données
            $data = [
                'user_id' => (int) $_POST['user_id'],
                'property_id' => (int) $_POST['property_id'],
                'start_date' => $_POST['start_date'],
                'end_date' => $_POST['end_date'],
                'total_price' => floatval($_POST['total_price']),
            ];

            // Enregistrer la réservation
            $reservation = $this->reservationService->createReservation($data);

            if (!$reservation) {
                throw new \Exception("Erreur lors de la création de la réservation.");
            }

            // Créer le paiement PayPal
            $paymentResponse = $this->paymentService->createPayment($data['total_price']);

            if (!$paymentResponse['success']) {
                throw new \Exception("Erreur PayPal : " . $paymentResponse['error']);
            }

            // Rediriger vers la page de paiement PayPal
            header("Location: " . $paymentResponse['approval_url']);
            exit();

        } catch (\Exception $e) {
            echo "Une erreur est survenue : " . $e->getMessage();
        }
    }

    /**
     * Vérifie la validation du paiement PayPal et confirme la réservation.
     */
    public function confirmPayment()
    {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
    
            // 🔴 Vérifier si l'ID de transaction PayPal est présent
            if (!isset($data['paypal_transaction_id']) || empty($data['paypal_transaction_id'])) {
                throw new \Exception("🚨 Le paiement PayPal a échoué (pas de transaction ID).");
            }
    
            // 🔴 Vérifier les données requises
            if (!isset($data['user_id'], $data['property_id'], $data['start_date'], $data['end_date'], $data['total_price'])) {
                throw new \Exception("🚨 Données de réservation manquantes.");
            }
    
            // 🔍 Debug : afficher les données reçues
            error_log("🟢 Données reçues: " . json_encode($data));
    
            // Mettre à jour la réservation
            $reservationService = new ReservationService();
            $success = $reservationService->confirmReservation($data);
    
            if ($success) {
                echo json_encode(["success" => true, "message" => "Réservation confirmée !"]);
            } else {
                throw new \Exception("🚨 Échec de la mise à jour de la réservation en base.");
            }
        } catch (\Exception $e) {
            error_log("⚠️ Erreur: " . $e->getMessage());
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
    }
    
}
