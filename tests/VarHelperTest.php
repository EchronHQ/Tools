<?php
declare(strict_types=1);

class VarHelperTest extends \PHPUnit\Framework\TestCase
{
    public function testInteger()
    {
        $result = \Echron\Tools\VarHelper::getType(0);
        $this->assertEquals('integer', $result);
    }

    public function testString()
    {
        $result = \Echron\Tools\VarHelper::getType('test');
        $this->assertEquals('string', $result);
    }

    public function testNull()
    {
        $result = \Echron\Tools\VarHelper::getType(null);
        $this->assertEquals('NULL', $result);
    }

    public function testArray()
    {
        $object = [];

        $result = \Echron\Tools\VarHelper::getType($object);
        $this->assertEquals('array', $result);
    }

    public function testObjectDontReturnClass()
    {
        $object = new stdClass();

        $result = \Echron\Tools\VarHelper::getType($object, false);
        $this->assertEquals('object', $result);
    }

    public function testObjectReturnClass()
    {
        $object = new stdClass();

        $result = \Echron\Tools\VarHelper::getType($object);
        $this->assertEquals('stdClass', $result);
    }
}