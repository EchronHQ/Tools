<?php
declare(strict_types = 1);

class ReadableTest extends PHPUnit_Framework_TestCase
{

    public function testZero()
    {
        $result = \Echron\Tools\Bytes::readable(0);
        $this->assertEquals('0.0000B', $result);
    }

    public function testNegativeDigits()
    {
        $result = \Echron\Tools\Bytes::readable(302412, -2);
        $this->assertEquals('200.00B', $result);
    }

    public function testOneKilobyte()
    {
        $result = \Echron\Tools\Bytes::readable(1024);
        $this->assertEquals('1.0000kB', $result);

        $result = \Echron\Tools\Bytes::readable(1024, 2);
        $this->assertEquals('1.00kB', $result);
    }

    public function testOneMegaByte()
    {
        $result = \Echron\Tools\Bytes::readable(1024 * 1024);
        $this->assertEquals('1.0000MB', $result);

        $result = \Echron\Tools\Bytes::readable(1024 * 1024, 2);
        $this->assertEquals('1.00MB', $result);
    }

    public function testNegative()
    {
        $result = \Echron\Tools\Bytes::readable(-12);
        $this->assertEquals('-12.0000B', $result);

        $result = \Echron\Tools\Bytes::readable(-12, 2);
        $this->assertEquals('-12.00B', $result);

    }
}
