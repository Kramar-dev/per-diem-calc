<?php

namespace App;

use App\Http\Controllers\PerDiemCalculator;
use Tests\TestCase;

class PerDiemCalculatorTest extends TestCase
{

    public function testCalculatePerDiemAmount()
    {
        $act = PerDiemCalculator::calculatePerDiemAmount('PL', '2023-11-10 16:00:00');
        $this->assertEquals('10', $act);

        $act = PerDiemCalculator::calculatePerDiemAmount('DE', '2023-11-10 16:00:00');
        $this->assertEquals('50', $act);

        $act = PerDiemCalculator::calculatePerDiemAmount('GB', '2023-11-10 16:00:00');
        $this->assertEquals('75', $act);
    }

    public function testIsMoreThanEightHours()
    {
        $act = PerDiemCalculator::isMoreThanEightHours('2023-11-01 08:00:00', '2023-11-01 19:00:00');
        $this->assertTrue($act);

        $act = PerDiemCalculator::isMoreThanEightHours('2023-11-01 08:00:00', '2023-11-01 13:00:00');
        $this->assertFalse($act);
    }

}
