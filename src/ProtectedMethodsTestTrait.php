<?php

namespace Cybalex\TestHelpers;

class ProtectedMethodsTestTrait
{
    /**
     * Call protected method of a class.
     *
     * @param object $object
     * @param string $methodName
     * @param array $parameters
     *
     * @return mixed
     *
     * @throws \ReflectionException
     */
    public function invokeMethod($object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
