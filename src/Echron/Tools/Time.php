<?php
declare(strict_types = 1);

namespace Echron\Tools;


class Time
{
    function readableSeconds(float $seconds, bool $short = false):string
    {
        $units = [7 * 24 * 3600 => ['long' => 'week', 'short' => 'w',], 24 * 3600 => ['long' => 'day', 'short' => 'd',], 600 => ['long' => 'hour', 'short' => 'h',], 60 => ['long' => 'minute', 'short' => 'm',], 1 => ['long' => 'second', 'short' => 's',],];
        // specifically handle zero
        if ($seconds === 0.0) {

            if ($short) {
                return '0s';
            } else {
                return '0 seconds';
            }
        }
        $s = '';
        foreach ($units as $divisor => $data) {
            //echo $seconds . ' ' . $divisor . PHP_EOL;
            if ($divisor !== 1) {
                $quot = intval($seconds / $divisor);
            } else {
                $quot = $seconds;
            }

            if ($quot) {
                $label = '';
                if ($short) {
                    $label = $data['short'];
                } else {
                    $label = ' ' . $data['long'];
                }

                if ($divisor === 1 && $quot < 1) {
                    $quot = number_format($quot, 2);
                }

                $s .= $quot . '' . $label;
                if (!$short) {
                    $s .= (abs($quot) === 1 ? '' : 's') . ', ';
                } else {
                    $s .= ' ';
                }

                $seconds -= $quot * $divisor;
            }
        }

        if (strlen($s) > 0) {
            if ($short) {
                $s = substr($s, 0, -1);
            } else {
                $s = substr($s, 0, -2);
            }
        }

        return $s;

    }
}
