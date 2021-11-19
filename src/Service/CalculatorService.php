<?php

namespace App\Service;

class CalculatorService
{
    public function calculateBalance(float $value, int $userNumber): float
    {
        return round($value / $userNumber, 2);
    }
}