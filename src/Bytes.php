<?php

declare(strict_types=1);

namespace Echron\Tools;

class Bytes
{
    public static function readable(float $bytes, int $decimals = 4): string
    {
        $size = [
            'B',
            'kB',
            'MB',
            'GB',
            'TB',
            'PB',
            'EB',
            'ZB',
            'YB',
        ];
        $factor = (int)floor((strlen($bytes . '') - 1) / 3);

        //TODO: implement negative digits
        //        if ($decimals < 0) {
        //            $bytes = round($bytes / pow(1024, $factor), $decimals) . PHP_EOL;
        //            $decimals = 2;
        //        }

        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . $size[$factor];
    }
}
