<?php
declare(strict_types = 1);

class TypedEnumImpl extends \Echron\Tools\TypedEnum
{


    public static function OptionZero()
    {
        return self::_create(0);
    }

    public static function OptionOne()
    {
        return self::_create(1);
    }


}
