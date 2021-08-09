<?php

namespace Jascha030\Wpolib\Container;

use Jascha030\Wpolib\Container\Config\ConfigInterface;
use Psr\Container\ContainerInterface;

/**
 * Interface ContainerBuilderInterface
 * @package Jascha030\Wpolib\Container
 */
interface ContainerBuilderInterface
{
    /**
     * Registers all of the plugin or theme's dependencies to a Psr11 compliant container.
     *
     * @param  ConfigInterface  $config
     *
     * @return ContainerInterface
     */
    public function __invoke(ConfigInterface $config): ContainerInterface;
}
