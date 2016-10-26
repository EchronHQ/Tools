<?php
declare(strict_types = 1);

namespace Echron\Tools;

abstract class TypedEnum extends BasicObject
{
    private static $_instancedValues;

    private $_value;
    private $_name;

    private function __construct(string $value, string $name)
    {
        $this->_value = $value;
        $this->_name = $name;
    }

    public static function fromValue($value)
    {
        $value = (string)$value;

        return self::_fromGetter('getValue', $value);
    }

    private static function _fromGetter(string $getter, string $value)
    {
        $reflectionClass = new \ReflectionClass(get_called_class());
        $methods = $reflectionClass->getMethods(\ReflectionMethod::IS_STATIC | \ReflectionMethod::IS_PUBLIC);
        $className = get_called_class();

        foreach ($methods as $method) {
            if ($method->class === $className) {
                $enumItem = $method->invoke(null);

                if ($enumItem instanceof $className && $enumItem->$getter() === $value) {
                    return $enumItem;
                }
            }
        }

        throw new \OutOfRangeException();
    }

    public static function fromName(string $value)
    {
        return self::_fromGetter('getName', $value);
    }

    protected static function _create($value):TypedEnum
    {
        $value = (string)$value;
        if (self::$_instancedValues === null) {
            self::$_instancedValues = [];
        }

        $className = get_called_class();

        if (!isset(self::$_instancedValues[$className])) {
            self::$_instancedValues[$className] = [];
        }

        if (!isset(self::$_instancedValues[$className][$value])) {
            $debugTrace = debug_backtrace();
            $lastCaller = array_shift($debugTrace);

            while ($lastCaller['class'] !== $className && count($debugTrace) > 0) {
                $lastCaller = array_shift($debugTrace);
            }

            self::$_instancedValues[$className][$value] = new static($value, (string)$lastCaller['function']);
        }

        return self::$_instancedValues[$className][$value];
    }

    public function getValue():string
    {
        return $this->_value;
    }

    public function getName():string
    {
        return $this->_name;
    }
}
