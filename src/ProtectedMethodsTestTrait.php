<?php

namespace Cybalex\TestHelpers;

use ReflectionClass;
use ReflectionException;

trait ProtectedMethodsTestTrait
{
    use TestHelperConstraintTrait;

    /**
     * ProtectedMethodsTestTrait constructor.
     *
     * @param null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        
        $this->checkContext();
    }

    /**
     * Call protected method of a class.
     *
     * @param object $object
     * @param string $methodName
     * @param array $parameters
     *
     * @return mixed
     *
     * @throws ReflectionException
     */
    public function invokeMethod(object $object, string $methodName, array $parameters = [])
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * Call protected method of a class the given number of times.
     * The number of calls depends on the length of the array of parameters.
     *
     * @param object $object $object
     * @param string $methodName
     * @param array $parametersArray An array of arrays of parameters.
     *
     * @param int $callTimes
     * @return array Array of method invocation results.
     *
     * @throws ReflectionException
     */
    public function invokeMethodConsecutive(
        object $object,
        string $methodName,
        array $parametersArray
    ): array {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        $resultArray = [];

        foreach ($parametersArray as $parameters) {
            $resultArray[] = $method->invokeArgs($object, $parameters);
        }

        return $resultArray;
    }
}
