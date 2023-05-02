<?php
declare(strict_types=1);

namespace Echron\Tools\FileSystem;

class FileReadableTest extends \PHPUnit\Framework\TestCase
{
    public function testIsReadable_NonExistingFile()
    {
        $isReadable = \Echron\Tools\FileSystem::isReadable('tmp');

        $this->assertFalse($isReadable);
    }
}
