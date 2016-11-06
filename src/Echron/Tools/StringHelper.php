<?php
declare(strict_types = 1);

namespace Echron\Tools;

class StringHelper
{
    function startsWith(string $haystack, string $needle):bool
    {
        return $needle === '' || strrpos($haystack, $needle, -strlen($haystack)) !== false;
    }
}
