<?php

declare(strict_types=1);

namespace Echron\Tools\Time;

class ReadableSecondsTest extends \PHPUnit\Framework\TestCase
{
    public function test3Hours()
    {
        $seconds = 10800;

        $result = \Echron\Tools\Time::readableSeconds($seconds);

        $this->assertEquals('3 hours', $result);
    }

    public function testMilliseconds()
    {


        $this->assertEquals('0.80 seconds', \Echron\Tools\Time::readableSeconds(0.8));
        $this->assertEquals('0 seconds', \Echron\Tools\Time::readableSeconds(0));
        $this->assertEquals('3.42 seconds', \Echron\Tools\Time::readableSeconds(3.4221580028534));
        $this->assertEquals('1 minute', \Echron\Tools\Time::readableSeconds(60));
        $this->assertEquals('1m', \Echron\Tools\Time::readableSeconds(60, true));
        $this->assertEquals('1 minute 3.42 seconds', \Echron\Tools\Time::readableSeconds(60 + 3.4221580028534));
        $this->assertEquals('1m 3.42s', \Echron\Tools\Time::readableSeconds(60 + 3.4221580028534, true));
    }
}
