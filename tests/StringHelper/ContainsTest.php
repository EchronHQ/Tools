<?php

declare(strict_types=1);

namespace Echron\Tools\StringHelper;

class ContainsTest extends \PHPUnit\Framework\TestCase
{
    public function testNot()
    {
        $result = \Echron\Tools\StringHelper::contains('abcdef123', 'zx');
        $this->assertFalse($result);

        $result = \Echron\Tools\StringHelper::contains('abcdef123', 'ZX');
        $this->assertFalse($result);

    }

    public function testPartial()
    {
        $result = \Echron\Tools\StringHelper::contains('abcdef123', 'abe');
        $this->assertFalse($result);
        $result = \Echron\Tools\StringHelper::contains('abcdef123', 'ABE');
        $this->assertFalse($result);
    }

    public function testFull()
    {
        $result = \Echron\Tools\StringHelper::contains('abcdef123', 'abc');
        $this->assertTrue($result);
        //
        $result = \Echron\Tools\StringHelper::contains('abcdef123', 'Abc');
        $this->assertTrue($result);
    }

    public function testFull_middle()
    {
        $result = \Echron\Tools\StringHelper::contains('abcdef123', 'abc');
        $this->assertTrue($result);

        $result = \Echron\Tools\StringHelper::contains('abcdef123', 'AbC');
        $this->assertTrue($result);
    }

    public function testEquals()
    {
        $result = \Echron\Tools\StringHelper::contains('abcdef123', 'abcdef123');
        $this->assertTrue($result);

        $result = \Echron\Tools\StringHelper::contains('abcdef123', 'aBcdeF123');
        $this->assertTrue($result);
    }



    //TODO: test case sensitive
    //TODO: test wrong encoding

}
