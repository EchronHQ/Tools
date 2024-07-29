<?php

declare(strict_types=1);

namespace Echron\Tools\Normalize;

class Normalizer
{
    public static function normalizeCollection(array $codes, NormalizeConfig $keyFormatConfig = null): array
    {
        $result = [];

        foreach ($codes as $code) {
            $result[] = self::normalize($code, $keyFormatConfig);
        }

        return $result;
    }

    public static function normalize(string $code, NormalizeConfig $keyFormatConfig = null): string
    {
        // TODO: this is quite a slow function and called loads of times
        if ($keyFormatConfig === null) {
            $keyFormatConfig = new NormalizeConfig();
        }

        $id = str_replace([
            'ë',
            'é',
            'è',
            'ç',
            'ò',
            '�',
        ], [
            'e',
            'e',
            'e',
            'c',
            'o',
            '_',

        ], $code);
        //Remove special characters (http://regexr.com/3cpha)
        //Don't use \w as character group, it will allow special non utf-8 characters

        $allowedChars = [
            'a-z',
            '0-9',
        ];
        $notAllowed = [
            '(\_{2,})',
            //'(\+{2,})',
        ];

        if ($keyFormatConfig->allowConsecutiveSlashes > 0 && $keyFormatConfig->isAllowSlash()) {
            $allowedChars[] = '\/';
            //            $notAllowed[] =  '(\/{2,})';
        }
        if ($keyFormatConfig->isAllowDot()) {
            $allowedChars[] = '\.';
            //            $notAllowed[] = '';// '(\.{2,})';
        }
        if ($keyFormatConfig->isAllowDash()) {
            $allowedChars[] = '\-';
            //            $notAllowed[] = '';// '(\-{2,})';
        }
        if ($keyFormatConfig->isAllowPlus()) {
            $allowedChars[] = '\+';
            // TODO: should we allow up till x amount of plusses next to each other?
            //            $notAllowed[] = '';// '(\+{5,})';
        }
        if ($keyFormatConfig->isAllowExtended()) {
            $characters = [
                '(',
                ')',
                '\\',
                '{',
                '}',
                '*',
                '#',
                '[',
                ']',
                '=',
            ];
            foreach ($characters as $character) {
                $allowedChars[] = '\\' . $character;
                $notAllowed[] = '(\\' . $character . '{2,})';
            }
        }
        $regex = '/([^' . implode('', $allowedChars) . ']+)|' . implode('|', $notAllowed) . '/mi';

        //        if ($allowWhiteSpace) {
        //            $regex = '/([^\w\s]+)|(\s{2,})|(\_{2,})/im';
        //            if ($allowSlash) {
        //                $regex = '/([^\w\s\/]+)|(\s{2,})|(\_{2,})|(\/{2,})/im';
        //            }
        //        }

        $id = preg_replace($regex, '_', $id);


        if ($keyFormatConfig->allowConsecutiveSlashes > 0 && $keyFormatConfig->isAllowSlash()) {
            $regex = '/(\/{' . ($keyFormatConfig->allowConsecutiveSlashes + 1) . ',})/mi';
            $id = preg_replace($regex, \str_repeat('/', $keyFormatConfig->allowConsecutiveSlashes), $id);
        }
        if ($keyFormatConfig->allowConsecutiveDots > 0 && $keyFormatConfig->isAllowDot()) {
            $regex = '/(\.{' . ($keyFormatConfig->allowConsecutiveDots + 1) . ',})/mi';
            $id = preg_replace($regex, \str_repeat('.', $keyFormatConfig->allowConsecutiveDots), $id);
        }
        if ($keyFormatConfig->allowConsecutiveDashes > 0 && $keyFormatConfig->isAllowDash()) {
            $regex = '/(\-{' . ($keyFormatConfig->allowConsecutiveDashes + 1) . ',})/mi';
            $id = preg_replace($regex, \str_repeat('-', $keyFormatConfig->allowConsecutiveDashes), $id);
        }

        if (!$keyFormatConfig->isCasesAllowed()) {
            $id = strtolower($id);
        }

        if ($keyFormatConfig->getMaxLength() > 0) {
            $id = substr($id, 0, $keyFormatConfig->getMaxLength());
        }

        //Remove leading or trailing slashes
        $id = trim($id, '_');

        return $id;
        //        return new NormalizedCode($id);
    }
}
