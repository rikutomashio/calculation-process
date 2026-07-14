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


        $totalMinutes = $this->calculateMinutes(
            $enterAt,
            $leaveAt
        );

        $courseMinutes = $courseType->minutes();

        // コース時間を超過した延長時間を算出する
        $overTimeMinutes = max(0, $totalMinutes - $courseMinutes);

        $extendStartTime = $enterAt->modify("+{$courseMinutes} minutes");

        $nightStartTime = $enterAt->setTime(22, 0);

        // 深夜延長料金の計算開始時刻を決定する
        $nightExtensionStart = $extendStartTime > $nightStartTime
            ? $extendStartTime
            : $nightStartTime;

        // 深夜時間帯に発生した延長時間を算出する
        if ($overTimeMinutes > 0 && $leaveAt > $nightStartTime) {
            $nightExtensionMinutes = $this->calculateMinutes(
                $nightExtensionStart,
                $leaveAt
            );
        } else {
            $nightExtensionMinutes = 0;
        }

        $numberOfNightExtensionCharges = (int) ceil($nightExtensionMinutes / 10);

        $nightExtensionCharge = (int) ($numberOfNightExtensionCharges * 100 * 1.15);

        // 通常時間帯の延長時間を算出する
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


    private function calculateMinutes(
        DateTimeImmutable $start,
        DateTimeImmutable $end
    ): int {
        $interval = $end->diff($start);

        return ($interval->days * 24 * 60)
            + ($interval->h * 60)
            + $interval->i;
    }
}
