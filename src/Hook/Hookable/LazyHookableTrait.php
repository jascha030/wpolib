<?php

namespace Jascha030\Wpolib\Hook\Hookable;

trait LazyHookableTrait
{
    final public static function getActions(): array
    {
        return static::$actions ?? [];
    }

    final public static function getFilters(): array
    {
        return static::$filters ?? [];
    }
}
