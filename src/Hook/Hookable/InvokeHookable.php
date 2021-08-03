<?php

declare(strict_types=1);

namespace Jascha030\Wpolib\Hook\Hookable;

/**
 * Used to indicate a class containing methods,
 * which shall be hooked to a Wordpress action/filter hook, but require construction logic first.
 */
interface InvokeHookable
{
    /**
     * Returns predefined action/method hooks,
     * which cannot be loaded lazily, and require construction.
     */
    public function getActions(): array;

    /**
     * Returns predefined filter/method hooks,
     * which cannot be loaded lazily and require construction.
     */
    public function getFilters(): array;
}
