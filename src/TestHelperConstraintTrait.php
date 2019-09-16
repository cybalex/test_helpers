<?php

namespace Cybalex\TestHelpers;

use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

trait TestHelperConstraintTrait
{
    protected function checkContext()
    {
        if (!\is_subclass_of($this, TestCase::class)) {
            throw new UnexpectedValueException(
                sprintf('Helper test trait can be used only in the subclasses of %s.', TestCase::class)
            );
        }
    }
}
