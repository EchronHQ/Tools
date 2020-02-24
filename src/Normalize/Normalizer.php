<?php
declare(strict_types=1);

namespace Echron\Tools\Normalize;

class Normalizer
{
    public static function normalize(string $code, NormalizeConfig $keyFormatConfig = null): string
    {
        if ($keyFormatConfig === null) {
            $keyFormatConfig = new NormalizeConfig();
        }

        // $id = iconv("UTF-8", "UTF-8//IGNORE", $id);
        //$id = mb_convert_encoding($id, 'UTF-8', 'UTF-8');
        //$id = mb_strtolower($id);
        $id = str_replace([
            'ë',
            'é',
            'è',
            'ç',
            '�',
        ], [
            'e',
            'e',
            'e',
            'c',
            '_',

        ], $code);
        //Remove special characters (http://regexr.com/3cpha)
        //Don't use \w as character groop, it will allow special non utf-8 characters

        $allowedChars = [
            'a-z',
            '0-9',
        ];
        $notAllowed = [
            '(\_{2,})',
            '(\+{2,})',
        ];

        if ($keyFormatConfig->isAllowSlash()) {
            $allowedChars[] = '\/';
            $notAllowed[] = '(\/{2,})';
        }
        if ($keyFormatConfig->isAllowDot()) {
            $allowedChars[] = '\.';
            $notAllowed[] = '(\.{2,})';
        }
        if ($keyFormatConfig->isAllowDash()) {
            $allowedChars[] = '\-';
            $notAllowed[] = '(\-{2,})';
        }
        if ($keyFormatConfig->isAllowPlus()) {
            $allowedChars[] = '\+';
            $notAllowed[] = '(\+{2,})';
        }

        $regex = '/([^' . implode('', $allowedChars) . ']+)|' . implode('|', $notAllowed) . '/mi';

        //        if ($allowWhiteSpace) {
        //            $regex = '/([^\w\s]+)|(\s{2,})|(\_{2,})/im';
        //            if ($allowSlash) {
        //                $regex = '/([^\w\s\/]+)|(\s{2,})|(\_{2,})|(\/{2,})/im';
        //            }
        //        }

        $id = preg_replace($regex, '_', $id);

        //        if (strlen($id) < 1) {
        //            $ex = new InvalidKeyException('Id must be longer than 1 character');
        //            echo $ex->getTraceAsString();
        //            throw $ex;
        //        }

        if (!$keyFormatConfig->isCasesAllowed()) {
            $id = strtolower($id);
        }

        if ($keyFormatConfig->getMaxLength() > 0) {
            $id = substr($id, 0, $keyFormatConfig->getMaxLength());
        }

        //Remove leading or trailing slashes
        $id = trim($id, '_');
        //Remove multi underscores
        //        $code = preg_replace('!\s+!', ' ', $code);
        //        $code = trim($code);
        //        $code = str_replace(' ', '_', $code);

        return $id;
    }

    public static function normalizeCollection(array $codes, NormalizeConfig $keyFormatConfig = null): array
    {
        $result = [];

        foreach ($codes as $code) {
            $result[] = self::normalize($code, $keyFormatConfig);
        }

        return $result;
    }
}
