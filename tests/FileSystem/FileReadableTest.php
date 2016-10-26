<?php
declare(strict_types = 1);

class FileReadableTest extends PHPUnit_Framework_TestCase
{
    public function testIsReadable()
    {
        \Echron\Tools\FileSystem::isReadable('tmp');
    }
}
