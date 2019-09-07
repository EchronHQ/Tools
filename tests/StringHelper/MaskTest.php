<?php
declare(strict_types = 1);

class MaskTest extends \PHPUnit\Framework\TestCase
{

    public function testNormal()
    {
        $target = 'randomstring';
        $result = \Echron\Tools\StringHelper::mask($target);
        $this->assertEquals('************', $result);
        $this->assertEquals(strlen($target), strlen($result));
    }

    public function testShowTwoAtStart()
    {
        $target = 'randomstring';
        $result = \Echron\Tools\StringHelper::mask($target, '*', 2, 0);
        $this->assertEquals('ra**********', $result);
        $this->assertEquals(strlen($target), strlen($result));
    }

    public function testShowTwoAtEnd()
    {
        $target = 'randomstring';
        $result = \Echron\Tools\StringHelper::mask($target, '*', 0, 2);
        $this->assertEquals('**********ng', $result);
        $this->assertEquals(strlen($target), strlen($result));
    }

    public function testEmptyString()
    {
        $target = '';

        $result = \Echron\Tools\StringHelper::mask($target, '*', 0, 0);
        $this->assertEquals('', $result);
        $this->assertEquals(strlen($target), strlen($result));

        $result = \Echron\Tools\StringHelper::mask($target, '*', 2, 0);
        $this->assertEquals('', $result);
        $this->assertEquals(strlen($target), strlen($result));

        $result = \Echron\Tools\StringHelper::mask($target, '*', 0, 2);
        $this->assertEquals('', $result);
        $this->assertEquals(strlen($target), strlen($result));

        $result = \Echron\Tools\StringHelper::mask($target, '*', 2, 2);
        $this->assertEquals('', $result);
        $this->assertEquals(strlen($target), strlen($result));
    }
}
