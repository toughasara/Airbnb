<?php
namespace App\Controllers\Front;
use App\Controllers\Controller;
use App\Services\ReservationService;
use App\Services\PaymentService;

class ReservationController extends Controller
{
    private $reservationService;
    private $paymentService;

    // Injection des dépendances
    public function __construct(ReservationService $reservationService, PaymentService $paymentService)
    {
        $this->reservationService = $reservationService;
        $this->paymentService = $paymentService;
    }
}