<?php

declare(strict_types=1);

namespace Echron\Tools;

class ArrayHelper
{
    public static function unique(array $input, array $fields = null): array
    {
        if (\is_null($fields)) {
            $fields = self::getAllFields($input);
        }
        $result = [];
        foreach ($input as $optionA) {
            $duplicateSuperAttributes = array_filter($result, function ($optionB) use (
                $optionA,
                $fields
            ) {
                if (count($fields) === 0) {
                    return false;
                }
                foreach ($fields as $field) {
                    if (!isset($optionB[$field]) || !isset($optionA[$field]) || $optionB[$field] !== $optionA[$field]) {
                        return false;
                    }
                }

                return true;
            });

            if (count($duplicateSuperAttributes) === 0) {
                $result[] = $optionA;
            }
        }

        return $result;
    }

    private static function getAllFields(array $input): array
    {
        $result = [];
        foreach ($input as $elem) {
            $fields = \array_keys($elem);
            foreach ($fields as $field) {
                $result[] = $field;
            }
        }

        return \array_unique($result);
    }

    public static function hasDuplicates(array $array): bool
    {
        return count($array) > count(array_unique($array, SORT_REGULAR));
        // Flip can only be used on string and integer values
        //        return count($array) === count(array_flip($array));
        //        // TODO: implement objects
        //        $dupe_array = [];
        //        foreach ($array as $val) {
        //            if (++$dupe_array[$val] > 1) {
        //                return true;
        //            }
        //        }
        //
        //        return false;
    }

    /**
     * Shuffle array by seed
     * @param array $input
     * @param int $seed
     * @return array
     * @throws \Exception
     */
    public static function shuffle(array $input, int $seed): array
    {
        mt_srand($seed);
        $size = count($input);
        for ($i = $size - 1; $i > 0; $i--) {
            $r = random_int(0, $i);
            $tmp = $input[$i];
            $input[$i] = $input[$r];
            $input[$r] = $tmp;
        }
        // Make sure our seed is random again
        mt_srand();
        return $input;
    }
}
