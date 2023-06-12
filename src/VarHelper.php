<?php

declare(strict_types=1);

namespace Echron\Tools;

class VarHelper
{
    public static function getType($var, bool $returnClassIfObject = true): string
    {
        $type = gettype($var);
        if ($type === 'object' && $returnClassIfObject) {
            $type = get_class($var);
        }

        return $type;
    }
}
