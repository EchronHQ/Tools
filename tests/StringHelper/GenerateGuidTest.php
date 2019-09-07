<?php
declare(strict_types = 1);

class GenerateGuidTest extends \PHPUnit\Framework\TestCase
{

    public function testNormal()
    {
        $result = \Echron\Tools\StringHelper::generateGuid();

        echo $result;
        // $this->assertStringMatchesFormatFile($result);
    }

}
