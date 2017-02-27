<?php
declare(strict_types = 1);

class ContainsTest extends PHPUnit_Framework_TestCase
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

    //TODO: test case sensitive
    //TODO: test wrong encoding

}
