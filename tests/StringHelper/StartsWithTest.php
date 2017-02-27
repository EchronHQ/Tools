<?php
declare(strict_types = 1);

class StartsWithTest extends PHPUnit_Framework_TestCase
{

    public function testNone()
    {
        $result = \Echron\Tools\StringHelper::startsWith('abcdef123', 'zx');
        $this->assertFalse($result);
    }

    public function testPartial()
    {
        $result = \Echron\Tools\StringHelper::startsWith('abcdef123', 'bcd');
        $this->assertFalse($result);
    }

    public function testOneCaracter()
    {
        $result = \Echron\Tools\StringHelper::startsWith('abcdef123', 'a');
        $this->assertTrue($result);
    }

    public function testMultiCharacter()
    {
        $result = \Echron\Tools\StringHelper::startsWith('abcdef123', 'abcd');
        $this->assertTrue($result);
    }

}
