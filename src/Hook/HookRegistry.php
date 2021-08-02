<?php

namespace Jascha030\Wpolib\Hook;

use Jascha030\Wpolib\Exception\DoesNotImplementException;
use Jascha030\Wpolib\Hook\Hookable\HookableInterface;
use Psr\Container\ContainerInterface;

class HookRegistry
{
    /**
     * Keys for `self::FILTER_TYPES`.
     */
    private const FILTER = 0;
    private const ACTION = 1;

    /**
     * Prefixes for Wordpress filter methods.
     */
    private const FILTER_TYPES = [
        self::ACTION => 'action',
        self::FILTER => 'filter',
    ];

    private array $hookables;

    private ContainerInterface $container;

    /**
     * PluginApiRegistryAbstract constructor.
     */
    public function __construct(ContainerInterface $container, array $hookables)
    {
        $this->container = $container;
        $this->hookables = $hookables;
    }

    /**
     * Hooks all hookables.
     *
     * @throws \Jascha030\Wpolib\Exception\DoesNotImplementException
     */
    public function run(): void
    {
        $this->hookLazyReferences();
    }

    /**
     * Wraps class and method in a Closure that calls our container and checks if our hook identifier still exists,
     * In that case, the Class is retrieved from our container to execute hooked method,
     * If not, the method  wil not be executed. This is a workaround for newer wordpress versions,
     * in which it is basically impossible to unhook a closure by reference. (It's possible, it's not failsafe).
     */
    private function wrap(string $identifier, string $method): \Closure
    {
        return function (...$arguments) use ($identifier, $method) {
            // Todo: implement check to enable easy unhooking.
            return $this->container->get($identifier)->{$method}(...$arguments);
        };
    }

    /**
     * Get predefined actions/filters statically
     * Based on this, wrap and hook all methods.
     *
     * @throws \Jascha030\Wpolib\Exception\DoesNotImplementException
     */
    private function hookLazyReferences(): void
    {
        foreach (array_keys($this->hookables) as $className) {
            if (!is_subclass_of($className, HookableInterface::class)) {
                throw new DoesNotImplementException($className, HookableInterface::class);
            }

            $this->hookClassMethods($className);
        }
    }

    /**
     * @noinspection NotOptimalIfConditionsInspection
     */
    private function hookClassMethods(string $hookableClass): void
    {
        $methods = ['getActions', 'getFilters'];

        foreach ($methods as $key => $method) {
            $hooks     = $hookableClass::{$method}();
            $addMethod = 'add_'.self::FILTER_TYPES[$key];

            foreach ($hooks as $tag => $parameters) {
                if (\is_array($parameters) && \is_array($parameters[0])) {
                    $this->hookMultipleMethods($parameters, $addMethod, $tag, $hookableClass);
                } else {
                    $this->hookMethod($parameters, $addMethod, $tag, $hookableClass);
                }
            }
        }
    }

    /**
     * Hooks multiple methods defined in a Hookable class.
     *
     * @param mixed $tag
     */
    private function hookMultipleMethods(array $parameters, string $addMethod, $tag, string $serviceClass): void
    {
        foreach ($parameters as $params) {
            if (!\is_array($params)) {
                $params = [$params];
            }

            $this->hookMethod($params, $addMethod, $tag, $serviceClass);
        }
    }

    /**
     * Hook a single method defined in a hookable class.
     *
     * @param $parameters
     * @param $tag
     */
    private function hookMethod($parameters, string $addMethod, $tag, string $serviceClass): void
    {
        if (!\is_array($parameters)) {
            $parameters = [$parameters];
        }

        $addMethod($tag, $this->wrap($serviceClass, array_shift($parameters)), ...$parameters);
    }
}
