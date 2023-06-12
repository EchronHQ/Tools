<?php

declare(strict_types=1);

namespace Echron\Tools\StringHelper;

class MultiExplodeTest extends \PHPUnit\Framework\TestCase
{
    public function testBasic()
    {
        $this->assertEquals(['test'], \Echron\Tools\StringHelper::multiExplode([], 'test'));
        $this->assertEquals(['a', 'b', 'c'], \Echron\Tools\StringHelper::multiExplode(['/'], 'a/b/c'));
        $this->assertEquals(['a', 'b', 'c', 'd', 'e', 'f'], \Echron\Tools\StringHelper::multiExplode(['/', '+'], 'a/b/c+d+e/f'));
        $this->assertEquals(['a', 'b', 'c', 'd', 'e', 'f'], \Echron\Tools\StringHelper::multiExplode(['/', '-'], 'a/b/c-d-e/f'));
    }


}
