<?php
declare(strict_types = 1);

namespace Echron\Tools;

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
            if ($exception->getMessage() === 'mkdir(): Permissions denied') {
                throw new PermissionsDeniedException('Unable to create directory "' . $path . '"');
            } else {
                throw $exception;
            }

        }

    }

    public static function isReadable(string $path):bool
    {
        return is_readable($path);
    }

    public static function isWritable(string $path):bool
    {
        return is_writable($path);
    }

    public static function dirExists(string $path):bool
    {
        return file_exists($path) && is_dir($path);
    }

    public static function fileExists(string $path):bool
    {
        return file_exists($path) && is_file($path);
    }

}
