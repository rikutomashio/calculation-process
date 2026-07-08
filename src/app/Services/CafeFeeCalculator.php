<?php

namespace App\Services;

use App\Enums\CourseType;
use DateTimeImmutable;

class CafeFeeCalculator
{
    public function calculate(
        DateTimeImmutable $enterAt,
        DateTimeImmutable $leaveAt,
        CourseType $courseType
    ): array {
        $basePrice = $courseType->price();

        $tax = intval($basePrice * 0.1);

        $total = $basePrice + $tax;

        return [
            'subtotal' => $basePrice,
            'tax' => $tax,
            'total' => $total,
        ];
    }
}
