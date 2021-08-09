<?php

declare(strict_types=1);

namespace Jascha030\Wpolib\Hook;

use Jascha030\Wpolib\Exception\DoesNotImplementException;
use Jascha030\Wpolib\Hook\Hookable\Hookable;
use Jascha030\Wpolib\Hook\Hookable\InvokeHookable;
use Psr\Container\ContainerInterface;

final class HookRegistry
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
     *
     * @throws \Jascha030\Wpolib\Exception\DoesNotImplementException
     */
    public function __construct(ContainerInterface $container, array $hookables)
    {
        $this->container = $container;
        $this->hookables = $hookables;

        $this->hookClasses();
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
    public function hookClasses(): void
    {
        foreach ($this->hookables as $hookableClass) {
            if (
                !is_subclass_of($hookableClass, Hookable::class)
                && !is_subclass_of($hookableClass, InvokeHookable::class)
            ) {
                throw new DoesNotImplementException($hookableClass, Hookable::class.' or '.InvokeHookable::class);
            }

            $this->hookClassMethods($hookableClass, is_subclass_of($hookableClass, Hookable::class));
        }
    }

    private function hookClassMethods(string $hookableClass, bool $lazy): void
    {
        $methods = ['getActions', 'getFilters'];

        foreach ($methods as $filterType => $hookMethod) {
            $hooks = $lazy
                ? $hookableClass::{$hookMethod}()
                : $hookableClass->{$hookMethod}();

            $addMethod = 'add_'.self::FILTER_TYPES[$filterType];

            foreach ($hooks as $filterTag => $parameters) {
                if (\is_array($parameters) && \is_array($parameters[0])) {
                    $this->hookMethods($parameters, $addMethod, $filterTag, $hookableClass);
                } else {
                    $this->hookMethod($parameters, $addMethod, $filterTag, $hookableClass);
                }
            }
        }
    }

    /**
     * Hooks multiple methods defined in a Hookable class.
     *
     * @param mixed $tag
     */
    private function hookMethods(array $parameters, string $addMethod, $tag, string $serviceClass): void
    {
        foreach ($parameters as $params) {
            $params = !\is_array($params) ? [$params] : $params;
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
        $parameters = !\is_array($parameters) ? [$parameters] : $parameters;
        $callable   = $this->wrap($serviceClass, array_shift($parameters));

        $addMethod($tag, $callable, ...$parameters);
    }
}
