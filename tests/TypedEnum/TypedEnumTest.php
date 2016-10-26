<?php
declare(strict_types = 1);

class TypedEnumTest extends PHPUnit_Framework_TestCase
{
    public function testValue()
    {
        $enum = TypedEnumImpl::OptionOne();

        $this->assertEquals(1, $enum->getValue());
    }

    public function testName()
    {
        $enum = TypedEnumImpl::OptionOne();

        $this->assertEquals(1, $enum->getName());
    }


}
