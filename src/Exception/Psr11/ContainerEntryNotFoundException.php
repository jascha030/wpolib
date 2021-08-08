<?php

/** @noinspection PhpClassNamingConventionInspection */

declare(strict_types=1);

namespace Jascha030\Wpolib\Exception\Psr11;

use Psr\Container\NotFoundExceptionInterface;

class ContainerEntryNotFoundException extends \Exception implements NotFoundExceptionInterface
{
    public function __construct(string $entry)
    {
        parent::__construct("Couldn't find container entry with identifier: \"{$entry}\".");
    }
}
