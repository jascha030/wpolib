<?php

namespace Jascha030\Wpolib\Container\Config;

use Pimple\Container as PimpleContainer;

interface ConfigInterface
{
    public function configure(PimpleContainer $container): void;

    public function getConfigArray(): array;

    public function getHookables(): array;

    public function getProviders(): array;
}
