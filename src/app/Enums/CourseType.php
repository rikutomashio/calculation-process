<?php

namespace App\Enums;

enum CourseType: string
{
    case NORMAL = 'NORMAL';
    case THREE_HOURS = 'THREE_HOURS';
    case FIVE_HOURS = 'FIVE_HOURS';
    case EIGHT_HOURS = 'EIGHT_HOURS';

    public function price(): int
    {
        return match ($this) {
            self::NORMAL => 500,
            self::THREE_HOURS => 800,
            self::FIVE_HOURS => 1500,
            self::EIGHT_HOURS => 1900,
        };
    }

    public function minutes(): int
    {
        return match ($this) {
            self::NORMAL => 60,
            self::THREE_HOURS => 180,
            self::FIVE_HOURS => 300,
            self::EIGHT_HOURS => 480,
        };
    }
}
