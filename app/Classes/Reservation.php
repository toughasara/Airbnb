<?php
namespace App\Classes;

class Reservation
{
    private int $id;
    private int $user_id;
    private int $property_id;
    private string $start_date;
    private string $end_date;
    private float $total_price;
    private string $status = 'pending';
    private ?string $paypal_transaction_id = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getPropertyId(): int
    {
        return $this->property_id;
    }

    public function setPropertyId(int $property_id): void
    {
        $this->property_id = $property_id;
    }

    public function getStartDate(): string
    {
        return $this->start_date;
    }

    public function setStartDate(string $start_date): void
    {
        $this->start_date = $start_date;
    }

    public function getEndDate(): string
    {
        return $this->end_date;
    }

    public function setEndDate(string $end_date): void
    {
        $this->end_date = $end_date;
    }

    public function getTotalPrice(): float
    {
        return $this->total_price;
    }

    public function setTotalPrice(float $total_price): void
    {
        $this->total_price = $total_price;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getPaypalTransactionId(): ?string
    {
        return $this->paypal_transaction_id;
    }

    public function setPaypalTransactionId(string $transaction_id): void
    {
        $this->paypal_transaction_id = $transaction_id;
    }
}
