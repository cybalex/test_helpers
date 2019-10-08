<?php

namespace Cybalex\TestHelpers;

use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

/**
 * @author Zymovets Oleksii <cybalex87@gmail.com>
 */
trait TestHelperConstraintTrait
{
    /**
     * Checks if test helper is run from the context of TestCase class.
     */
    protected static function checkContext(): void
    {
        if (!\is_subclass_of(\get_class(), TestCase::class)) {
            throw new UnexpectedValueException(
                sprintf('Helper test trait can be used only in the subclasses of %s.', TestCase::class)
            );
        }
    }
}
