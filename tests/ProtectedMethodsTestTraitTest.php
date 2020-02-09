<?php

namespace Cybalex\TestHelpers\Tests;

use Cybalex\TestHelpers\GettersAndSettersTestTrait;
use Cybalex\TestHelpers\ProtectedMethodsTestTrait;
use PHPUnit\Framework\TestCase;
use ReflectionException;

class ProtectedMethodsTestTraitTest extends TestCase
{
    use GettersAndSettersTestTrait;
    use ProtectedMethodsTestTrait;

    public function gettersAndSettersDataProvider(): array
    {
        return [];
    }

    public static function getEntityClass(): string
    {
        return \stdClass::class;
    }

    /**
     * @throws ReflectionException
     */
    public function testGetConstructorArguments()
    {
        $this->assertEquals([], $this->invokeMethod($this, 'getConstructorArguments'));
    }

    /**
     * @throws ReflectionException
     */
    public function testInvokeMethodConsecutive()
    {
        $this->assertEquals([[], []], $this->invokeMethodConsecutive($this, 'getConstructorArguments', [[], []]));
    }
}
