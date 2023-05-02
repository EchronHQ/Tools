<?php
declare(strict_types=1);

namespace Echron\Tools;

class Time
{
    public static function readableSeconds(float $seconds, bool $short = false, int $precision = 2): string
    {

        $units = [
            7 * 24 * 60 * 60 => [
                'long'  => 'week',
                'short' => 'w',
            ],
            24 * 60 * 60     => [
                'long'  => 'day',
                'short' => 'd',
            ],
            60 * 60          => [
                'long'  => 'hour',
                'short' => 'h',
            ],
            60               => [
                'long'  => 'minute',
                'short' => 'm',
            ],
            1                => [
                'long'  => 'second',
                'short' => 's',
            ],
        ];
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
                $sQuot = $quot;
                if ($divisor === 1 && $quot < 1.0) {
                    $sQuot = number_format($quot, $precision);
                }


                $s .= $sQuot . '' . $label;
                if (!$short) {
                    $s .= (abs($quot) === 1 ? '' : 's') . ', ';
                } else {
                    $s .= ' ';
                }

                $seconds -= $sQuot * $divisor;
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

    public static function todayInRange(
        $periodStartDate,
        $periodEndDate,
        string $startTime = 'today 00:00',
        string $endTime = 'today 23:59'
    ): bool
    {
        $todayStart = gmdate('U', strtotime($startTime));
        $todayEnd = gmdate('U', strtotime($endTime));

        $result = false;

        if (\is_null($periodStartDate)) {
            $periodStartDate = gmdate('U', strtotime('yesterday'));
        }

        if (!\is_null($periodStartDate)) {
            $startTime = self::getTime($periodStartDate);
            $endTime = self::getTime($periodEndDate);

            if (($todayStart >= $startTime && $todayStart <= $endTime) || ($todayStart >= $startTime && is_null($endTime))) {
                $result = true;
            }
        }

        return $result;
    }

    public static function isInPeriod(\DateTime $from, \DateTime $to = null, \DateTime $input = null): bool
    {
        if (\is_null($input)) {
            $input = new \DateTime();
        }
        //Reverse 'to' & 'from' when 'to' is earlier than 'from''
        if (!is_null($to) && $from > $to) {
            $tmp = $from;
            $from = $to;
            $to = $tmp;
        }

        if (($input >= $from && $input <= $to) || ($input >= $from && is_null($to))) {
            return true;
        }

        return false;
    }

    private static function getTime($input)
    {
        if (is_numeric($input)) {
            return $input;
        }
        if (is_string($input)) {
            return strtotime($input);
        }

        return null;
    }

    /**
     * createFromFormat("2022-10-23 15:49:06")
     * @param string $time
     * @param string $format
     * @return \DateTime
     * @throws \InvalidArgumentException
     */
    public static function createFromFormat(string $time, string $format = 'Y-m-d H:i:s'): \DateTime
    {
        $result = \DateTime::createFromFormat($format, $time);
        if ($result === false) {
            $errors = \DateTime::getLastErrors();
            foreach ($errors["errors"] as $error) {
                throw new \InvalidArgumentException($error);
            }
        }
        return $result;
    }

    public static function intervalToSeconds(\DateInterval $interval): int
    {
        return ($interval->s) + ($interval->i * 60) + ($interval->h * 60 * 60) + ($interval->d * 60 * 60 * 24) + ($interval->m * 60 * 60 * 24 * 30) + ($interval->y * 60 * 60 * 24 * 365);
    }

    public static function secondsToInterval(int $seconds): \DateInterval
    {
        $start = new \DateTime("@0");
        $end = new \DateTime("@$seconds");
        return $start->diff($end);
    }
}
