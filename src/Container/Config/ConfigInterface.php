<?php

namespace SocialBrothers\WPUtils\Container\Config;

use Pimple\Container as PimpleContainer;

interface ConfigInterface
{
    public function configure(PimpleContainer $container): void;
}
