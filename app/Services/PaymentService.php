<?php
namespace App\Services;

require_once __DIR__ . "/../../vendor/autoload.php";

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;

class PaymentService
{
    private $client;

    public function __construct()
    {
        error_reporting(E_ALL & ~E_DEPRECATED);
        
        try {
            $environment = new SandboxEnvironment('CLIENT_ID', 'CLIENT_SECRET');
            $this->client = new PayPalHttpClient($environment);
        } catch (\Exception $e) {
            throw new \Exception('Erreur de configuration PayPal');
        }
    }

    private function cleanAmount($amount)
    {
        if (is_string($amount)) {
            $amount = str_replace([' ', ','], ['', '.'], $amount);
            return floatval($amount);
        }
        return $amount;
    }

    public function createPayment($amount, $currency = 'EUR')
    {
        try {
            $amount = $this->cleanAmount($amount);

            if (!is_numeric($amount) || $amount <= 0) {
                return [
                    'success' => false,
                    'error' => 'Le montant doit être un nombre positif'
                ];
            }

            $formattedAmount = number_format($amount, 2, '.', '');

            $request = new OrdersCreateRequest();
            $request->prefer('return=representation');
            $request->body = [
                'intent' => 'CAPTURE',
                'purchase_units' => [[
                    'amount' => [
                        'currency_code' => $currency,
                        'value' => $formattedAmount
                    ]
                ]]
            ];

            $response = $this->client->execute($request);

            foreach ($response->result->links as $link) {
                if ($link->rel === 'approve') {
                    return [
                        'success' => true,
                        'approval_url' => $link->href
                    ];
                }
            }

            return [
                'success' => false,
                'error' => 'Impossible de créer le paiement PayPal'
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Erreur lors de la création du paiement : ' . $e->getMessage()
            ];
        }
    }
}