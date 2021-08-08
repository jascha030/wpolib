<?php

/** @noinspection PhpClassNamingConventionInspection */

declare(strict_types=1);

namespace Jascha030\Wpolib\Exception;

class DoesNotImplementException extends \Exception
{
    /**
     * DoesNotImplementInterfaceException constructor.
     */
    public function __construct(string $className, string $interface)
    {
        parent::__construct("Class \"{$className}\" does not implement \"{$interface}\"");
    }
}
