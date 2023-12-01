<?php

declare(strict_types=1);

namespace Echron\Tools;

class JSON
{
    public function encode(mixed $value): string
    {
        //http://php.net/manual/en/function.json-encode.php
        return \json_encode($value, JSON_THROW_ON_ERROR);
    }

    public function decode(string $json, bool $assoc = true): mixed
    {
        return \json_decode($json, $assoc, 512, JSON_THROW_ON_ERROR);
    }
}
