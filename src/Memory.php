<?php
declare(strict_types=1);

namespace Echron\Tools;

class Memory
{
    public static function getBytesAllocated(): int
    {
        return memory_get_usage();
    }

    public static function getBytesLimit(): int
    {
        $memory_limit = ini_get('memory_limit');

        return self::parseMemoryString($memory_limit);


    }

    private static function parseMemoryString(string $memoryString): int
    {
        $memoryString = trim($memoryString);
        $last = strtolower($memoryString[strlen($memoryString) - 1]);
        switch ($last) {
            // The 'G' modifier is available since PHP 5.1.0
            case 'g':
                $memoryString *= 1024 * 1024 * 1024;
                break;
            case 'm':
                $memoryString *= 1024 * 1024;
                break;
            case 'k':
                $memoryString *= 1024;
                break;
        }

        return $memoryString;
    }

}
