<?php
declare(strict_types=1);

namespace Echron\Tools;

use Echron\Tools\Exception\FileAlreadyExistsException;
use Echron\Tools\Exception\PermissionsDeniedException;

class FileSystem
{
    public static function createDir(string $path, bool $recursive = true, $mode = 0777)
    {
        $exception = null;
        $old = error_reporting(0);
        try {
            $created = mkdir($path, $mode, $recursive);
            if (!$created) {
                if (ExceptionHelper::hasLastError()) {
                    $exception = ExceptionHelper::getLastError();
                }
            }
        } catch (\Throwable $ex) {
            $exception = $ex;
        }
        error_reporting($old);

        if ($exception !== null) {
            switch ($exception->getMessage()) {
                case 'mkdir(): Permissions denied':
                    throw new PermissionsDeniedException('Unable to create directory "' . $path . '": permissions denied');
                    break;
                case 'mkdir(): File exists':
                    throw new FileAlreadyExistsException('Unable to create directory "' . $path . '": directory already exists');
                    break;
                default:
                    throw $exception;
            }
        }
    }

    public static function isReadable(string $path, bool $clearStatCache = false): bool
    {
        if ($clearStatCache) {
            clearstatcache(true, $path);
        }

        return is_readable($path);
    }

    public static function isWritable(string $path, bool $clearStatCache = false): bool
    {
        if ($clearStatCache) {
            clearstatcache(true, $path);
        }

        return is_writable($path);
    }

    public static function dirExists(string $path, bool $clearStatCache = false): bool
    {
        if ($clearStatCache) {
            clearstatcache(true, $path);
        }

        return file_exists($path) && is_dir($path);
    }

    public static function fileExists(string $path, bool $clearStatCache = false): bool
    {
        if ($clearStatCache) {
            clearstatcache(true, $path);
        }

        return file_exists($path) && is_file($path);
    }

    public static function putFileContent(string $path, string $content): int
    {
        $exception = null;
        $oldErrorReporting = error_reporting(0);
        $bytesWritten = 0;
        try {
            $bytesWritten = file_put_contents($path, $content);
            if (!$bytesWritten) {
                if (ExceptionHelper::hasLastError()) {
                    $exception = ExceptionHelper::getLastError();
                } else {
                    $exception = new \Exception('Unknown exception while adding file content to file ' . $path . '');
                }
            }
        } catch (\Exception $ex) {
            $exception = new \Exception('Unable to add file content to file ' . $path . ': ' . $ex->getMessage());
        }

        error_reporting($oldErrorReporting);
        if ($exception) {
            throw $exception;
        }

        return $bytesWritten;
    }

    public static function touch(string $path, \DateTime $modificationTime = null, \DateTime $accessTime = null)
    {
        $exception = null;
        $old = error_reporting(0);
        try {
            $modificationTimeInt = null;
            if ($modificationTime !== null) {
                $modificationTimeInt = $modificationTime->getTimestamp();
            }
            $accessTimeInt = null;
            if ($accessTime !== null) {
                $accessTimeInt = $accessTime->getTimestamp();
            }
            $changed = false;
            if (!is_null($modificationTimeInt) && !\is_null($accessTimeInt)) {
                $changed = touch($path, $modificationTimeInt, $accessTimeInt);
            } elseif (!is_null($modificationTimeInt)) {
                $changed = touch($path, $modificationTimeInt);
            } else {
                $changed = touch($path);
            }
            if (!$changed) {
                if (ExceptionHelper::hasLastError()) {
                    $exception = ExceptionHelper::getLastError();
                }
            }
        } catch (\Throwable $ex) {
            $exception = $ex;
        }
        error_reporting($old);

        if ($exception !== null) {
            switch ($exception->getMessage()) {
//                case 'mkdir(): Permissions denied':
//                    throw new PermissionsDeniedException('Unable to create directory "' . $path . '": permissions denied');
//                    break;
//                case 'mkdir(): File exists':
//                    throw new FileAlreadyExistsException('Unable to create directory "' . $path . '": directory already exists');
//                    break;
                default:
                    throw $exception;
            }
        }
    }

    /**
     * @param string $path
     * @param bool $recursive
     * @return \SplFileInfo[]
     * @throws \Exception
     */
    public static function listFiles(string $path, bool $recursive = false)
    {
        $files = [];
        if (is_dir($path)) {
            if ($recursive) {
                $directoryIterator = new \RecursiveDirectoryIterator($path);
                $Iterator = new \RecursiveIteratorIterator($directoryIterator);

                /** @var \SplFileInfo $x */
                foreach ($Iterator as $x) {
                    $files[] = $x;
                }
            } else {
                throw new \Exception('Not implemented');
                // $iterator = new \DirectoryIterator($path);
            }
        }

        return $files;
    }
    public static function joinPath(...$segments): string
    {
        $paths = [];

        foreach ($segments as $segment) {
            if ($segment !== '') {
                $paths[] = $segment;
            }
        }

        return preg_replace('#/+#', \DIRECTORY_SEPARATOR, join(\DIRECTORY_SEPARATOR, $paths));
    }
}
