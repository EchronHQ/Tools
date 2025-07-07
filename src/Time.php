<?php

declare(strict_types=1);

namespace Echron\Tools;

class Time
{
    public static function readableSeconds(float $seconds, bool $short = false, int $precision = 2): string
    {

        $units = [
            7 * 24 * 60 * 60 => [
                'long' => ' week',
                'short' => 'w',
            ],
            24 * 60 * 60 => [
                'long' => ' day',
                'short' => 'd',
            ],
            60 * 60 => [
                'long' => ' hour',
                'short' => 'h',
            ],
            60 => [
                'long' => ' minute',
                'short' => 'm',
            ],
            1 => [
                'long' => ' second',
                'short' => 's',
            ],
        ];
        // specifically handle zero
        if ($seconds === 0.0) {
            if ($short) {
                return '0s';
            }

            return '0 seconds';
        }
        $s = '';
        foreach ($units as $divisor => $data) {
            if ($divisor !== 1) {
                $quot = (int)($seconds / $divisor);
            } else {
                $quot = $seconds;
            }

            if ($quot) {
                $label = $short ? $data['short'] : $data['long'];

                $sQuot = $quot;

                if ($divisor === 1) {
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

        if ($s !== '') {
            if ($short) {
                $s = substr($s, 0, -1);
            } else {
                $s = substr($s, 0, -2);
            }
        }

        return $s;
    }

    public static function todayInRange(
        int|string|\DateTimeInterface|null $periodStartDate,
        int|string|\DateTimeInterface|null $periodEndDate,
        string                             $todayStartTime = 'today 00:00',
        string                             $todayEndTime = 'today 23:59:59'
    ): bool
    {
        $todayStartInSeconds = (int)gmdate('U', strtotime($todayStartTime));
        $todayEndInSeconds = (int)gmdate('U', strtotime($todayEndTime));


        if ($periodStartDate === null) {
            $periodStartDate = gmdate('U', strtotime('yesterday'));
        }
        if ($periodEndDate === null) {
            $periodEndDate = gmdate('U', strtotime('tomorrow'));
        }


        //if ($periodStartDate !== null) {
        $startTimeInSeconds = self::getTime($periodStartDate);
        $endTimeInSeconds = self::getTime($periodEndDate);

//        $x = new \DateTime('now');
//        $x->setTimestamp($startTimeInSeconds);
//        $y = new \DateTime('now');
//        $y->setTimestamp($endTimeInSeconds);
//        echo 'Period:' . $x->format('Y-m-d H:i:s') . ' ' . $y->format('Y-m-d H:i:s') . PHP_EOL;
//        $ts = new \DateTime('now');
//        $ts->setTimestamp($todayStartInSeconds);
//        $te = new \DateTime('now');
//        $te->setTimestamp($todayEndInSeconds);
//        echo 'Today:' . $ts->format('Y-m-d H:i:s') . ' ' . $te->format('Y-m-d H:i:s') . PHP_EOL;
//
//            // End of period is before today started
//            if ($endTimeInSeconds < $todayStartInSeconds) {
//                return false;
//            }
//            // Start of period is after today ended
//            if ($startTimeInSeconds > $todayEndInSeconds) {
//                return false;
//            }

        return ($todayStartInSeconds >= $startTimeInSeconds && $todayEndInSeconds <= $endTimeInSeconds) || ($todayStartInSeconds >= $startTimeInSeconds && $endTimeInSeconds === null);
    }

    private static function getTime(int|string|\DateTimeInterface|null $input): int|null
    {
        if (is_numeric($input)) {
            return (int)$input;
        }
        if (is_string($input)) {
            return strtotime($input);
        }
        if ($input instanceof \DateTimeInterface) {
            return $input->getTimestamp();
        }

        return null;
    }

    public static function isInPeriod(\DateTimeInterface $from, \DateTimeInterface|null $to = null, \DateTimeInterface|null $input = null): bool
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

        return ($input >= $from && $input <= $to) || ($input >= $from && null === $to);
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
