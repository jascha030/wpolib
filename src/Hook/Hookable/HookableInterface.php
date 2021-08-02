<?php

declare(strict_types=1);

namespace Jascha030\Wpolib\Hook\Hookable;

/**
 * Used to indicate a class containing methods,
 * which shall be hooked to a Wordpress action/filter hook using the Plugin Api.
 */
interface HookableInterface
{
    /**
     * Returns predefined action/method hooks,
     * which can be loaded lazily.
     * @return array
     */
    public static function getActions(): array;

    /**
     * Returns predefined filter/method hooks,
     * which can be loaded lazily.
     * @return array
     */
    public static function getFilters(): array;
}
