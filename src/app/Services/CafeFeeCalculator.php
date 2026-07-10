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

        $totalinterval = $leaveAt->diff($enterAt);

        $totalMinutes = ($totalinterval->days * 24 * 60)
            + ($totalinterval->h * 60)
            + $totalinterval->i;

        $courseMinutes = $courseType->minutes();

        $overTimeMinutes = max(0, $totalMinutes - $courseMinutes);

        $extendStartTime = $enterAt->modify("+{$courseMinutes} minutes");

        $nightTimeStart = $enterAt->setTime(22, 0);


        if ($extendStartTime > $nightTimeStart) {
            $nightExtensionStart = $extendStartTime;
        } else {
            $nightExtensionStart = $nightTimeStart;
        }

        if ($overTimeMinutes > 0 && $leaveAt > $nightTimeStart) {
            $interval = $leaveAt->diff($nightExtensionStart);
            $nightExtensionMinutes = ($interval->days * 24 * 60)
                + ($interval->h * 60)
                + $interval->i;
        } else {
            $nightExtensionMinutes = 0;
        }

        $numberOfNightExtensionCharges = (int) ceil($nightExtensionMinutes / 10);

        $nightExtensionCharge = (int) ($numberOfNightExtensionCharges * 100 * 1.15);

        $normalExtensionMinutes = $overTimeMinutes - $nightExtensionMinutes;

        $numberOfNormalExtensionCharges = (int) ceil($normalExtensionMinutes / 10);

        $extraCharge = (int) ($numberOfNormalExtensionCharges * 100);


        $subtotal = $basePrice + $extraCharge + $nightExtensionCharge;

        $tax = intval($subtotal * 0.1);

        $total = $subtotal + $tax;



        return [
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
        ];
    }
}
