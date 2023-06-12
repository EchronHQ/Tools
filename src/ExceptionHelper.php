<?php

declare(strict_types=1);

namespace Echron\Tools;

class ExceptionHelper
{
    /**
     * @return \Exception
     * http://php.net/manual/en/function.error-get-last.php
     */
    public static function getLastError(): \Exception
    {

        $error = error_get_last();
        if ($error !== null) {
            $message = 'Unknown exception';
            if (isset($error['message'])) {
                $message = $error['message'];
            }

            //TODO: set exception file and line
            return new \Exception($message);
        }

        return new \Exception('Unknown exception');
    }

    public static function hasLastError(): bool
    {
        $error = error_get_last();

        return $error !== null;
    }
}
