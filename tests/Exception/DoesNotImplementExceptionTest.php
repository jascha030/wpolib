<?php

/**
 * @noinspection PhpClassNamingConventionInspection
 * @noinspection PhpMethodNamingConventionInspection
 */

declare(strict_types=1);

namespace Jascha030\Wpolib\Tests\Exception;

use Jascha030\Wpolib\Exception\DoesNotImplementException;
use Jascha030\Wpolib\Hook\Hookable\Hookable;

/**
 * @internal
 * @coversNothing
 */
class DoesNotImplementExceptionTest extends ExceptionTestCase
{
    public function testConstruction(): void
    {
        try {
            $this->throwTestException(DoesNotImplementException::class, 'TestClass', Hookable::class);
        } catch (DoesNotImplementException $e) {
            self::assertEquals(
                'Class "TestClass" does not implement "'.Hookable::class.'"',
                $e->getMessage()
            );
        }
    }
}
