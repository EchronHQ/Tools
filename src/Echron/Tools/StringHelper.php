<?php
declare(strict_types = 1);

namespace Echron\Tools;

class StringHelper
{
    public static function startsWith(string $haystack, string $needle):bool
    {
        return $needle === '' || strrpos($haystack, $needle, -strlen($haystack)) !== false;
    }

    public static function mask(string $target, string $mask = '*', int $showStartCharacters = 2, int $showEndCharacters = 2):string
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
            $masked = substr($target, 0, $showStartCharacters) . '' . substr($masked, $showStartCharacters, -$showEndCharacters) . '' . substr($target, -$showEndCharacters, $showEndCharacters);
        }

        return $masked;
    }
}
