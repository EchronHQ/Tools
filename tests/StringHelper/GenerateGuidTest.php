<?php

declare(strict_types=1);

namespace Echron\Tools\StringHelper;

use Echron\Tools\StringHelper;
use PHPUnit\Framework\TestCase;

class GenerateGuidTest extends TestCase
{
    public function testNormal()
    {
        $result = StringHelper::generateGuid();
        $this->assertEquals(strlen('b3e9b8b7-a046-4b5e-93c8-364e29420cbe'), strlen($result));
    }

}
