<?php
declare(strict_types=1);

namespace Echron\Tools\Time;


use Echron\Tools\Time;
use PHPUnit\Framework\TestCase;

class IntervalTest extends TestCase
{

    public function testIntervalToSeconds(): void
    {
        $start = new \DateTime('now');
        $this->assertEquals(0, Time::intervalToSeconds($start->diff(new \DateTime('now'))));

        $start = new \DateTime('2019-04-21T19:25:00-0800');
        $this->assertEquals(1, Time::intervalToSeconds($start->diff(new \DateTime('2019-04-21T19:25:01-0800'))));

    }

    public function testSecondsToInterval(): void
    {
        $this->assertEquals('12:07:55', Time::secondsToInterval(43675)->format('%h:%I:%S'));
    }
}
