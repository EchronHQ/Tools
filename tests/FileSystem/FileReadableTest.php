<?php
declare(strict_types = 1);

class FileReadableTest extends \PHPUnit\Framework\TestCase
{
    public function testIsReadable()
    {
        \Echron\Tools\FileSystem::isReadable('tmp');
    }
}
