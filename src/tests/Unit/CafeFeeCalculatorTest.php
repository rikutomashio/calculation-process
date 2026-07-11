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

        $enterAt = new DateTimeImmutable('2026-07-08 18:00:00');
        $leaveAt = new DateTimeImmutable('2026-07-08 21:00:00');
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

    public function test_calculate_three_hours_course_normal_extension_fee()
    {
        // Arrange
        $calculator = new CafeFeeCalculator();

        $enterAt = new DateTimeImmutable('2026-07-08 18:00:00');
        $leaveAt = new DateTimeImmutable('2026-07-08 21:30:00');
        $courseType = CourseType::THREE_HOURS;

        // Act
        $result = $calculator->calculate(
            $enterAt,
            $leaveAt,
            $courseType
        );

        // Assert
        $this->assertSame(1100, $result['subtotal']);
        $this->assertSame(110, $result['tax']);
        $this->assertSame(1210, $result['total']);
    }

    public function test_calculate_three_hours_course_not_extension_fee()
    {
        // Arrange
        $calculator = new CafeFeeCalculator();

        $enterAt = new DateTimeImmutable('2026-07-08 20:30:00');
        $leaveAt = new DateTimeImmutable('2026-07-08 22:30:00');
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

    public function test_calculate_three_hours_course_night_extension_fee()
    {
        // Arrange
        $calculator = new CafeFeeCalculator();

        $enterAt = new DateTimeImmutable('2026-07-08 18:00:00');
        $leaveAt = new DateTimeImmutable('2026-07-08 23:00:00');
        $courseType = CourseType::THREE_HOURS;

        // Act
        $result = $calculator->calculate(
            $enterAt,
            $leaveAt,
            $courseType
        );

        // Assert
        $this->assertSame(2090, $result['subtotal']);
        $this->assertSame(209, $result['tax']);
        $this->assertSame(2299, $result['total']);
    }

    public function test_calculate_normal_course_one_minute_extension_fee()
    {
        // Arrange

        $calculator = new CafeFeeCalculator();

        $enterAt = new DateTimeImmutable('2026-07-08 10:00:00');
        $leaveAt = new DateTimeImmutable('2026-07-08 11:01:00');

        // Act

        $result = $calculator->calculate(
            $enterAt,
            $leaveAt,
            CourseType::NORMAL
        );

        // Assert
        $this->assertSame(600, $result['subtotal']);
        $this->assertSame(60, $result['tax']);
        $this->assertSame(660, $result['total']);
    }

    public function test_calculate_normal_course_ten_minutes_extension_fee()
    {
        // Arrange

        $calculator = new CafeFeeCalculator();

        $enterAt = new DateTimeImmutable('2026-07-08 10:00:00');
        $leaveAt = new DateTimeImmutable('2026-07-08 11:10:00');

        // Act

        $result = $calculator->calculate(
            $enterAt,
            $leaveAt,
            CourseType::NORMAL
        );

        // Assert
        $this->assertSame(600, $result['subtotal']);
        $this->assertSame(60, $result['tax']);
        $this->assertSame(660, $result['total']);
    }

    public function test_calculate_normal_course_eleven_minutes_extension_fee()
    {
        // Arrange
        $calculator = new CafeFeeCalculator();

        $enterAt = new DateTimeImmutable('2026-07-08 10:00:00');
        $leaveAt = new DateTimeImmutable('2026-07-08 11:11:00');

        // Act

        $result = $calculator->calculate(
            $enterAt,
            $leaveAt,
            CourseType::NORMAL
        );

        // Assert
        $this->assertSame(700, $result['subtotal']);
        $this->assertSame(70, $result['tax']);
        $this->assertSame(770, $result['total']);
    }
}
