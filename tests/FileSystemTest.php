<?php
declare(strict_types = 1);

class FileSystemTest extends PHPUnit_Framework_TestCase
{
    public function testCreateDirectory()
    {
        $testDir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'tmp' . gmdate('U') . rand(9999, 99999);

        $this->assertFileNotExists($testDir);
        \Echron\Tools\FileSystem::createDir($testDir);

        $this->assertFileExists($testDir);

        rmdir($testDir);
    }

    public function testCreateExisting()
    {
        $this->expectException(\Echron\Tools\Exception\FileAlreadyExistsException::class);
        $testDir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'tmp' . gmdate('U') . rand(9999, 99999);

        $this->assertFileNotExists($testDir);
        \Echron\Tools\FileSystem::createDir($testDir);
        $this->assertFileExists($testDir);

        \Echron\Tools\FileSystem::createDir($testDir);

        rmdir($testDir);
    }

    public function testCreateDirectory_NonExisting()
    {
        $this->expectException(Exception::class);
        //TODO: find better way to get unexisting directory
        $testDir = 'X:tmp' . gmdate('U') . rand(9999, 99999);
        \Echron\Tools\FileSystem::createDir($testDir);
    }

    public function testCreateDirectory_NoRights()
    {
        $this->expectException(Exception::class);
        //TODO: find better way to get directory without rights
        $testDir = 'X:tmp' . gmdate('U') . rand(9999, 99999);
        \Echron\Tools\FileSystem::createDir($testDir);
    }
}
