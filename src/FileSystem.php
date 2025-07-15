<?php

declare(strict_types=1);

namespace Echron\Tools;

use Echron\Tools\Exception\FileAlreadyExistsException;
use Echron\Tools\Exception\PermissionsDeniedException;

class FileSystem
{
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
                    $exception = new \Exception('Unknown exception while adding file content to file ' . $path);
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

    public static function touch(string $path, \DateTime|null $modificationTime = null, \DateTime|null $accessTime = null): void
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
                /** @noinspection PotentialMalwareInspection */
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
    public static function listFiles(string $path, bool $recursive = false): array
    {
        $files = [];
        if (is_dir($path)) {
            if ($recursive) {
                $directoryIterator = new \RecursiveDirectoryIterator($path);
                $iterator = new \RecursiveIteratorIterator($directoryIterator);
            } else {
                $directoryIterator = new \DirectoryIterator($path);
                $iterator = new \IteratorIterator($directoryIterator);
            }
            /** @var \SplFileInfo $file */
            foreach ($iterator as $file) {
                if ($file->getType() === 'file') {
                    $files[] = $file;
                }
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

        return preg_replace('#/+#', \DIRECTORY_SEPARATOR, implode(\DIRECTORY_SEPARATOR, $paths));
    }

    public static function copyDirectory(string $source, string $destination, bool $recursive = false): void
    {
        // open the source directory
        $dir = opendir($source);
        if ($dir === false) {
            throw new \Exception('Unable to read source directory');
        }

        // Make the destination directory if not exist
        self::createDir($destination);

        // Loop through the files in source directory
        while (false !== ($file = readdir($dir))) {
            if (($file !== '.') && ($file !== '..')) {
                if (is_dir($source . \DIRECTORY_SEPARATOR . $file)) {
                    // Recursively calling custom copy function
                    // for sub directory
                    if ($recursive) {
                        self::copyDirectory($source . \DIRECTORY_SEPARATOR . $file, $destination . \DIRECTORY_SEPARATOR . $file);
                    }
                } else {
                    copy($source . \DIRECTORY_SEPARATOR . $file, $destination . \DIRECTORY_SEPARATOR . $file);
                }
            }
        }

        closedir($dir);
    }

    public static function createDir(string $path, bool $recursive = true, int $permissions = 0777, bool $ignoreIfExists = true): void
    {
        if (self::dirExists($path)) {
            if ($ignoreIfExists) {
                return;
            }

            throw new FileAlreadyExistsException('Unable to create directory "' . $path . '": directory already exists');
        }
        $exception = null;
        $old = error_reporting(0);
        try {
            $created = mkdir($path, $permissions, $recursive);
            if (!$created) {
                if (ExceptionHelper::hasLastError()) {
                    $exception = ExceptionHelper::getLastError();
                } else {
                    $exception = new \Exception('Unable to create directory');
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

                case 'mkdir(): File exists':
                    throw new FileAlreadyExistsException('Unable to create directory "' . $path . '": directory already exists');

                default:
                    throw $exception;
            }
        }
    }

    public static function dirExists(string $path, bool $clearStatCache = false): bool
    {
        if ($clearStatCache) {
            clearstatcache(true, $path);
        }

        return file_exists($path) && is_dir($path);
    }

    public static function getFileModificationTime(string $fileName): int
    {
        $exception = null;
        $old = error_reporting(0);
        try {
            $time = \filemtime($fileName);
            if ($time === false) {
                if (ExceptionHelper::hasLastError()) {
                    $exception = ExceptionHelper::getLastError();
                }
            }
        } catch (\Throwable $ex) {
            $exception = $ex;
        }
        error_reporting($old);

        if ($exception !== null) {
            //            switch ($exception->getMessage()) {
            //                case 'mkdir(): Permissions denied':
            //                    throw new PermissionsDeniedException('Unable to create directory "' . $path . '": permissions denied');
            //                    break;
            //                case 'mkdir(): File exists':
            //                    throw new FileAlreadyExistsException('Unable to create directory "' . $path . '": directory already exists');
            //                    break;
            //                default:
            throw $exception;
            //            }
        }

        return 0;
    }
}
