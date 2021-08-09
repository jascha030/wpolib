<?php

declare(strict_types=1);

namespace Jascha030\Wpolib\Container\Config;

use Pimple\Container as PimpleContainer;
use Pimple\Psr11\ServiceLocator;
use Pimple\ServiceIterator;
use Pimple\ServiceProviderInterface;

class Config implements ConfigInterface
{
    private array $hookables = [];

    private array $serviceProviders = [];

    private array $config;

    public function __construct(array $config, string $pluginFile)
    {
        $this->config = $config;

        parent::__construct($pluginFile);

        $this->setProviders($this->config['providers'] ?? []);
        $this->setHookables($this->config['hookables'] ?? []);
    }

    public function getConfigArray(): array
    {
        return $this->config;
    }

    public function configure(PimpleContainer $container): void
    {
        $this->injectProviders($container);
        $this->injectHookables($container);
        $this->injectPostTypes($container);
    }

    final public function getHookables(): array
    {
        return $this->hookables;
    }

    final public function setHookables(array $hookables): ConfigInterface
    {
        $this->hookables = $hookables;

        return $this;
    }

    final public function getProviders(): array
    {
        return $this->serviceProviders;
    }

    final public function setProviders(array $serviceProviders): ConfigInterface
    {
        $this->serviceProviders = $serviceProviders;

        return $this;
    }

    private function injectHookables(PimpleContainer $container): void
    {
        $hookables = $this->getHookables();

        /**
         * HookableClasses should strictly contain public methods to be hooked to wordpress actions/filters
         * Other methods should be private/protected methods that are used by classes public methods.
         * Globally available methods belong in a service that is provided by a ServiceProvider.
         */
        $afterInitHookables = [];
        $reference          = [];

        if (!empty($hookables)) {
            foreach ($hookables as $key => $className) {
                $closure = static function () use ($className) {
                    return new $className();
                };

                if (\is_string($key) && $className instanceof \Closure) {
                    $closure   = $className;
                    $className = $key;
                }

                if (!is_subclass_of($className, HookableInterface::class)) {
                    throw new DoesNotImplementHookableInterfaceException($className);
                }

                if (is_subclass_of($className, LazyHookableInterface::class)) {
                    $reference[$className] = [];
                }

                if (is_subclass_of($className, HookableAfterInitInterface::class)) {
                    $afterInitHookables[] = $className;
                }

                // @noinspection PhpArrayUsedOnlyForWriteInspection
                $container[$className] = $closure;
            }
        }

        $container['hookables'] = $reference;
        $container['afterInit'] = $afterInitHookables;
        $container['locator']   = static function (PimpleContainer $container) {
            $lazyHookables    = array_keys($container['hookable.reference']);
            $hookableServices = array_merge($lazyHookables, $container['hookable.afterInit']);

            return new ServiceLocator($container, $hookableServices);
        };
    }

    private function injectPostTypes(PimpleContainer $container): void
    {
        $definitions = [];
        $postTypes   = $this->getPostTypes();

        foreach ($postTypes as $postType) {
            if (\is_array($postType)) {
                $container[$postType[0]] = static function (PimpleContainer $c) use ($postType) {
                    return new PostType(...$postType);
                };

                $definitions[] = $postTypes[0];
            }

            if (is_subclass_of($postType, PostTypeInterface::class)) {
                $container[$postType] = static function (PimpleContainer $c) use ($postType) {
                    return new $postType();
                };

                $definitions[] = $postType;
            }
        }

        $container['postTypes'] = static function (PimpleContainer $container) use ($definitions) {
            return new ServiceIterator($container, $definitions);
        };
    }

    /**
     * @throws DoesNotImplementProviderInterfaceException
     */
    private function injectProviders(PimpleContainer $container): void
    {
        $serviceProviders = $this->getProviders();

        /*
         * These service providers should add dependencies and methods that need to be globally available,
         * they should not be hooked directly to WordPress' actions or filters.
         */
        foreach ($serviceProviders as $provider => $arguments) {
            if (!is_subclass_of($provider, ServiceProviderInterface::class)) {
                throw new DoesNotImplementProviderInterfaceException($provider);
            }

            $container->register(new $provider(), $arguments);
        }
    }
}
