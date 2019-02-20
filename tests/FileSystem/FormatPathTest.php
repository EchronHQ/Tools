<?php
declare(strict_types=1);

class FormatPathTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $result = \Echron\Tools\FileSystem::formatPath('a', 'b', 'c');
        $this->assertEquals('a' . DIRECTORY_SEPARATOR . 'b' . DIRECTORY_SEPARATOR . 'c', $result);
        $result = \Echron\Tools\FileSystem::formatPath('a', 'b/', 'c');
        $this->assertEquals('a' . DIRECTORY_SEPARATOR . 'b' . DIRECTORY_SEPARATOR . 'c', $result);
        $result = \Echron\Tools\FileSystem::formatPath('a', '/b/', 'c');
        $this->assertEquals('a' . DIRECTORY_SEPARATOR . 'b' . DIRECTORY_SEPARATOR . 'c', $result);
    }
}
