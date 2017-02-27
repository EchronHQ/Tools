<?php
declare(strict_types = 1);

class GenerateGuidTest extends PHPUnit_Framework_TestCase
{

    public function testNormal()
    {
        $result = \Echron\Tools\StringHelper::generateGuid();

        echo $result;
        // $this->assertStringMatchesFormatFile($result);
    }

}
