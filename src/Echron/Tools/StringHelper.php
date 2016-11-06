<?php
declare(strict_types = 1);

namespace Echron\Tools;

class StringHelper
{
    public static function startsWith(string $haystack, string $needle):bool
    {
        return $needle === '' || strrpos($haystack, $needle, -strlen($haystack)) !== false;
    }

    public static function mask(string $target, string $mask = '*', int $showStartCharacters = 0, int $showEndCharacters = 0):string
    {
        $length = strlen($target);
        $masked = str_repeat($mask, $length);

        if ($showStartCharacters < 0) {
            $showStartCharacters = 0;
        }
        if ($showEndCharacters < 0) {
            $showEndCharacters = 0;
        }

        if ($length > ($showStartCharacters + $showEndCharacters + 2)) {

            $start = '';
            if ($showStartCharacters > 0) {
                $start = substr($target, 0, $showStartCharacters);
            }

            $end = '';

            if ($showEndCharacters > 0) {

                $end = substr($target, -$showEndCharacters, $showEndCharacters);
                $masked = substr($masked, $showStartCharacters, -$showEndCharacters);
            } else {
                $masked = substr($masked, $showStartCharacters);
            }

            $masked = $start . $masked . $end;
        }

        return $masked;
    }
}
