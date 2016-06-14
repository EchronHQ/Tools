<?php
declare(strict_types = 1);

class FileSystemTest extends PHPUnit_Framework_TestCase
{
    public function testCreateDirectory()
    {
        $testDir = 'tmp' . gmdate('U') . rand(9999, 99999);

        $this->assertFileNotExists($testDir);
        \Echron\Tools\FileSystem::createDir($testDir);

        $this->assertFileExists($testDir);

        unlink($testDir);
    }
}
