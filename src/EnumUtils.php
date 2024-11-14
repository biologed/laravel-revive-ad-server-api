<?php

namespace Biologed\Revive;

trait EnumUtils
{
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
    public static function array(): array
    {
        return array_combine(self::values(), self::names());
    }
    public static function isValid(Method $method): bool
    {
        return in_array($method->value, self::values(), true);
    }
}
