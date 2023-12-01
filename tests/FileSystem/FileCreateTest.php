<?php

declare(strict_types=1);

namespace Echron\Tools\FileSystem;

use Echron\Tools\Exception\FileAlreadyExistsException;
use Echron\Tools\FileSystem;
use PHPUnit\Framework\TestCase;

class FileCreateTest extends TestCase
{
    public function testCreateDirectory()
    {
        $testDir = __DIR__ . DIRECTORY_SEPARATOR . 'tmp' . gmdate('U') . random_int(9999, 99999);

        $this->assertFileDoesNotExist($testDir);
        FileSystem::createDir($testDir);

        $this->assertFileExists($testDir);

        rmdir($testDir);
    }

    public function testCreateExisting()
    {
        $testDir = __DIR__ . DIRECTORY_SEPARATOR . 'tmp' . gmdate('U') . random_int(9999, 99999);

        $this->expectException(FileAlreadyExistsException::class);
        $this->expectExceptionMessage('Unable to create directory "' . $testDir . '": directory already exists');

        $this->assertFileDoesNotExist($testDir);
        FileSystem::createDir($testDir, true, 0777, false);
        $this->assertFileExists($testDir);

        FileSystem::createDir($testDir, true, 0777, false);
    }

    public function testCreateDirectory_NonExisting()
    {
        $this->expectException(\Exception::class);
        //TODO: find better way to get unexisting directory
        $testDir = 'X:\\tmp' . gmdate('U') . random_int(9999, 99999);
        FileSystem::createDir($testDir);
    }

//    public function testCreateDirectory_NoRights()
//    {
//        $this->expectException(\Exception::class);
//        //TODO: find better way to get directory without rights
//        $testDir = 'X:\\tmp' . gmdate('U') . random_int(9999, 99999);
//        FileSystem::createDir($testDir);
//    }
}
