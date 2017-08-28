<?php

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
        $memory_limit = trim($memory_limit);
        $last = strtolower($memory_limit[strlen($memory_limit) - 1]);
        switch ($last) {
            // The 'G' modifier is available since PHP 5.1.0
            case 'g':
                $memory_limit *= 1024;
                break;
            case 'm':
                $memory_limit *= 1024;
                break;
            case 'k':
                $memory_limit *= 1024;
                break;
        }

        return $memory_limit;
//        if (preg_match('/^(\d+)(.)$/', $memory_limit, $matches)) {
//            if ($matches[2] == 'M') {
//                $memory_limit = $matches[1] * 1024 * 1024; // nnnM -> nnn MB
//            } else if ($matches[2] == 'K') {
//                $memory_limit = $matches[1] * 1024; // nnnK -> nnn KB
//            }
//        }

    }

}