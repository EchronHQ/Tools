<?php
declare(strict_types=1);

class EndsWithTest extends \PHPUnit\Framework\TestCase
{
    public function testEmptyHaystack()
    {
        $result = \Echron\Tools\StringHelper::endsWith('', 'zx');
        $this->assertFalse($result);
    }

    public function testEmptyNeedle()
    {
        $result = \Echron\Tools\StringHelper::endsWith('abcdef123', '');
        $this->assertTrue($result);
    }

    public function testNone()
    {
        $result = \Echron\Tools\StringHelper::endsWith('abcdef123', 'zx');
        $this->assertFalse($result);
    }

    public function testPartial()
    {
        $result = \Echron\Tools\StringHelper::endsWith('abcdef123', 'bcd');
        $this->assertFalse($result);
    }

    public function testOneCaracter()
    {
        $result = \Echron\Tools\StringHelper::endsWith('abcdef123', '3');
        $this->assertTrue($result);
    }

    public function testMultiCharacter()
    {
        $result = \Echron\Tools\StringHelper::endsWith('abcdef123', 'f123');
        $this->assertTrue($result);
    }

}
