<?php
declare(strict_types = 1);

namespace Echron\Tools;


class JSON
{
    public function encode($value):string
    {
        //http://php.net/manual/en/function.json-encode.php
        return json_encode($value);
    }

    public function decode(string $json, bool $assoc = true)
    {
        return json_decode($json, $assoc);
    }
}
