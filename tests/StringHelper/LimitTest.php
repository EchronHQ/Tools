<?php

declare(strict_types=1);

namespace Echron\Tools\StringHelper;

class LimitTest extends \PHPUnit\Framework\TestCase
{
    public function testNormalString()
    {
        $result = \Echron\Tools\StringHelper::limit('This is a basic string', 2);
        $this->assertEquals('Th', $result);

        $result = \Echron\Tools\StringHelper::limit('This is a basic string', 5);
        $this->assertEquals('This ', $result);

        $result = \Echron\Tools\StringHelper::limit('This is a basic string', 20);
        $this->assertEquals('This is a basic stri', $result);

        $result = \Echron\Tools\StringHelper::limit('This is a basic string', 25);
        $this->assertEquals('This is a basic string', $result);
    }

    public function testWithEnd()
    {
        // $result = \Echron\Tools\StringHelper::limit('This is a basic string', 2, ' ...');
        // $this->assertEquals('Th', $result);

        $result = \Echron\Tools\StringHelper::limit('This is a basic string', 5, ' ...');
        $this->assertEquals('T ...', $result);

        $result = \Echron\Tools\StringHelper::limit('This is a basic string', 20, ' ...');
        $this->assertEquals('This is a basic  ...', $result);

        $result = \Echron\Tools\StringHelper::limit('This is a basic string', 25, ' ...');
        $this->assertEquals('This is a basic string', $result);
    }


}
