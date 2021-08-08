<?php

/**
 * @noinspection PhpClassNamingConventionInspection
 * @noinspection PhpMethodNamingConventionInspection
 */

declare(strict_types=1);

namespace Jascha030\Wpolib\Tests\Exception;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class ExceptionTestCase extends TestCase
{
    public function throwTestException(string $exception, ...$arguments): void
    {
        throw new $exception(...$arguments);
    }
}
