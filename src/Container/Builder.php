<?php

namespace Jascha030\Wpolib\Container;

use Jascha030\Wpolib\Container\Config\ConfigInterface;
use Pimple\Container;
use Pimple\Psr11\Container as Psr11Container;

/**
 * Class ContainerFactory
 *
 * @package Jascha030\Wpolib\Container
 */
final class ContainerBuilder implements ContainerBuilderInterface
{
    /**
     * @inheritDoc
     *
     * @param  ConfigInterface  $config
     *
     * @return Psr11Container
     */
    public function __invoke(ConfigInterface $config): Psr11Container
    {
        $container = new Container();

        $config->configure($container);

        return new Psr11Container($container);
    }
}
