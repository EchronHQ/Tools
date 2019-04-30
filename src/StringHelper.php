<?php
declare(strict_types=1);

namespace Echron\Tools;

class StringHelper
{
    public static function startsWith(string $haystack, string $needle): bool
    {
        return $needle === '' || strrpos($haystack, $needle, -strlen($haystack)) !== false;
    }

    public static function endsWith(string $haystack, string $needle): bool
    {
        $needleLength = strlen($needle);
        if ($needleLength === 0) {
            return true;
        }

        return (substr($haystack, -$needleLength) === $needle);
    }

    public static function contains(string $hayStack, string $needle, bool $caseSensitive = false): bool
    {
        $contains = false;
        if ($caseSensitive) {
            $contains = strpos($hayStack, $needle) !== false;
        } else {
            $contains = stripos($hayStack, $needle) !== false;
        }

        return $contains;
    }

    public static function equals(string $input1, string $input2, bool $caseSensitive = false): bool
    {
        if ($caseSensitive) {
            return strcmp($input1, $input2) === 0;
        } else {
            return strcasecmp($input1, $input2) === 0;
        }
    }

    public static function mask(
        string $target,
        string $mask = '*',
        int $showStartCharacters = 0,
        int $showEndCharacters = 0
    ): string {
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

    /**
     * Generate 128-bit GUID
     * @return string
     */
    public static function generateGuid(): string
    {
        mt_srand((int)microtime() * 10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid((string)rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = substr($charid, 0, 8) . $hyphen . substr($charid, 8, 4) . $hyphen . substr($charid, 12, 4) . $hyphen . substr($charid, 16, 4) . $hyphen . substr($charid, 20, 12);// "}"

        return $uuid;
    }

    public static function generateRandom(
        int $len = 8,
        string $keySpace = 'A-Za-z0-9',
        string $salt = 'yourSalt'
    ): string {
        $hex = md5($salt . uniqid("", true));

        $pack = pack('H*', $hex);
        $tmp = base64_encode($pack);

        $uid = preg_replace("#(*UTF8)[^" . $keySpace . "]#", "", $tmp);

        $len = max(4, min(128, $len));

        while (strlen($uid) < $len) $uid .= self::generateG(22);

        return substr($uid, 0, $len);
    }

    public static function multiExplode(array $delimiters, string $string): array
    {
        $x = '**|-|**';

        $ready = str_replace($delimiters, $x, $string);
        $launch = explode($x, $ready);

        return $launch;
    }
}
