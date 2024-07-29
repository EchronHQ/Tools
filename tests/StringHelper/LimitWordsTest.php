<?php

declare(strict_types=1);

namespace Echron\Tools\StringHelper;

class LimitWordsTest extends \PHPUnit\Framework\TestCase
{
    public function testNormalString()
    {
        $result = \Echron\Tools\StringHelper::limitWords('This is a basic string', 2);
        $this->assertEquals('', $result);

        $result = \Echron\Tools\StringHelper::limitWords('This is a basic string', 4);
        $this->assertEquals('This', $result);

        $result = \Echron\Tools\StringHelper::limitWords('This is a basic string', 20);
        $this->assertEquals('This is a basic', $result);

        $result = \Echron\Tools\StringHelper::limitWords('This is a basic string', 25);
        $this->assertEquals('This is a basic string', $result);
    }

    public function testWithEnd()
    {
        $result = \Echron\Tools\StringHelper::limitWords('This is a basic string', 2, ' ...');
        $this->assertEquals('', $result);

        $result = \Echron\Tools\StringHelper::limitWords('This is a basic string', 4, ' ...');
        $this->assertEquals('This', $result);

        $result = \Echron\Tools\StringHelper::limitWords('This is a basic string', 20, ' ...');
        $this->assertEquals('This is a basic ...', $result);

        $result = \Echron\Tools\StringHelper::limitWords('This is a basic string', 25, ' ...');
        $this->assertEquals('This is a basic string', $result);
    }


}
