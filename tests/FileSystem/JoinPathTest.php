<?php

declare(strict_types=1);

namespace Echron\Tools\FileSystem;

class JoinPathTest extends \PHPUnit\Framework\TestCase
{
    public function test()
    {
        $result = \Echron\Tools\FileSystem::joinPath('a', 'b', 'c');
        $this->assertEquals('a' . DIRECTORY_SEPARATOR . 'b' . DIRECTORY_SEPARATOR . 'c', $result);
        $result = \Echron\Tools\FileSystem::joinPath('a', 'b/', 'c');
        $this->assertEquals('a' . DIRECTORY_SEPARATOR . 'b' . DIRECTORY_SEPARATOR . 'c', $result);
        $result = \Echron\Tools\FileSystem::joinPath('a', '/b/', 'c');
        $this->assertEquals('a' . DIRECTORY_SEPARATOR . 'b' . DIRECTORY_SEPARATOR . 'c', $result);
        $result = \Echron\Tools\FileSystem::joinPath('a', '/b/c', 'd');
        $this->assertEquals('a' . DIRECTORY_SEPARATOR . 'b' . DIRECTORY_SEPARATOR . 'c' . DIRECTORY_SEPARATOR . 'd', $result);
    }
}
