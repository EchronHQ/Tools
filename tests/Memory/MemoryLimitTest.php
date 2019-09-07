<?php
declare(strict_types=1);

class MemoryLimitTest extends \PHPUnit\Framework\TestCase
{
    public function testParseMemoryString()
    {
        $result = $this->invoiceStaticMethod(\Echron\Tools\Memory::class, 'parseMemoryString', ['128M']);
        $this->assertEquals(128 * 1024 * 1024, $result);

        $result = $this->invoiceStaticMethod(\Echron\Tools\Memory::class, 'parseMemoryString', ['2G']);
        $this->assertEquals(2 * 1024 * 1024 * 1024, $result);
    }

    public function invoiceStaticMethod($class, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass($class);
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs(null, $parameters);
    }

    public function invokeMethod(&$object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

}
