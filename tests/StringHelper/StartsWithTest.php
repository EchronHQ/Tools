<?php
declare(strict_types=1);

namespace Echron\Tools\StringHelper;

class StartsWithTest extends \PHPUnit\Framework\TestCase
{
    public function testEmptyHaystack()
    {
        $result = \Echron\Tools\StringHelper::startsWith('', 'zx');
        $this->assertFalse($result);
    }

    public function testEmptyNeedle()
    {
        $result = \Echron\Tools\StringHelper::startsWith('abcdef123', '');
        $this->assertTrue($result);
    }

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
