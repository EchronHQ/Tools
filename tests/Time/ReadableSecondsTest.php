<?php
declare(strict_types=1);

class ReadableSecondsTest extends \PHPUnit\Framework\TestCase
{

    public function test3Hours()
    {
        $seconds = 10800;

        $result = \Echron\Tools\Time::readableSeconds($seconds);

        echo $result;
    }

}
