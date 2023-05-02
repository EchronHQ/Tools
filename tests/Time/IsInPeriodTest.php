<?php
declare(strict_types=1);

namespace Echron\Tools\Time;
class IsInPeriodTest extends \PHPUnit\Framework\TestCase
{

    public function testWithFromOnly()
    {
        $from = new \DateTime('yesterday 12:00');
        $to = null;

        $result = \Echron\Tools\Time::isInPeriod($from, $to);
        $this->assertTrue($result);
    }

    public function testWithFromAndToInPast()
    {
        $from = new \DateTime('yesterday 12:00');
        $to = new \DateTime('yesterday 13:00');

        $result = \Echron\Tools\Time::isInPeriod($from, $to);
        $this->assertFalse($result);

        $result = \Echron\Tools\Time::isInPeriod($to, $from);
        $this->assertFalse($result);
    }

    public function testWithFromInPastAndToInFuture()
    {
        $from = new \DateTime('yesterday 12:00');
        $to = new \DateTime('tomorrow');

        $result = \Echron\Tools\Time::isInPeriod($from, $to);
        $this->assertTrue($result);

        $result = \Echron\Tools\Time::isInPeriod($to, $from);
        $this->assertTrue($result);
    }

    public function testTimeEqualsFromOrEqualsTo()
    {
        $from = new \DateTime('today 00:00');
        $to = new \DateTime('today 23:59');

        $result = \Echron\Tools\Time::isInPeriod($from, $to, $from);
        $this->assertTrue($result);

        $result = \Echron\Tools\Time::isInPeriod($to, $from, $from);
        $this->assertTrue($result);

        $result = \Echron\Tools\Time::isInPeriod($from, $to, $to);
        $this->assertTrue($result);

        $result = \Echron\Tools\Time::isInPeriod($to, $from, $to);
        $this->assertTrue($result);
    }

}
