<?php

declare(strict_types=1);

namespace Echron\Tools\StringHelper;

class GenerateRandom extends \PHPUnit\Framework\TestCase
{
    public function testNormal()
    {
        $result = \Echron\Tools\StringHelper::generateRandom();
        var_dump($result);
        // Test if it contains minimum 1 lowercase, 1 uppercase letter and 1 number
        $this->assertEquals(8, strlen($result));
    }

}
