<?php

declare(strict_types=1);

namespace Echron\Tools\Time;

class InRangeTest extends \PHPUnit\Framework\TestCase
{
    public function testFrom()
    {
        $from = strtotime('yesterday 12:00');
        $to = null;

        $result = \Echron\Tools\Time::todayInRange($from, $to);
        $this->assertTrue($result);
    }

    public function testFrom2()
    {
        $from = strtotime('yesterday 12:00');
        $to = strtotime('yesterday 13:00');
        ;

        $result = \Echron\Tools\Time::todayInRange($from, $to);
        $this->assertFalse($result);
    }

    public function testFrom3()
    {
        $from = strtotime('yesterday 12:00');
        $to = strtotime('today 13:00');

        $result = \Echron\Tools\Time::todayInRange($from, $to);
        $this->assertTrue($result);
    }

    public function testFrom4()
    {
        $from = strtotime('yesterday 12:00');
        $to = strtotime('tomorrow 13:00');

        $result = \Echron\Tools\Time::todayInRange($from, $to);
        $this->assertTrue($result);
    }

    public function testFrom5()
    {
        $from = strtotime('today 00:00');
        $to = strtotime('today 23:59');

        $result = \Echron\Tools\Time::todayInRange($from, $to);
        $this->assertTrue($result);
    }

    public function testFrom6()
    {
        $from = strtotime('today 00:00');
        $to = null;

        $result = \Echron\Tools\Time::todayInRange($from, $to);
        $this->assertTrue($result);
    }

    public function testFrom7()
    {
        $from = null;
        $to = null;

        $result = \Echron\Tools\Time::todayInRange($from, $to);
        $this->assertTrue($result);
    }

    public function testFrom8()
    {
        $from = null;
        $to = strtotime('today 23:59');

        $result = \Echron\Tools\Time::todayInRange($from, $to);
        $this->assertTrue($result);
    }

    //    public function testFrom7()
    //    {
    //        $from = strtotime('today 12:00');
    //        $to = strtotime('today 23:59');
    //
    //        $result = \Echron\Tools\Time::todayInRange($from, $to);
    //        $this->assertTrue($result);
    //    }
}
