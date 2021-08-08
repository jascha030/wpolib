<?php

/**
 * @noinspection PhpClassNamingConventionInspection
 * @noinspection PhpMethodNamingConventionInspection
 */

declare(strict_types=1);

namespace Jascha030\Wpolib\Tests\Exception\Psr11;

use Jascha030\Wpolib\Exception\Psr11\ContainerEntryNotFoundException;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class ContainerEntryNotFoundExceptionTest extends TestCase
{
    public function testConstruction(): void
    {
        try {
            $this->throwTestException(ContainerEntryNotFoundException::class, 'TestEntry');
        } catch (ContainerEntryNotFoundException $e) {
            self::assertEquals(
                'Couldn\'t find container entry with identifier: "TestEntry".',
                $e->getMessage()
            );
        }
    }
}
