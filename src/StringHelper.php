<?php

declare(strict_types=1);

namespace Echron\Tools;

class StringHelper
{
    /**
     * @param string $haystack
     * @param string $needle
     * @return bool
     * @deprecated Use build in method `str_starts_with` instead (available since PHP 8.0)
     */
    public static function startsWith(string $haystack, string $needle): bool
    {
        return str_starts_with($haystack, $needle);
    }

    /**
     * @param string $haystack
     * @param string $needle
     * @return bool
     * @deprecated Use build in method `str_ends_with` instead (available since PHP 8.0)
     */
    public static function endsWith(string $haystack, string $needle): bool
    {
        return str_ends_with($haystack, $needle);
    }

    /**
     * @param string $hayStack
     * @param string $needle
     * @param bool $caseSensitive
     * @return bool
     * @deprecated Use build in method `str_contains` (case sensitive) instead (available since PHP 8.0)
     */
    public static function contains(string $hayStack, string $needle, bool $caseSensitive = false): bool
    {
        if ($caseSensitive) {
            return str_contains($hayStack, $needle);
        }
        return mb_stripos($hayStack, $needle) !== false;
    }

    public static function equals(string $input1, string $input2, bool $caseSensitive = false): bool
    {
        if ($caseSensitive) {
            return strcmp($input1, $input2) === 0;
        }

        return strcasecmp($input1, $input2) === 0;
    }

    public static function mask(
        string $target,
        string $mask = '*',
        int    $showStartCharacters = 0,
        int    $showEndCharacters = 0
    ): string
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

    /**
     * Generate 128-bit GUID
     * @return string
     * @throws \Random\RandomException
     */
    public static function generateGuid(): string
    {
        // Generate 16 bytes (128 bits) of random data.
        $data = random_bytes(16);
        assert(strlen($data) === 16);

        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public static function generateRandom(
        int    $length = 8,
        string $keySpace = 'A-Za-z0-9'
    ): string
    {
        $characterPools = [
            '0123456789', 'abcdefghijklmnopqrstuvwxyz', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
        ];
        if ($keySpace !== 'A-Za-z0-9') {
            throw new \Exception('Unsupported keyspace');
        }


        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $poolIndex = \random_int(0, \count($characterPools) - 1);
            $characters = $characterPools[$poolIndex];
            $number = \random_int(0, \strlen($characters) - 1);
            $character = \substr($characters, $number, 1);
            $result .= $character;
        }
        return $result;
    }

    public static function multiExplode(array $delimiters, string $string): array
    {
        // TODO: should we allow an empty delimiter array?
        // TODO: test if all delimiters are string
        if (empty($delimiters)) {
            return [$string];
        }
        $ready = str_replace($delimiters, $delimiters[0], $string);
        return explode($delimiters[0], $ready);
    }

    /**
     * Generate checksum based on string
     * @param string $title
     * @param int|null $max
     * @return int
     */
    public static function checksum(string $title, int|null $max = null): int
    {
        $characters = "abcdefghijklmnopqrstuvwxyz0123456789";

        $title = \strtolower($title);
        $title = str_replace(['_', ' '], '', $title);
        $chars = str_split($title);


        $sum = 0;
        foreach ($chars as $char) {


            $pos = \strpos($characters, $char);
            if ($pos === false) {
                // $this->logger->warning('Unable to calculate random key based on category name: character "' . $char . '" not recognized', ['title' => $title]);
            } else {
                $sum += $pos;
            }

        }
        $checksum = $sum / \strlen($title);
        if ($max === null) {
            return (int)\round($checksum);
        }
        return (int)\round($checksum / \strlen($characters) * $max, 0);
    }

    /**
     * This will cut off the string keeping words intact. When passing on the end, the length of the end will be calculated in
     * the max character count so even with an end the character count will never be more than the max count
     *
     * @param string $input
     * @param int $maxCharacters
     * @param string $end
     * @return string
     */
    public static function limitWords(string $input, int $maxCharacters, string $end = ''): string
    {
        $inputLength = mb_strwidth($input, 'UTF-8');
        if ($inputLength <= $maxCharacters) {
            return $input;
        }
        $endLength = mb_strwidth($end, 'UTF-8');

        if ($maxCharacters <= $endLength) {
            $end = '';
            $endLength = 0;
        }

        $findSpaceBeforePosition = $maxCharacters - $endLength;
        if ($findSpaceBeforePosition < 0) {
            return '';
        }
        $x = mb_strimwidth($input . ' ', 0, $findSpaceBeforePosition + 1, '', 'UTF-8');

        $lastSpaceBeforeMaxCharacters = mb_strrpos($x, ' ');
        if ($lastSpaceBeforeMaxCharacters === false) {
            return '';
        }
        return mb_strimwidth($input, 0, $lastSpaceBeforeMaxCharacters + $endLength, $end, 'UTF-8');
    }

    public static function limit(string $input, int $maxCharacters, string $end = ''): string
    {
        if (mb_strwidth($input, 'UTF-8') <= $maxCharacters) {
            return $input;
        }
        return mb_strimwidth($input, 0, $maxCharacters, $end, 'UTF-8');
    }
}
