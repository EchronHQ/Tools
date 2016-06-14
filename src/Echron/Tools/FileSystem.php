<?php
declare(strict_types = 1);

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

    public static function isReadable(string $path, bool $clearStatCache = false):bool
    {
        if ($clearStatCache) {
            clearstatcache(true, $path);
        }

        return is_readable($path);
    }

    public static function isWritable(string $path, bool $clearStatCache = false):bool
    {
        if ($clearStatCache) {
            clearstatcache(true, $path);
        }

        return is_writable($path);
    }

    public static function dirExists(string $path, bool $clearStatCache = false):bool
    {
        if ($clearStatCache) {
            clearstatcache(true, $path);
        }

        return file_exists($path) && is_dir($path);
    }

    public static function fileExists(string $path, bool $clearStatCache = false):bool
    {
        if ($clearStatCache) {
            clearstatcache(true, $path);
        }

        return file_exists($path) && is_file($path);
    }

}
