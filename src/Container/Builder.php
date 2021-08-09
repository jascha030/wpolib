<?php

namespace Jascha030\Wpolib\Container;

use Jascha030\Wpolib\Container\Config\ConfigInterface;
use Jascha030\Wpolib\Container\Psr11\Psr11PimpleContainer;
use Pimple\Container;

/**
 * Class ContainerFactory.
 */
final class Builder implements BuilderInterface
{
    /**
     * {@inheritDoc}
     */
    public function __invoke(ConfigInterface $config): Psr11PimpleContainer
    {
        $container = new Container();

        $config->configure($container);

        return new Psr11PimpleContainer($container);
    }
}
