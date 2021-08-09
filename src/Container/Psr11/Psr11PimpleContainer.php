<?php

/**
 * @noinspection PhpMethodNamingConventionInspection
 * @noinspection PhpClassNamingConventionInspection
 */

declare(strict_types=1);

namespace Jascha030\Wpolib\Container\Psr11;

use Jascha030\Wpolib\Exception\Psr11\ContainerEntryNotFoundException;
use Pimple\Container;
use Psr\Container\ContainerInterface;

class Psr11PimpleContainer implements ContainerInterface
{
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $id)
    {
        if (!$this->has($id)) {
            throw new ContainerEntryNotFoundException($id);
        }

        return $this->container[$id];
    }

    /**
     * {@inheritdoc}
     */
    public function has(string $id): bool
    {
        return isset($this->container[$id]);
    }
}
