<?php
declare(strict_types=1);

class GenerateGuidTest extends \PHPUnit\Framework\TestCase
{

    public function testNormal()
    {
        $result = \Echron\Tools\StringHelper::generateGuid();
        var_dump($result);
        echo $result;
        // $this->assertStringMatchesFormatFile($result);
    }

}
