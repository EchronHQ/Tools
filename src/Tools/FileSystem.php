<?php
declare(strict_types = 1);

namespace Tools;

class FileSystem
{
    public static function createDir(string $path, bool $recursive = true, $mode = 0777)
    {
        $exception = null;
        $old = error_reporting(0);
        try {

            $created = mkdir($path, $mode, $recursive);
            if (!$created) {
                $error = error_get_last();
                if ($error !== null) {
                    $exception = new \Exception($error['message']);
                }
            }

        } catch (\Throwable $ex) {
            $exception = $ex;
        }
        error_reporting($old);

        if ($exception !== null) {
            if ($exception->getMessage() === 'mkdir(): Permissions denied') {
                throw new PermissionsDeniedException();
            } else {
                throw $exception;
            }

        }

    }
}
