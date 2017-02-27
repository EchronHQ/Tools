<?php
declare(strict_types = 1);

namespace Echron\Tools;

class StringHelper
{
    public static function startsWith(string $haystack, string $needle): bool
    {
        return $needle === '' || strrpos($haystack, $needle, -strlen($haystack)) !== false;
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

    public static function mask(string $target, string $mask = '*', int $showStartCharacters = 0, int $showEndCharacters = 0): string
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

    public static function generateGuid(): string
    {

        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand((int)microtime() * 10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid((string)rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = chr(123)// "{"
                . substr($charid, 0, 8) . $hyphen . substr($charid, 8, 4) . $hyphen . substr($charid, 12, 4) . $hyphen . substr($charid, 16, 4) . $hyphen . substr($charid, 20, 12) . chr(125);// "}"
            return $uuid;
        }

    }
}
