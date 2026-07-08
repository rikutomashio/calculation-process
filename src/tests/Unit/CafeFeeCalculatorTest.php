<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\CafeFeeCalculator;
use App\Enums\CourseType;
use DateTimeImmutable;

class CafeFeeCalculatorTest extends TestCase
{
    public function test_calculate_normal_course_fee()
    {
        // Arrange
        $calculator = new CafeFeeCalculator();

        $enterAt = new DateTimeImmutable('2026-07-08 10:00:00');
        $leaveAt = new DateTimeImmutable('2026-07-08 10:30:00');
        $courseType = CourseType::NORMAL;

        // Act
        $result = $calculator->calculate(
            $enterAt,
            $leaveAt,
            $courseType
        );

        // Assert
        $this->assertSame(500, $result['subtotal']);
        $this->assertSame(50, $result['tax']);
        $this->assertSame(550, $result['total']);
    }

    public function test_calculate_three_hours_course_fee()
    {
        // Arrange
        $calculator = new CafeFeeCalculator();

        $enterAt = new DateTimeImmutable('2026-07-08 10:00:00');
        $leaveAt = new DateTimeImmutable('2026-07-08 10:30:00');
        $courseType = CourseType::THREE_HOURS;

        // Act
        $result = $calculator->calculate(
            $enterAt,
            $leaveAt,
            $courseType
        );

        // Assert
        $this->assertSame(800, $result['subtotal']);
        $this->assertSame(80, $result['tax']);
        $this->assertSame(880, $result['total']);
    }
}
