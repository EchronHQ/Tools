<?php
declare(strict_types=1);

namespace Echron\Tools;

class ArrayHelper
{
    public static function unique(array $input, array $fields): array
    {
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
}
