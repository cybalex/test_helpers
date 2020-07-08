<?php

namespace Cybalex\TestHelpers;

use ReflectionClass;
use ReflectionException;

/**
 * @author Zymovets Oleksii <cybalex87@gmail.com>
 */
trait ProtectedMethodsTestTrait
{
    /**
     * Call protected method of a class.
     *
     * @param mixed $object
     *
     * @return mixed
     *
     * @throws ReflectionException
     */
    public function invokeMethod($object, string $methodName, array $parameters = [])
    {
        $reflection = new ReflectionClass(\get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * Call protected method of a class the given number of times.
     * The number of calls depends on the length of the array of parameters.
     *
     * @param mixed $object
     * @param string $methodName
     * @param array $parametersArray an array of arrays of parameters
     *
     * @return array array of method invocation results
     *
     * @throws ReflectionException
     */
    public function invokeMethodConsecutive(
        $object,
        string $methodName,
        array $parametersArray
    ): array {
        $reflection = new ReflectionClass(\get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        $resultArray = [];

        foreach ($parametersArray as $parameters) {
            $resultArray[] = $method->invokeArgs($object, $parameters);
        }

        return $resultArray;
    }
}
