<?php

declare(strict_types=1);

namespace SocialBrothers\WPUtils\Container\Config;

use SocialBrothers\WPUtils\Entity\Post\PostType;
use SocialBrothers\WPUtils\Entity\Post\PostTypeInterface;
use SocialBrothers\WPUtils\Exception\Psr11\DoesNotImplementHookableInterfaceException;
use SocialBrothers\WPUtils\Exception\Psr11\DoesNotImplementProviderInterfaceException;
use SocialBrothers\WPUtils\Service\Hookable\HookableAfterInitInterface;
use SocialBrothers\WPUtils\Service\Hookable\HookableInterface;
use SocialBrothers\WPUtils\Service\Hookable\LazyHookableInterface;
use SocialBrothers\WPUtils\Service\Provider\WordpressProvider;
use Pimple\Container as PimpleContainer;
use Pimple\Psr11\ServiceLocator;
use Pimple\ServiceIterator;
use Pimple\ServiceProviderInterface;

/**
 * Class Config
 * @package SocialBrothers\WPUtils\Container\Config
 */
class Config extends ConfigAbstract
{
    public function __construct(string $name, string $pluginFile)
    {
        $this->setPluginName($name);

        $this->setPluginPrefix(str_replace(' ', '', strtolower($name)));

        $this->setPluginFile($pluginFile);
    }

    /**
     * @param PimpleContainer $container
     *
     * @throws DoesNotImplementProviderInterfaceException
     * @throws DoesNotImplementHookableInterfaceException
     */
    final public function configure(PimpleContainer $container): void
    {
        $this->injectServiceProviders($container);
        $this->injectHookables($container);
        $this->injectPostTypes($container);
    }

    /**
     * @param PimpleContainer $container
     *
     * @throws DoesNotImplementHookableInterfaceException
     */
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

        if (! empty($hookables)) {
            foreach ($hookables as $key => $className) {
                $closure = static function () use ($className) {
                    return new $className();
                };

                if (is_string($key) && $className instanceof \Closure) {
                    $closure = $className;
                    $className =  $key;
                }

                if (! is_subclass_of($className, HookableInterface::class)) {
                    throw new DoesNotImplementHookableInterfaceException($className);
                }

                if (is_subclass_of($className, LazyHookableInterface::class)) {
                    $reference[$className] = [];
                }

                if (is_subclass_of($className, HookableAfterInitInterface::class)) {
                    $afterInitHookables[] = $className;
                }

                /** @noinspection PhpArrayUsedOnlyForWriteInspection */
                $container[$className] = $closure;
            }
        }

        $container['hookable.reference'] = $reference;
        $container['hookable.afterInit'] = $afterInitHookables;
        $container['hookable.locator']   = static function (PimpleContainer $container) {
            $lazyHookables    = array_keys($container['hookable.reference']);
            $hookableServices = array_merge($lazyHookables, $container['hookable.afterInit']);

            return new ServiceLocator($container, $hookableServices);
        };
    }

    /**
     * @param PimpleContainer $container
     */
    private function injectPostTypes(PimpleContainer $container): void
    {
        $definitions = [];
        $postTypes   = $this->getPostTypes();

        foreach ($postTypes as $postType) {
            if (is_array($postType)) {
                $container[$postType[0]] = static function (PimpleContainer $container) use ($postType) {
                    return new PostType(...$postType);
                };

                $definitions[] = $postTypes[0];
            }

            if (is_subclass_of($postType, PostTypeInterface::class)) {
                $container[$postType] = static function (PimpleContainer $container) use ($postType) {
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
     * @param PimpleContainer $container
     *
     * @throws DoesNotImplementProviderInterfaceException
     */
    private function injectServiceProviders(PimpleContainer $container): void
    {
        $serviceProviders = $this->getServiceProviders();

        if (! in_array(WordpressProvider::class, $serviceProviders, true)) {
            $serviceProviders[WordpressProvider::class] = [];
        }

        /**
         * These service providers should add dependencies and methods that need to be globally available,
         * they should not be hooked directly to WordPress' actions or filters.
         */
        foreach ($serviceProviders as $provider => $arguments) {
            if (! is_subclass_of($provider, ServiceProviderInterface::class)) {
                throw new DoesNotImplementProviderInterfaceException($provider);
            }

            if ($provider === WordpressProvider::class) {
                $container->register(new $provider($this->getPluginName(), $this->getPluginFile()), $arguments);

                continue;
            }

            $container->register(new $provider(), $arguments);
        }
    }
}
